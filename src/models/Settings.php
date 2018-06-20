<?php
/**
 * Error Notifier plugin for Craft CMS 3.x
 *
 * Sending mails if an error occurred.
 *
 * @link      https://www.bitbox.de
 * @copyright Copyright (c) 2018 bitbox GmbH & Co. KG
 */

namespace bitboxde\errornotifier\models;

use Craft;
use craft\base\Model;

/**
 * @author    bitbox GmbH & Co. KG
 * @package   ErrorNotifier
 * @since     1.0.0
 */
class Settings extends Model
{
    /**
     * @var string
     */
    public $recievers = '';

    /**
     * @var string
     */
    public $sender = '';

    /**
     * @var string
     */
    public $emailPrefix = '[ERROR]';

    /**
     * @var string
     */
    public $environments = 'dev,production';

    /**
     * @var bool
     */
    public $enabled = true;

    /**
     * @var bool
     */
    public $notFound = false;

    /**
     * @var bool
     */
    public $serverVars = true;

    /**
     * @var bool
     */
    public $userVars = true;

    /**
     * @var bool
     */
    public $sessionVars = true;

    /**
     * @var bool
     */
    public $cookieVars = true;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['recievers', 'validateRecievers'],
            ['recievers', 'required'],
            ['sender', 'email'],
            ['sender', 'required'],
            ['environments', 'required']
        ];
    }

    public function validateRecievers($attribute)
    {
        $value = $this->$attribute;

        if(trim($value) !== '') {
            $recievers = array_map('trim', explode(',', $value));

            foreach($recievers as $reciever) {
                if(!filter_var($reciever, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($attribute, Craft::t('error-notifier', 'At least one email address is not valid.'));
                }
            }
        }
    }
}
