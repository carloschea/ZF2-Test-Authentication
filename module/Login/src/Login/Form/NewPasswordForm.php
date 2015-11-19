<?php

namespace Login\Form;

use Zend\Form\Element\Text;
use Zend\Form\Element\Password;
use Zend\Form\Form;
use Zend\Form\Element\Button;
use Login\Form\NewPasswordFilter;

/**
 * Description of LoginForm
 *
 * @author Rick
 */
class NewPasswordForm extends Form {

    public function __construct() {
        parent::__construct(null);
        $this->setAttributes(array(
            'method' => 'POST',
            'accept-charset' => 'UTF-8',
            'class' => 'form-horizontal',
        ));

        $this->setInputFilter(new NewPasswordFilter());

      

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



        $confsenha = new Password('conf-senha');
        $confsenha->setLabel('Confirmar senha')
                ->setAttributes(array(
                    'id' => 'conf-senha',
                    'maxlength' => 45,
                    'class' => 'form-control',
                ))
                ->setLabelAttributes(array(
        ));
        
        $this->add($confsenha);


        //botao submit
        $button = new Button('submit');
        $button->setLabel('Enviar instrucoes')
                ->setAttributes(array(
                    'type' => 'submit',
                    'class' => 'btn btn-default'
        ));

        $this->add($button);
    }

}
