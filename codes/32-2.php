<?php
/*
 * UniFi Voucher Service v2.0
 * Copyright 2018 Sass-Projects (https://www.sass-projects.info)
 * Licensed under GNU General Public License v3.0
 * (https://github.com/PaintSplasher/unifi-voucher-service/blob/master/README.md)
*/

// Include the Unifi Voucher Service config file
require_once ('../uvs_config.php');

// Using the git Client.php
require_once ('/usr/src/UniFi-API-client/src/Client.php');

// Include the config file (place your credentials etc. there if not already present)
require_once ('../config.php');

// Change the button if the voucher is printed
echo "<button type=\"submit\" name=\"1-week-free\" id=\"1-week-free\">";
echo "<img src=\"assets/img/done_printing.png\" class=\"img-responsive\" />";
echo "</button>";

// Fonts convert function for the printing voucher
function create_printimage($t1, $t2, $t3, $t4, $t5, $t6, $t7, $t8) {
   
    include  ('../uvs_config.php');
 
    $im = imagecreate(696,271);
    $background_color = imagecolorallocate($im, 255, 255, 255);
    $text_color = imagecolorallocate($im, 0, 0, 0);
    $font = "/var/www/html/". $uvs_folder ."/codes/montserrat-regular.otf";
    $color = imagecolorallocate($im, 0, 0, 0);
 
    imagettftext($im, 45, 0, 290, 160, $color, $font, $t1);
    imagettftext($im, 20, 0, 54, 245, $color, $font, $t2);
    imagettftext($im, 20, 0, 54, 174, $color, $font, $t3);
    imagettftext($im, 20, 0, 54, 96, $color, $font, $t4);
    imagettftext($im, 25, 0, 360, 200, $color, $font, $t5);
    imagettftext($im, 20, 0, 275, 255, $color, $font, $t6);
    imagettftext($im, 25, 0, 12, 38, $color, $font, $t7);
    imagettftext($im, 20, 0, 380, 255, $color, $font, $t8);
 
    imagepng($im, "/var/www/html/". $uvs_folder ."/codeimage/voucher.png");
 
 }

// Initialize the UniFi API connection class and log in to the controller
$unifi_connection = new UniFi_API\Client($controlleruser, $controllerpassword, $controllerurl, $uvs_7df_site_id, $controllerversion);
$set_debug_mode   = $unifi_connection->set_debug($debug);
$loginresults     = $unifi_connection->login();

// Then we create the voucher with the requested expiration value and settings
$voucher_result = $unifi_connection->create_voucher($uvs_7df_expiration, $uvs_7df_count, $uvs_7df_quota, $uvs_7df_note, $uvs_7df_up, $uvs_7df_down, $uvs_7df_limit);

// We then fetch the newly created vouchers by the create_time returned
$vouchers = $unifi_connection->stat_voucher($voucher_result[0]->create_time);

// To get a SSID and the needed key for our guest VLAN
$wlan_array = $unifi_connection->list_wlanconf();
    foreach ($wlan_array as $wlan) {
        if ($wlan->vlan === $uvs_vlan) {
            $wlan_ssid = $wlan->name;
        }
    }

// Time to collect all information and limits
$t1 = $vouchers[0]->code;
$t1 = substr($t1,0,5) . "-" . substr($t1,5,5);
$t2 = $uvs_upload . " " . $vouchers[0]->qos_rate_max_up . " " . $uvs_uprate;
$t3 = $uvs_download . " " . $vouchers[0]->qos_rate_max_down . " " . $uvs_uprate;
$t4 = $uvs_expiration ." " . (($vouchers[0]->duration) / 1440) . " " . $uvs_days;
$t5 = $vouchers[0]->note;
$t6 = $uvs_quota ." ". $vouchers[0]->quota . " " . $uvs_usages;
$t7 = $uvs_wifissid . " " . $wlan_ssid;
$t8 = (date("d.m.Y", $vouchers[0]->create_time) . " at " . date("h:iA", $vouchers[0]->create_time));

// Create the image to print
create_printimage($t1, $t2, $t3, $t4, $t5, $t6, $t7, $t8);

// Composition of some outlines and all voucher information
shell_exec( "sudo /usr/bin/convert ../codeimage/voucher.png ../codeimage/outlines.png -composite ../codeimage/voucher_final.png" );

// To get rid of some ASCII issues with python
setlocale(LC_ALL,"C.UTF-8");
putenv("LC_ALL=C.UTF-8");
putenv("LANG=C.UTF-8");

// Collect all information and send the print command
shell_exec("sudo brother_ql -p usb://" . $uvs_usbid . " -m " . $uvs_printer . " print -l " . $uvs_labelsize . " /var/www/html/" . $uvs_folder . "/codeimage/voucher_final.png");

// Reload the page after the print was successful
echo "<script type=\"text/javascript\">setTimeout(\"document.location.reload();\",3000);</script>";

?>
