<?php

namespace Categoria\Form;

use Zend\Form\Element\Text;
use Zend\Form\Form;
use Zend\Form\Element\Button;
use Categoria\Form\CategoryFilter;

/**
 * Description of CategoryForm
 *
 * @author Rick
 */
class CategoryForm extends Form {

    public function __construct() {
        parent::__construct(null);
        $this->setAttributes(array(
            'method' => 'POST',
            'accept-charset' => 'UTF-8',
            'class' => 'form-horizontal',
        ));

        $this->setInputFilter(new CategoryFilter());

        //input nome

        $nome = new Text('nome');
        $nome->setLabel('Nome')
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
        $button->setLabel('Salvar')
                ->setAttributes(array(
                    'type' => 'submit',
                    'class' => 'btn btn-default'
        ));

        $this->add($button);
    }

}
