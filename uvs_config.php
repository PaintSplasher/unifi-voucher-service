<?php
/*
 * UniFi Voucher Service v2.0
 * Copyright 2018 Sass-Projects (https://www.sass-projects.info)
 * Licensed under GNU General Public License v3.0
 * (https://github.com/PaintSplasher/unifi-voucher-service/blob/master/README.md)
*/

/* Voucher front page */
$uvs_title          =   'ittdesk voucher service'; // The title of your voucher page
$uvs_subtitle       =   'Kies alstublieft een voucher'; // Here you can write down your subtitle or some comment

/* Translate if you want */
$uvs_quota          =   ''; // Quota
$uvs_usages         =   'A'; // Usages
$uvs_hours          =   'Uur';
$uvs_day            =   'Dag';
$uvs_days           =   'Dagen';
$uvs_expiration     =   ''; // Valid for
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


/* 1 dag 1 gebruiker */
$uvs_1d1u_site_id    =   'default'; // The site where you want to create the voucher
$uvs_1d1u_note       =   '1 dag - 1 gebruiker'; // Note on the voucher
$uvs_1d1u_expiration =   1440; // Expiration Time (1 Day = 1440)
$uvs_1d1u_quota      =   1; // 1 = One time, 2 = Multi use
$uvs_1d1u_up         =   null; // Bandwidth Limit Upload in kbits
$uvs_1d1u_down       =   null; // Bandwidth Limit Download in kbits
$uvs_1d1u_limit      =   null; // Byte Quota per use in MB (null=unlimited)
$uvs_1d1u_count      =   1; // How many vouchers - WARNING: Currently we can send just 1 voucher to the printer, so keep it for now.

/* 1 dag 2 gebruikers */
$uvs_1d2u_site_id    =   'default'; // The site where you want to create the voucher
$uvs_1d2u_note       =   '1 dag - 2 gebruikers'; // Note on the voucher
$uvs_1d2u_expiration =   1440; // Expiration Time (1 Day = 1440)
$uvs_1d2u_quota      =   2; // 1 = One time, 2 = Multi use
$uvs_1d2u_up         =   null; // Bandwidth Limit Upload in kbits
$uvs_1d2u_down       =   null; // Bandwidth Limit Download in kbits
$uvs_1d2u_limit      =   null; // Byte Quota per use in MB (null=unlimited)
$uvs_1d2u_count      =   1; // How many vouchers - WARNING: Currently we can send just 1 voucher to the printer, so keep it for now.

/* 7 dagen 1 gebruiker */
$uvs_7d1u_site_id    =   'default'; // The site where you want to create the voucher
$uvs_7d1u_note       =   '7 dagen - 1 gebruiker'; // Note on the voucher
$uvs_7d1u_expiration =   10080; // Expiration Time (1 Week = 10080)
$uvs_7d1u_quota      =   1; // 1 = One time, 2 = Multi use
$uvs_7d1u_up         =   null; // Bandwidth Limit Upload in kbits
$uvs_7d1u_down       =   null; // Bandwidth Limit Download in kbits
$uvs_7d1u_limit      =   null; // Byte Quota per use in MB (null=unlimited)
$uvs_7d1u_count      =   1; // How many vouchers - WARNING: Currently we can send just 1 voucher to the printer, so keep it for now.

/* 7 dagen 2 gebruikers */
$uvs_7d2u_site_id    =   'default'; // The site where you want to create the voucher
$uvs_7d2u_note       =   '7 dagen - 2 gebruikers'; // Note on the voucher
$uvs_7d2u_expiration =   10080; // Expiration Time (1 Week = 10080)
$uvs_7d2u_quota      =   2; // 1 = One time, 2 = Multi use
$uvs_7d2u_up         =   4000; // Bandwidth Limit Upload in kbits
$uvs_7d2u_down       =   28800; // Bandwidth Limit Download in kbits
$uvs_7d2u_limit      =   null; // Byte Quota per use in MB (null=unlimited)
$uvs_7d2u_count      =   1; // How many vouchers - WARNING: Currently we can send just 1 voucher to the printer, so keep it for now.

/* 31 dagen 1 gebruiker */
$uvs_31d1u_site_id    =   'default'; // The site where you want to create the voucher
$uvs_31d1u_note       =   '31 dagen - 1 gebruiker'; // Note on the voucher
$uvs_31d1u_expiration =   44640; // Expiration Time (1 Month = 44640)
$uvs_31d1u_quota      =   1; // 1 = One time, 2 = Multi use
$uvs_31d1u_up         =   null; // Bandwidth Limit Upload in kbits
$uvs_31d1u_down       =   null; // Bandwidth Limit Download in kbits
$uvs_31d1u_limit      =   null; // Byte Quota per use in MB (null=unlimited)
$uvs_31d1u_count      =   1; // How many vouchers - WARNING: Currently we can send just 1 voucher to the printer, so keep it for now.

/* 31 day fastpass */
$uvs_31d2u_site_id    =   'default'; // The site where you want to create the voucher
$uvs_31d2u_note       =   '31 dagen - 2 gebruikers'; // Note on the voucher
$uvs_31d2u_expiration =   44640; // Expiration Time (1 Month = 44640)
$uvs_31d2u_quota      =   2; // 1 = One time, 2 = Multi use
$uvs_31d2u_up         =   4000; // Bandwidth Limit Upload in kbits
$uvs_31d2u_down       =   28800; // Bandwidth Limit Download in kbits
$uvs_31d2u_limit      =   null; // Byte Quota per use in MB (null=unlimited)
$uvs_31d2u_count      =   1; // How many vouchers - WARNING: Currently we can send just 1 voucher to the printer, so keep it for now.

?>
