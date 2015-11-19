<?php

namespace Login\Form;

use Zend\Form\Element\Text;
use Zend\Form\Element\Password;
use Zend\Form\Form;
use Zend\Form\Element\Button;
use Login\Form\ResetPasswordFilter;

/**
 * Description of LoginForm
 *
 * @author Rick
 */
class ResetPasswordForm extends Form {

    public function __construct() {
        parent::__construct(null);
        $this->setAttributes(array(
            'method' => 'POST',
            'accept-charset' => 'UTF-8',
            'class' => 'form-horizontal',
        ));

        $this->setInputFilter(new ResetPasswordFilter());

        //input nome

        $nome = new Text('login');
        $nome->setLabel('Login')
                ->setAttributes(array(
                    'id' => 'nome',
                    'maxlength' => 45,
                    'class' => 'form-control',
                ))
                ->setLabelAttributes(array(
        ));
        $this->add($nome);


        



        //botao submit
        $button = new Button('submit');
        $button->setLabel('Enviar-me instrucoes')
                ->setAttributes(array(
                    'type' => 'submit',
                    'class' => 'btn btn-default'
        ));

        $this->add($button);
    }

}
