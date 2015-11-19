<?php

namespace Usuario\Form;

use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\Form\Element\Text;
use Zend\Form\Element\Password;
use Zend\Form\Element\Textarea;
use Zend\Form\Element\Checkbox;
use DoctrineModule\Form\Element\ObjectSelect;
use Zend\Form\Form;
use Zend\Form\Element\Button;
use Usuario\Form\UsuarioEditFilter;
use Zend\Form\Element\Captcha;
use Zend\Form\Element\Csrf;
use Zend\Captcha\Dumb;

/**
 * Description of UsuarioForm
 *
 * @author Rick
 */
class UsuarioLoginForm extends Form implements ObjectManagerAwareInterface {

    protected $objectManager;

    public function __construct(ObjectManager $objectManager) {

        $this->setObjectManager($objectManager);


        parent::__construct(null);
        $this->setAttributes(array(
            'method' => 'POST',
            'accept-charset' => 'UTF-8',
            'class' => 'form-horizontal',
        ));

        



       



        //login_id
        $login = new Text('login');
        $login->setLabel('Login')
                ->setAttributes(array(
                    'id' => 'login',
                    'maxlength' => 45,
                    'class' => 'form-control',
                ))
                ->setLabelAttributes(array(
        ));
        $this->add($login);


        $senha = new Password('senha');
        $senha->setLabel('Senha')
                ->setAttributes(array(
                    'id' => 'senha',
                    'maxlength' => 45,
                    'class' => 'form-control',
                ))
                ->setLabelAttributes(array(
        ));
        $this->add($senha);










        //botao submit
        $button = new Button('submit');
        $button->setLabel('Entrar')
                ->setAttributes(array(
                    'type' => 'submit',
                    'class' => 'btn btn-default'
        ));

        $this->add($button);




        $this->setInputFilter(new UsuarioLoginFilter());
    }

    public function getObjectManager() {
        return $this->objectManager;
    }

    public function setObjectManager(ObjectManager $objectManager) {
        $this->objectManager = $objectManager;
    }

}
