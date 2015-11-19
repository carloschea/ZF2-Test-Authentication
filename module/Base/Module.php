<?php

namespace Base;

//use Zend\I18n\Translator\Translator;
//use Zend\Validator\AbstractValidator;
//use Zend\Mvc\I18n\Translator;
//use Zend\Mvc\ModuleRouteListener;
//use Zend\Mvc\MvcEvent;
//use Zend\I18n\Translator\Translator;


use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module {

    public function onBootstrap(MvcEvent $e) {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $locale = \Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']);
        $fallbackLocale = 'en_US';

        $sm = $e->getApplication()->getServiceManager();
        $sm->get('translator')
                ->setLocale($locale)
                ->setFallbackLocale($fallbackLocale);

        $type = 'phpArray';
        $pattern = './vendor/zendframework/zendframework/resources/languages/%s/Zend_Validate.php';
        $textDomain = 'default';

        $translator = $e->getApplication()->getServiceManager()->get('translator');

        if (file_exists(sprintf($pattern, $locale))) {
            $translator->addTranslationFile($type, sprintf($pattern, $locale), $textDomain);
        } else if (file_exists(sprintf($pattern, preg_replace('/_(.*)/', '', $locale)))) {
            $translator->addTranslationFile($type, sprintf($pattern, preg_replace('/_(.*)/', '', $locale)), $textDomain);
        } else {
            $pattern = sprintf($pattern, preg_replace('/_(.*)/', '', $fallbackLocale));
            $translator->addTranslationFile($type, $pattern, $textDomain);
        }
        \Zend\Validator\AbstractValidator::setDefaultTranslator($translator);
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

}
