# Unifi Controller on a Raspberry Pi
I get a lot of questions how people have to install the Unifi Controller software on a Raspberry Pi. This is not a big deal and can be easily done by a few steps. And please remember, this is how I do it, there are some other possibilites.

## All based on the "RASPBIAN STRETCH LITE" updated and fully setted image

#### 1. We need to add the UniFi source to our list
```
echo 'deb http://www.ubnt.com/downloads/unifi/debian stable ubiquiti' | sudo tee -a /etc/apt/sources.list.d/ubnt.list > /dev/null
```
#### 2. The new stretch image need dirmgr to add our validation key
```
sudo apt-get install dirmngr
```
#### 3. Time to get the validation done
```
sudo apt-key adv --keyserver keyserver.ubuntu.com --recv C0A52C50
```
#### 4. Update our repository so the raspberry recognizes the new source
```
sudo apt-get update
```
#### 5. Now we can simple install our UniFi Controller with one command
```
sudo apt-get install unifi
```
#### 6. Not nice, but we need openjdk 8 for the controller
```
sudo apt-get install install openjdk-8-jre-headless
```
#### 7. Get rid of the old mongodb and stopped it
```
sudo systemctl stop mongodb
```
```
sudo systemctl disable mongodb
```
#### 8. Finally we reboot our raspberry as always
```
sudo reboot
```
This reboot can take two or three minutes until the controller is fully loaded and reachable. After a cup of coffee you can point your browser to ```https://localhost:8443``` and start with your controller setup.
