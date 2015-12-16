# INSTALL PRINTBOX APP
cd /ticketpark/printbox
composer install
php app/console doctrine:schema:update --force --env=prod
php app/console cache:clear --env=prod
sudo setfacl -R -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs
sudo setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs

# REPLACE CONF SCRIPTS
sudo cp /ticketpark/printbox/install/etc/cups/cupsd.conf /etc/cups/cupsd.conf
sudo /etc/init.d/cups restart

sudo cp /ticketpark/printbox/install/etc/network/interfaces /etc/network/interfaces
sudo cp /ticketpark/printbox/install/etc/default/isc-dhcp-server /etc/default/isc-dhcp-server
sudo cp /ticketpark/printbox/install/etc/dhcp/dhcpd.conf /etc/dhcp/dhcpd.conf
sudo cp /ticketpark/printbox/install/etc/modprobe.d/8192cu.conf /etc/modprobe.d/8192cu.conf
sudo cp /ticketpark/printbox/install/etc/rc.local /etc/rc.local

# PREPARE UPDATE SCRIPT
sudo cp /ticketpark/printbox/install/update.sh /ticketpark/update.sh

