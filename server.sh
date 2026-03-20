sudo apt install apache2 php
sudo ln -s /var/www/beacon /var/www/html/beacon
sudo systemctl restart apache2
# or use php built-in server
php -S 0.0.0.0:8080 -t /var/www/beacon
