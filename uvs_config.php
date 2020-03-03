<?php
/*
 * UniFi Voucher Service v2.0
 * Copyright 2018 Sass-Projects (https://www.sass-projects.info)
 * Licensed under GNU General Public License v3.0
 * (https://github.com/PaintSplasher/unifi-voucher-service/blob/master/README.md)
*/

/* Voucher front page */
$uvs_title          =   'ittdesk voucher service'; // The title of your voucher page
$uvs_subtitle       =   'Please choose a voucher to get access to our network!'; // Here you can write down your subtitle or some comment

/* Translate if you want */
$uvs_quota          =   ''; // Quota
$uvs_usages         =   'Gebruiker(s)'; // Usages
$uvs_hours          =   'Uur';
$uvs_day            =   'Dag';
$uvs_days           =   'Dagen';
$uvs_expiration     =   'Geldig voor'; // Valid for
$uvs_upload         =   ''; // Upload Bandwidth
$uvs_download       =   ''; // Download Bandwidth
$uvs_uprate         =   'Kbps';
$uvs_downrate       =   'Kbps';
$uvs_wifissid       =   'SSID:';

/* Optional changes */
$uvs_folder         =   'unifi-voucher-service'; // If you want to rename your folder
$uvs_printer        =   'QL-700'; // For more information about supported printers visit: https://pypi.org/project/brother_ql/
$uvs_labelsize      =   '62x29'; // For more information about supported labels visit: https://pypi.org/project/brother_ql/
$uvs_usbid          =   '04f9:2042'; // Remember your printer ID. To identify your printer at your usb-port type lsusb, as mention in step 5.
$uvs_vlan           =   '88'; // The VLAN ID of your guest network. (UniFi Controller - Settings - Wireless Networks)


/* 1 day free */
$uvs_1df_site_id    =   'default'; // The site where you want to create the voucher
$uvs_1df_note       =   'Free Access'; // Note on the voucher
$uvs_1df_expiration =   1440; // Expiration Time (1 Day = 1440)
$uvs_1df_quota      =   2; // 1 = One time, 2 = Multi use
$uvs_1df_up         =   2000; // Bandwidth Limit Upload in kbits
$uvs_1df_down       =   7200; // Bandwidth Limit Download in kbits
$uvs_1df_limit      =   null; // Byte Quota per use in MB (null=unlimited)
$uvs_1df_count      =   1; // How many vouchers - WARNING: Currently we can send just 1 voucher to the printer, so keep it for now.

/* 7 day free */
$uvs_7df_site_id    =   'default'; // The site where you want to create the voucher
$uvs_7df_note       =   'Free Access'; // Note on the voucher
$uvs_7df_expiration =   10080; // Expiration Time (1 Week = 10080)
$uvs_7df_quota      =   2; // 1 = One time, 2 = Multi use
$uvs_7df_up         =   2000; // Bandwidth Limit Upload in kbits
$uvs_7df_down       =   7200; // Bandwidth Limit Download in kbits
$uvs_7df_limit      =   null; // Byte Quota per use in MB (null=unlimited)
$uvs_7df_count      =   1; // How many vouchers - WARNING: Currently we can send just 1 voucher to the printer, so keep it for now.

/* 31 day free */
$uvs_31df_site_id    =   'default'; // The site where you want to create the voucher
$uvs_31df_note       =   'Free Access'; // Note on the voucher
$uvs_31df_expiration =   44640; // Expiration Time (1 Month = 44640)
$uvs_31df_quota      =   2; // 1 = One time, 2 = Multi use
$uvs_31df_up         =   2000; // Bandwidth Limit Upload in kbits
$uvs_31df_down       =   7200; // Bandwidth Limit Download in kbits
$uvs_31df_limit      =   null; // Byte Quota per use in MB (null=unlimited)
$uvs_31df_count      =   1; // How many vouchers - WARNING: Currently we can send just 1 voucher to the printer, so keep it for now.

/* 1 day fastpass */
$uvs_1dp_site_id    =   'default'; // The site where you want to create the voucher
$uvs_1dp_note       =   'Fastpass Access'; // Note on the voucher
$uvs_1dp_expiration =   1440; // Expiration Time (1 Day = 1440)
$uvs_1dp_quota      =   2; // 1 = One time, 2 = Multi use
$uvs_1dp_up         =   4000; // Bandwidth Limit Upload in kbits
$uvs_1dp_down       =   28800; // Bandwidth Limit Download in kbits
$uvs_1dp_limit      =   null; // Byte Quota per use in MB (null=unlimited)
$uvs_1dp_count      =   1; // How many vouchers - WARNING: Currently we can send just 1 voucher to the printer, so keep it for now.

/* 7 day fastpass */
$uvs_7dp_site_id    =   'default'; // The site where you want to create the voucher
$uvs_7dp_note       =   'Fastpass Access'; // Note on the voucher
$uvs_7dp_expiration =   10080; // Expiration Time (1 Week = 10080)
$uvs_7dp_quota      =   2; // 1 = One time, 2 = Multi use
$uvs_7dp_up         =   4000; // Bandwidth Limit Upload in kbits
$uvs_7dp_down       =   28800; // Bandwidth Limit Download in kbits
$uvs_7dp_limit      =   null; // Byte Quota per use in MB (null=unlimited)
$uvs_7dp_count      =   1; // How many vouchers - WARNING: Currently we can send just 1 voucher to the printer, so keep it for now.

/* 31 day fastpass */
$uvs_31dp_site_id    =   'default'; // The site where you want to create the voucher
$uvs_31dp_note       =   'Fastpass Access'; // Note on the voucher
$uvs_31dp_expiration =   44640; // Expiration Time (1 Month = 44640)
$uvs_31dp_quota      =   2; // 1 = One time, 2 = Multi use
$uvs_31dp_up         =   4000; // Bandwidth Limit Upload in kbits
$uvs_31dp_down       =   28800; // Bandwidth Limit Download in kbits
$uvs_31dp_limit      =   null; // Byte Quota per use in MB (null=unlimited)
$uvs_31dp_count      =   1; // How many vouchers - WARNING: Currently we can send just 1 voucher to the printer, so keep it for now.

?>
