# GET UPDATE
sudo rm -R /ticketpark/printbox
sudo git clone https://github.com/sprain/printbox.git /ticketpark/printbox

# INSTALL PRINTBOX APP
cd /ticketpark/printbox
composer install
php app/console doctrine:schema:update --force --env=prod
php app/console cache:clear --env=prod

# PREPARE NEW UPDATE SCRIPT
sudo cp /ticketpark/printbox/install/update.sh /ticketpark/update.sh

