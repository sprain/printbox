# CHANGE TO HOME DIR (to avoid being within printbox dir which will be deleted)
cd ~

# GET UPDATE
sudo rm -R /ticketpark/printbox
sudo git clone https://github.com/sprain/printbox.git /ticketpark/printbox

# RUN NEWLY FETCHED UPDATE SCRIPT
. /ticketpark/printbox/install/run_update.sh