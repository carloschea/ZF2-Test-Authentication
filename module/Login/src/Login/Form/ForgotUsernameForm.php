<?php

namespace Login\Form;

use Zend\Form\Element\Text;
use Zend\Form\Element\Password;
use Zend\Form\Form;
use Zend\Form\Element\Button;
use Login\Form\ForgotUsernameFilter;

/**
 * Description of LoginForm
 *
 * @author Rick
 */
class ForgotUsernameForm extends Form {

    public function __construct() {
        parent::__construct(null);
        $this->setAttributes(array(
            'method' => 'POST',
            'accept-charset' => 'UTF-8',
            'class' => 'form-horizontal',
        ));

        $this->setInputFilter(new ForgotUsernameFilter());

        //input nome

        $email = new Text('email');
        $email->setLabel('Email')
                ->setAttributes(array(
                    'id' => 'nome',
                    'maxlength' => 45,
                    'class' => 'form-control',
                ))
                ->setLabelAttributes(array(
        ));
        $this->add($email);



        




        



        //botao submit
        $button = new Button('submit');
        $button->setLabel('Enviar-me o meu nome de usuário')
                ->setAttributes(array(
                    'type' => 'submit',
                    'class' => 'btn btn-default'
        ));

        $this->add($button);
    }

}
