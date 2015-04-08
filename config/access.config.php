<?php

/*
 * admi type 'master', 'super', 'normal'
 * print_r($_SERVER['SCRIPT_NAME']);
 * [SCRIPT_FILENAME] => /home/bluetest/public_html/cmsplateform/admin/index.php
 * OR
 * [SCRIPT_NAME] => /cmsplateform/admin/post/index.php
 */

$notAllow['master'] = array();

/* super user not allow file list */
$notAllow['super'] = array();
$notAllow['super'][] = 'admin/admin/index.php';
$notAllow['super'][] = 'admin/settings/settings_option.php';
$notAllow['super'][] = 'admin/settings/settings_option.php';
$notAllow['super'][] = 'admin/admin/admin_edit.php';
/* // super user not allow file list */

/* normal user not allow file list */
$notAllow['normal'] = array();
$notAllow['normal'][] = 'admin/admin/index.php';
$notAllow['normal'][] = 'admin/settings/settings_option.php';
$notAllow['normal'][] = 'admin/settings/settings_option.php';
$notAllow['normal'][] = 'admin/settings/phpmailer_setting.php';
$notAllow['normal'][] = 'admin/settings/settings_option_list.php?del=yes';
$notAllow['normal'][] = 'admin/admin/admin_edit.php';
/* // normal user not allow file list */
?>
