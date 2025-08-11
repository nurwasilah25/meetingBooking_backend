<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
  | -------------------------------------------------------------------
  | DECLARE VARIABEL GLOBAL
  | -------------------------------------------------------------------
  |
  |
 */ 

//Wasil 5 Agst 2025

$config['isMaintenance'] = 0;
$config['isNotificationActive'] = 1;
$config['website_title'] = "FTL Imeeting";
$config['isAdmin'] = "admin";
$config['themes'] = "default";

/*$config['ip_address'] = "http://192.168.4.29/";
$config['url_cheers_attachment'] = 'http://192.168.56.1/api_360pa/file_upload/cheersattachment/';
$config['url_profil_pic'] = 'https://apps.skeenaturology.com/file_upload/pasien/';
$config['filepath_ideas_attachment'] = realpath('./file_upload/ideasattachment');
$config['filepath_cheers_attachment'] = realpath('./file_upload/cheersattachment');*/

$config['separator'] = sprintf("%s\%s", '', ''); //Windows
//$config['separator'] = sprintf("%s/%s",'',''); //Linux

date_default_timezone_set("Asia/Jakarta");

$dbPrefix = 'ftl_imeeting.';

$config['tmst_room']        = $dbPrefix . 'tmst_room';
$config['tmst_unit']        = $dbPrefix . 'tmst_unit';
$config['tmst_typevar']     = $dbPrefix . 'tmst_typevar';
$config['ttrs_booking_meeting']     = $dbPrefix . 'ttrs_booking_meeting';

/* End of file tabel.php */
/* Location: ./application/config/tabel.php */
