## There is a new version available!!!
Voucher Service Pro for UniFi is a modern and extremely customizable ticket system including printing and network options. Based on the phenomenal and affordable Raspberry Pi. https://shop.sass-projects.info/
(July 5th, 2021)

# UniFi Voucher System v2 - Touchscreen with Brother printer
I did a complete W-LAN installation on a campsite. But the Hotspot Manager that comes with the **UniFi Controller** was not very useful and a bit laborious to work with. I wanted a very simple all in one solution like, "Press one button and nothing else" to get a voucher printed and automatically insert the information to the UniFi Controller, that guests are able to join the network. I made a little video to introduce what this project does.

Youtube Video: https://www.youtube.com/watch?v=23y2rxoWPfo

## Based on the Raspbian Buster Lite image
- Based on the "RASPBIAN BUSTER LITE"
- Minimal image based on Debian Buster
- Version: September 2019
- Release date: 2019-09-26

Download image: https://downloads.raspberrypi.org/raspbian_lite_latest

## Based on the following driver/releases
- Brother_ql version: 0.9.4
- UniFi Controller version: 5.11.50
- UniFi API-client version: 1.1.42

## Based on the following hardware
- Raspberry Pi 3 B+ (B Plus) with 3A Power Supply with Heatsinks
- Raspberry Pi Supply Switch On/Off 
- Raspberry Pi 7" Touchscreen Display and Case (Official)
- Brother QL-700 High-speed Professional Label Printer
- Brother DK-11209 Adress Label Small 62x29mm
- Two simple push buttons

## 1. We will start with a fresh image on our Raspbian Pi

#### Change your password, network settings, localisation, expand the file system and enable SSH
```
sudo raspi-config
```
#### Get the latest updates since the image was released
```
sudo apt-get update && sudo apt-get upgrade
```
#### It is always a good idea to have a synced system clock
```
sudo apt-get install ntp ntpdate
```
#### Reboot your Raspberry Pi to accept and reload all changes
```
sudo reboot
```

## 2. Now for our ticket system we need a lightweight GUI

#### We start with installing our GUI and Desktop environment
```
sudo apt-get install xinit
```
```
sudo apt-get install lxde-core lxterminal lxappearance
```
```
sudo apt-get install lightdm
```
```
sudo reboot
```
**Optional:** If you like to work over a VNC server like RealVNC.
```
sudo apt-get install realvnc-vnc-server realvnc-vnc-viewer
```
Remember to enable the VNC Server over ```sudo raspi-config``` and reboot. (5 Interfacing Options - P3 VNC - Yes)

## 3. We also need a LAMP Server - Apache, PHP7 and MariaDB

#### I prefer MariaDB over MySQL, but feel free to use what you want.
```
sudo apt-get install mariadb-server mariadb-client
```
#### It is also important that we secure our mariadb
```
sudo mysql_secure_installation
```
Secure installation:
- No current password: **just hit return**
- Set root password: **Y**
- Enter your MariaDB root password: **yourpassword**
- Remove anonymous user: **Y**
- Disallow root login remote: **Y**
- Remove test database: **Y**
- Reload privilege table: **Y**
#### Apache is available as a debian package, so just go with
```
sudo apt-get install apache2
```
```
sudo apt-get install php7.3 libapache2-mod-php7.3
```
#### I like to install some common apache modules for php/db support and keep it small and simple
```
sudo apt-get install php7.3-mysql php7.3-curl php7.3-gd php7.3-intl php-pear php-imagick php7.3-imap php-memcache php7.3-pspell php7.3-recode php7.3-sqlite3 php7.3-tidy php7.3-xmlrpc php7.3-xsl
```
#### Just to make sure ImageMagick is installed correct
```
sudo apt-get install imagemagick
```
#### Finally we need to restart apache
```
sudo service apache2 restart
```

## 4. To have access to our voucher page we need a webbrowser

#### Again, I go with chromium but you can also use midori, gnome web or vivaldi it is your choice
```
sudo apt-get install rpi-chromium-mods
```
```
sudo apt-get install python-sense-emu python3-sense-emu
```

## 4.1 Optional: UniFi Controller Software on the raspberry

#### If you want to run the UniFi Controller on the same raspberry you can follow my short guide.

How-To: https://github.com/PaintSplasher/unifi-voucher-service/blob/master/howto-controller.md

## 5. Time for the printer - make sure your "editor lite" mode is disabled (led off)

#### First we need some packaged dependencies for our labels
```
sudo apt-get install python3-setuptools python3-pip libopenjp2-7-dev libtiff5 git fontconfig
```
#### Get the nice printer package from pklaus
```
sudo pip3 install --upgrade brother_ql
```
The brother_ql Python package provides the foundations for this project and enables driving QL series label printers without the usually required printer drivers. The upgrade flag makes sure, you get the latest version. So this is perfect!
#### Our "Pi" account need access to the "lp" group
```
sudo usermod -G lp -a pi
```
#### It is necessary to log out and then back in again or reboot your Raspberry Pi
```
sudo reboot
```
#### Finally we are able to see some success, put my test label to your Desktop
```
cd /home/pi/Desktop
```
If you get ```No such file or directory``` than you have to login once into your GUI to create the folders.
```
sudo wget https://raw.githubusercontent.com/PaintSplasher/unifi-voucher-service/master/codeimage/test-print.png
```
To identify your printer at your usb-port type
```
lsusb
```
You should see something like ```Bus 001 Device 004: ID 04f9:2042 Brother Industries, Ltd```, write down your ID.
```
sudo brother_ql -p usb://04f9:2042 -m QL-700 print -l 62x29 test-print.png
```
Your printer should now have a happy notice printed for you. Your printer ID depends on how many usb devices you have connected or which port you use, change the ID if necessary.

