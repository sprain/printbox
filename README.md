## Installation
1. Take a Raspberry Pi with an [installed Raspbian](https://www.raspberrypi.org/downloads/) and a [WiFi dongle](https://www.raspberrypi.org/products/usb-wifi-dongle/).
2. Connect Raspberry Pi via Ethernet to network.
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
7. Add WiFi settings and reboot Raspberry Pi. It should now connect to one of the defined WiFis, if available.
8. Add printer (via CUPS) and select printer to use.


## Send print job to Raspberry
```
curl -F "file=@/local/path/to/file.pdf" http://{ip-address}/app.php/print
```


## Update app

```
sudo sh /ticketpark/update.sh
```