<?php
/*
 * UniFi Voucher Service v1.0
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
echo "<button type=\"submit\" name=\"1-day-fastpass\" id=\"1-day-fastpass\">";
echo "<img src=\"assets/img/done_printing.png\" class=\"img-responsive\" />";
echo "</button>";

// Fonts convert function for the printing voucher
function create_printimage($t1, $t2, $t3, $t4, $t5, $t6) {

   $im=imagecreate(696,271);
   $background_color = imagecolorallocate($im, 255, 255, 255);
   $text_color = imagecolorallocate($im, 0, 0, 0);

   $font = $uvs_docroot . "/var/www/html/". $uvs_folder ."/codes/montserrat-regular.otf";

   $color = imagecolorallocate($im, 0, 0, 0);

   imagettftext($im, 64, 0, 85, 115, $color, $font, $t1);
   imagettftext($im, 20, 0, 210, 236, $color, $font, $t2);
   imagettftext($im, 20, 0, 169, 205, $color, $font, $t3);
   imagettftext($im, 30, 0, 135, 165, $color, $font, $t4);
   imagettftext($im, 26, 0, 160, 30, $color, $font, $t5);
   imagettftext($im, 20, 0, 140, 266, $color, $font, $t6);

   imagepng($im, "/var/www/html/". $uvs_folder ."/codeimage/voucher.png");

}

// Initialize the UniFi API connection class and log in to the controller
$unifi_connection = new UniFi_API\Client($controlleruser, $controllerpassword, $controllerurl, $uvs_1dp_site_id, $controllerversion);
$set_debug_mode   = $unifi_connection->set_debug($debug);
$loginresults     = $unifi_connection->login();

// Then we create the voucher with the requested expiration value and settings
$voucher_result = $unifi_connection->create_voucher($uvs_1dp_expiration, $uvs_1dp_count, $uvs_1dp_quota, $uvs_1dp_note, $uvs_1dp_up, $uvs_1dp_down, $uvs_1dp_limit);

// We then fetch the newly created vouchers by the create_time returned
$vouchers = $unifi_connection->stat_voucher($voucher_result[0]->create_time);

// Time to collect all information and limits
$t1 = $vouchers[0]->code;
$t1 = substr($t1,0,5) . "-" . substr($t1,5,5);
$t2 = $uvs_upload . " " . $vouchers[0]->qos_rate_max_up . " " . $uvs_uprate;
$t3 = $uvs_download . " " . $vouchers[0]->qos_rate_max_down . " " . $uvs_uprate;
$t4 = $uvs_expiration ." " . (($vouchers[0]->duration) / 60) . " " . $uvs_hours;
$t5 = $vouchers[0]->note;
$t6 = $uvs_quota ." ". $vouchers[0]->quota . " " . $uvs_usages;

// Create the image to print
create_printimage($t1, $t2, $t3, $t4, $t5, $t6);

// Create the voucher and collect all information
shell_exec( "sudo brother_ql_create -m " . $uvs_printer . " -s " . $uvs_labelsize . " /var/www/html/" . $uvs_folder . "/codeimage/voucher.png > /var/www/html/" . $uvs_folder . "/codeimage/printfile.bin" );

// Send the print command to the printer
shell_exec( "sudo brother_ql_print /var/www/html/" . $uvs_folder . "/codeimage/printfile.bin /dev/usb/lp" . $uvs_usbport . "" );

// Reload the page after the print was successful
echo "<script type=\"text/javascript\">setTimeout(\"document.location.reload();\",3000);</script>";

?>