## 5.1 Optional: If you want a web service to print labels

#### Just to make sure fontconfig is installed correct
```
sudo apt-get install fontconfig
```
```
cd /usr/src
```
```
sudo git clone https://github.com/pklaus/brother_ql_web.git
```
```
cd brother_ql_web
```
```
sudo pip3 install -r requirements.txt
```
```
sudo cp config.example.json config.json
```
#### It is necessary to set some information to our config.json
```
sudo nano config.json
```
As always it is up to you, if you want to change the port to :80 or :1337 or whatever. I go with standard :8013. Also if you don't have the QL-700 you should also change the model and remember your printer ID.
```php
"PORT": 8013 , "HOST": "localhost" , "MODEL": "QL-700" , "PRINTER": "usb://04f9:2042"
```
#### We can start our service now
```
sudo python3 brother_ql_web.py
```
Afterwards pointing a browser at the Raspberry Pi to http://localhost:8013 - You should get the user interface and be able to print any text you want. Hit ```STRG+C``` to end the service and we can go on.
#### To start the service automatically at boot edit /etc/rc.local
```
sudo nano /etc/rc.local
```
And add before "exit 0":
```
cd /usr/src/brother_ql_web; /usr/bin/python3 brother_ql_web.py&
```
#### Just to make sure it is executable
```
sudo chmod +x /etc/rc.local
```

## 6. Time to spend some time on our voucher page

#### We go to our webroot and pull the package
```
cd /var/www/html/
```
```
sudo git clone https://github.com/PaintSplasher/unifi-voucher-service.git
```
I made two touchscreen pages you can use - Pointing your browser to version 1 or version 2 to see the difference.
- Version 1: predefined vouchers
```
http://localhost/unifi-voucher-service/index.php
```
- Version 2: custom vouchers
```
http://localhost/unifi-voucher-service/index_custom.php
```
To change your personal voucher settings I did a uvs_config.php file and described everything. 
```
sudo nano /var/www/html/unifi-voucher-service/uvs_config.php
```

## 7. Of course we need access to Ubiquiti's UniFi Controller API

#### We clone the package to our Raspberry Pi
```
cd /usr/src/
```
```
sudo git clone https://github.com/Art-of-WiFi/UniFi-API-client.git
```
#### Now we copy our needed config to our own folder and edit all needed information
```
sudo cp /usr/src/UniFi-API-client/examples/site_provisioning_example/config.template.php /var/www/html/unifi-voucher-service/config.php
```
```
sudo nano /var/www/html/unifi-voucher-service/config.php
```
Fill in your UniFi Controller "Username", Password", "URL" and "Version". Debug mode leave it on false.

## 8. Preparation to solve some issues before we are able to get access

It is important that we are able to execute "php to shell" so it is working between UniFi Controller and our landing page.
#### Set the user/group "pi" as an owner for /var/www/html
```
sudo chown pi -R /var/www/html && sudo chgrp pi -R /var/www/html
```
```
sudo chmod 777 -R /var/www/html/unifi-voucher-service/codeimage
```
#### Needed to execute sudo commands out of a php file
```
sudo nano /etc/sudoers
```
And add after "User privilege specification"
```
www-data ALL=(ALL) NOPASSWD: ALL
```

## 9. The final touch!!!

After we push the "on" button on our Raspberry Pi we want to land directly on our unifi-voucher-service page without any input in fullscreen.
#### Unclutter to get rid of our mouse on a touchscreen
```
sudo apt-get install unclutter
```
#### Edit the autostart so we do not have any work to do after we pushed the button
```
sudo nano /home/pi/.config/lxsession/LXDE/autostart
```
And add
```
@xset -dpms
@unclutter
@chromium-browser --kiosk http://localhost/unifi-voucher-service
```
#### To automatically login
```
sudo raspi-config
```
Go to 3 Boot Option - B1 Desktop / CLI - B4 Desktop Autologin Desktop GUI, automatically logged in as "pi" user. Finish and reboot.

## Congratulation, you are done!

## 10. Optional: If you also have the Pi-Supply-Switch we need a special script

#### Install and setup the softshut.py - afterwards the Raspberry Pi will shutdown
```
curl -sSL https://pisupp.ly/piswitchcode | sudo bash
```

## Do you have any suggestions or need help?
Please use the github [issue](https://github.com/PaintSplasher/unifi_touch_printer/issues) list or the Ubiquiti Community forums (https://community.ubnt.com/t5/UniFi-Stories/Unifi-Raspberry-Label-printer-with-touchscreen-Campsite/cns-p/2355393) to share your ideas/questions.

## Credits
A big thank you and credits goes to:
- Art-of-WiFi: https://github.com/Art-of-WiFi/UniFi-API-client
- pklaus: https://github.com/pklaus/brother_ql_web
- aojeda: @Ubiquiti Community
