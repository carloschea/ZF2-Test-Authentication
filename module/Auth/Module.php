<?php

namespace Auth;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Auth\Form\UsuarioLoginForm;



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
                'Usuario\Service\UsuarioService' => function($em) {
                    return new UsuarioService($em->get('Doctrine\ORM\EntityManager'));
                },
                'Auth\Form\UsuarioLoginForm' => function($em) {
                    return new UsuarioLoginForm($em->get('Doctrine\ORM\EntityManager'));
                }
                
                
                
            )
        );
    }



}
