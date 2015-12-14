# INSTALL APACHE
sudo apt-get install apache2 -y

# INSTALL PHP 5 (PHP 7 is yet a pain to install)
sudo apt-get install php5 libapache2-mod-php5 -y
sudo apt-get install php5-curl

# INSTALL SQLITE
sudo apt-get install sqlite3
sudo apt-get install php5-sqlite

# INSTALL COMPOSER
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# INSTALL PRINTBOX APP
cd /ticketpark/printbox
mkdir app/data
composer install
php app/console doctrine:database:create --env=prod
php app/console doctrine:schema:create --env=prod
php app/console cache:clear --env=prod
sudo setfacl -R -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs app/data
sudo setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs app/data


# CONFIGURE APACHE
sudo cp /ticketpark/printbox/install/etc/apache2/sites-enabled/000-default.conf /etc/apache2/sites-enabled/000-default.conf
sudo apachectl restart

# CONFIGURE WLAN SETTINGS
sudo cp /ticketpark/printbox/install/etc/network/interfaces /etc/network/interfaces