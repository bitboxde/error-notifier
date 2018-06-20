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
 * @author    bitbox GmbH & Co. KG
 * @package   ErrorNotifier
 * @since     1.0.0
 */
return [
    'General settings' => 'Allgemeine Einstellungen',
    'Email settings' => 'E-Mail Einstellungen',
    'Plugin is enabled' => 'Plugin ist aktiviert',
    'At least one email address is not valid.' => 'Mindestens eine E-Mail Adresse ist nicht gültig.',
    'Disable to stop sending emails.' => 'Deaktivieren um zu verhindern das E-Mails verschickt werden.',
    'Environments' => 'Environments (Umgebungen)',
    'Enter a comma separated list of environments, where Error Notifier should send emails.' => 'Kommaseparierte Liste von Environments für welche E-Mails verschickt werden sollen.',
    'Email recievers' => 'E-Mail Empfänger',
    'Enter a comma separated list of recievers. Note: If your enviroment has the "testToEmailAddress" setting, emails will only be sent to the "testToEmailAddress".' => 'Kommaseparierte Liste von E-Mail Empfänger. Hinweis: Wenn für ein Environment die Einstellung "testToEmailAddress" gesetzt wurde, werden E-Mails nur an "testToEmailAddress" geschickt.',
    'Check 404 "Not Found"' => 'Prüfe auf 404 "Not Found"',
    'If enabled, an email will be send on 404 Not Found. Note: This could cause massive email traffic.' => 'Schickt E-Mails bei 404 Not Found. Hinweis: Dies kann dazu führen das sehr viele E-Mails verschcikt werden.',
    'Email sender' => 'E-Mail Absenderadresse',
    'Sender email address.' => 'Absenderadresse zum versenden der E-Mails.',
    'Email prefix' => 'E-Mail Präfix',
    'Define a prefix for the email subject.' => 'Präfix für den Betreff der E-Mail.',
    'Insert server informations' => 'Informationen zum Server einfügen',
    'Based on $_SERVER' => 'Basierend auf $_SERVER',
    'Insert user informations' => 'Informationen zum Benutzer einfügen',
    'Based on Craft::$app->getUser()' => 'Basierend auf Craft::$app->getUser()',
    'Insert session informations' => 'Informationen zur Session einfügen',
    'Based on $_SESSION' => 'Basierend auf $_SESSION',
    'Insert cookie informations' => 'Informationen über Cookies einfügen',
    'Based on $_COOKIE' => 'Basierend auf $_COOKIE'
];
