<?php
/**
 * Error Notifier plugin for Craft CMS 3.x
 *
 * Sending mails if an error occurred.
 *
 * @link      https://www.bitbox.de
 * @copyright Copyright (c) 2018 bitbox GmbH & Co. KG
 */

namespace bitboxde\errornotifier;

use bitboxde\errornotifier\services\HandleException;
use bitboxde\errornotifier\models\Settings;

use craft\events\ExceptionEvent;
use craft\helpers\UrlHelper;
use craft\web\ErrorHandler;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;

use yii\base\Event;

/**
 * Class ErrorNotifier
 *
 * @author    bitbox GmbH & Co. KG
 * @package   ErrorNotifier
 * @since     1.0.0
 *
 */
class ErrorNotifier extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var ErrorNotifier
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        // Register Components (Services)
        $this->setComponents([
            'handleException' => HandleException::class,
        ]);

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                    Craft::$app->response->redirect(UrlHelper::cpUrl('settings/plugins/error-notifier'))->send();
                }
            }
        );

        Event::on(
            ErrorHandler::class,
            ErrorHandler::EVENT_BEFORE_HANDLE_EXCEPTION,
            function (ExceptionEvent $event) {
                $this->handleException->handleException($event->exception);
            }
        );

        Craft::info(
            Craft::t(
                'error-notifier',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * @inheritdoc
     */
    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'error-notifier/settings',
            [
                'settings' => $this->getSettings()
            ]
        );
    }
}
