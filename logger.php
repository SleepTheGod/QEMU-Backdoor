<?php
// beacon-logger.php - simple access logger
$logfile = __DIR__ . '/beacon.log';
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$ua = $_SERVER['HTTP_USER_AGENT'] ?? '-';
$time = date('Y-m-d H:i:s');
$payload = file_get_contents('php://input') ?: ($_GET['q'] ?? $_POST['q'] ?? 'no payload');

$line = "[$time] $ip - $ua - $payload\n";
file_put_contents($logfile, $line, FILE_APPEND | LOCK_EX);

header('Content-Type: text/plain');
echo "pong";  // or return a command if you want
