<?php

namespace Login;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Login\Service\LoginService;
use Login\Form\ResetPasswordForm;
use Login\Form\ForgotUsernameForm;
use Login\Form\NewPasswordForm;

class Module {

    public function onBootstrap(MvcEvent $e) {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
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

    public function getServiceConfig() {
        return array(
            'factories' => array(
                'Login\Service\LoginService' => function($em) {
                    return new LoginService($em->get('Doctrine\ORM\EntityManager'));
                },
                'Login\Form\ResetPasswordForm' => function($em) {
                    return new ResetPasswordForm($em->get('Doctrine\ORM\EntityManager'));
                },
                'Login\Form\ForgotUsernameForm' => function($em) {
                    return new ForgotUsernameForm($em->get('Doctrine\ORM\EntityManager'));
                },
                'Login\Form\NewPasswordForm' => function($em) {
                    return new NewPasswordForm($em->get('Doctrine\ORM\EntityManager'));
                },
            )
        );
    }

}
