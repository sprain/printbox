# UPDATE SYSTEM
sudo apt-get update
sudo apt-get upgrade

# INSTALL APACHE
sudo apt-get install apache2 -y

# INSTALL PHP 5 (PHP 7 is yet a pain to install)
sudo apt-get install php5 libapache2-mod-php5 -y
sudo apt-get install php5-curl

# INSTALL SQLITE
sudo apt-get install sqlite3
sudo apt-get install php5-sqlite

# INSTALL DHCP SERVER
sudo apt-get install isc-dhcp-server

# INSTALL PRINTING
sudo apt-get -y install cups
sudo usermod -a -G lpadmin pi
sudo cp /ticketpark/printbox/install/etc/cups/cupsd.conf /etc/cups/cupsd.conf
sudo /etc/init.d/cups restart

wget -O foo2zjs.tar.gz http://foo2zjs.rkkda.com/foo2zjs.tar.gz
tar zxf foo2zjs.tar.gz
cd foo2zjs
make
sudo make install
sudo make cups

# INSTALL COMPOSER
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# INSTALL PRINTBOX APP
cd /ticketpark/printbox
mkdir ../data
composer install
php app/console doctrine:database:create --env=prod
php app/console doctrine:schema:create --env=prod
php app/console cache:clear --env=prod
sudo setfacl -R -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs ../data
sudo setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs ../data

# CONFIGURE APACHE
sudo cp /ticketpark/printbox/install/etc/apache2/sites-enabled/000-default.conf /etc/apache2/sites-enabled/000-default.conf
sudo apachectl restart

# CONFIGURE WLAN SETTINGS
sudo cp /ticketpark/printbox/install/etc/network/interfaces /etc/network/interfaces
sudo cp /ticketpark/printbox/install/etc/default/isc-dhcp-server /etc/default/isc-dhcp-server
sudo cp /ticketpark/printbox/install/etc/dhcp/dhcpd.conf /etc/dhcp/dhcpd.conf
sudo cp /ticketpark/printbox/install/etc/modprobe.d/8192cu.conf /etc/modprobe.d/8192cu.conf
sudo cp /ticketpark/printbox/install/etc/rc.local /etc/rc.local
sudo update-rc.d -f isc-dhcp-server remove

# ADD CRONJOB
crontab -l | { cat; echo "* * * * * php /ticketpark/printbox/app/console printbox:heartbeat --env=prod > /dev/null 2>&1"; } | crontab -

# PREPARE UPDATE SCRIPT
sudo cp /ticketpark/printbox/install/update.sh /ticketpark/update.sh

