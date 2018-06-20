<?php
/**
 * Error Notifier plugin for Craft CMS 3.x
 *
 * Sending mails if an error occurred.
 *
 * @link      https://www.bitbox.de
 * @copyright Copyright (c) 2018 bitbox GmbH & Co. KG
 */

/**
 * Error Notifier config.php
 *
 * This file exists only as a template for the Error Notifier settings.
 * It does nothing on its own.
 *
 * Don't edit this file, instead copy it to 'craft/config' as 'error-notifier.php'
 * and make your changes there to override default settings.
 *
 * Once copied to 'craft/config', this file will be multi-environment aware as
 * well, so you can have different settings groups for each environment, just as
 * you do for 'general.php'
 */

return [
    'recievers'     => '',
    'sender'        => '',
    'emailPrefix'  => '[ERROR]',
    'environments'  => 'dev,production',
    'enabled'       => true,
    'notFound'      => false,
    'serverVars'    => true,
    'userVars'      => true,
    'sessionVars'   => true,
    'cookieVars'    => true
];
