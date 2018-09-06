<?php

namespace bitboxde\errornotifier\services;

use bitboxde\errornotifier\ErrorNotifier;

use Craft;
use craft\base\Component;
use craft\mail\Message;
use craft\web\ErrorHandler;

class HandleException extends Component
{
    private $settings;
    private $environment;
    private $pluginSettings;
    private $pluginEnvironments;

    public function __construct()
    {
        $this->settings = Craft::$app->systemSettings->getSettings('email');
        $this->environment = Craft::$app->getConfig()->env;
        $this->pluginSettings = ErrorNotifier::getInstance()->getSettings();
        $this->pluginEnvironments = array_map('trim', explode(',', $this->pluginSettings->environments));
    }

    public function handleException($exception)
    {
        $recievers = $this->getRecievers();

        if($recievers !== false && $this->pluginSettings->enabled && $this->checkEnvironment() && $this->checkNotFound($exception)) {
            $view = Craft::$app->getView();
            $oldTemplatesPath = $view->getTemplatesPath();
            $view->setTemplatesPath(ErrorNotifier::getInstance()->getBasePath());
            $body = $view->renderTemplate('/templates/mail/exception.html',
                [
                    'exception'      => $exception,
                    'exceptionName'  => $this->getExceptionName($exception),
                    'serverVars'     => $this->getServerVars(),
                    'userVars'       => $this->getUserVars(),
                    'sessionVars'    => $this->getSessionVars(),
                    'cookieVars'     => $this->getCookieVars(),
                    'pluginSettings' => $this->pluginSettings
                ]
            );
            $view->setTemplatesPath($oldTemplatesPath);

            $message = new Message();
            $message->setFrom([$this->pluginSettings->sender => $this->settings['fromName']]);
            $message->setTo($recievers);
            $message->setSubject($this->pluginSettings->emailPrefix .' - ' . $this->settings['fromName'] . ' - ' . $this->getExceptionName($exception));
            $message->setHtmlBody($body);

            Craft::$app->mailer->send($message);
        }
    }

    protected function getRecievers()
    {
        if($this->pluginSettings->recievers !== '') {
            return array_map('trim', explode(',', $this->pluginSettings->recievers));
        }

        return false;
    }

    protected function checkEnvironment()
    {
        if(in_array($this->environment, $this->pluginEnvironments, true)) {
            return true;
        }

        return false;
    }

    protected function checkNotFound($exception)
    {
        if($this->pluginSettings->notFound !== '1' && $this->getExceptionName($exception) === 'Not Found') {
            return false;
        }

        return true;
    }

    protected function getExceptionName($exception)
    {
        $error = new ErrorHandler();

        return $error->getExceptionName($exception);
    }

    protected function getServerVars()
    {
        $serverVars = $_SERVER;

        // clean some fields
        unset($serverVars['DB_PASSWORD'], $serverVars['HTTP_COOKIE']);

        return $serverVars;
    }

    protected function getUserVars()
    {
        return print_r(Craft::$app->getUser(), true);
    }

    protected function getSessionVars()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return print_r($_SESSION, true);
    }

    protected function getCookieVars()
    {
        return print_r($_COOKIE, true);
    }
}