## Look for Raspberry Pi on network
1. Take a Raspberry Pi via an [installed Raspbian](https://www.raspberrypi.org/downloads/).
2. Boot and connect Raspberry Pi via Ethernet to network.
3. On your computer, look for Raspberry Pi on network
    ```
    sudo nmap -sP 192.168.1.0/24 | awk '/^Nmap/{ip=$NF}/B8:27:EB/{print ip}'
    ```
4. Connect to Raspberry Pi via ssh `ssh pi@{ip-address}`
5. Install app
    ```
    sudo git clone https://github.com/sprain/printbox.git /ticketpark/printbox
    sudo sh /ticketpark/printbox/install.sh
    ```
6. Open `http://{ip-address}` in browser.
7. Add WLAN and reboot Raspberry PI.