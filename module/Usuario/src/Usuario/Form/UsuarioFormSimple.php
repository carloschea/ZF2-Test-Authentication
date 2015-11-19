<?php

namespace Usuario\Form;

use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Element\Checkbox;
use DoctrineModule\Form\Element\ObjectSelect;
use Zend\Form\Form;
use Zend\Form\Element\Button;
use Usuario\Form\UsuarioFilter;

use Zend\Form\Element\Captcha;
use Zend\Form\Element\Csrf;
use Zend\Captcha\Dumb;

/**
 * Description of UsuarioForm
 *
 * @author Rick
 */
class UsuarioForm extends Form implements ObjectManagerAwareInterface {

    protected $objectManager;

    public function __construct(ObjectManager $objectManager) {
        
        $this->setObjectManager($objectManager);


        parent::__construct(null);
        $this->setAttributes(array(
            'method' => 'POST',
            'accept-charset' => 'UTF-8',
            'class' => 'form-horizontal',
        ));

        //input Titulo

        $titulo = new Text('titulo');
        $titulo->setLabel('Titulo')
                ->setAttributes(array(
                    'id' => 'nome',
                    'maxlength' => 80,
                    'class' => 'form-control',
        ));
        $this->add($titulo);



        //input descri��o

        $descricao = new Textarea('descricao');
        $descricao->setLabel("Descricao")
                ->setAttributes(array(
                    'id' => 'descricao',
                    'maxlength' => 150,
                    'class' => 'form-control',
        ));
        $this->add($descricao);


        //input texto

        $texto = new Textarea('texto');
        $texto->setLabel('Texto')
                ->setAttributes(array(
                    'id' => 'texto',
                    'class' => 'form-control',
        ));
        $this->add($texto);


        //input Ativo

        $ativo = new Checkbox('ativo');
        $ativo->setLabel('Ativo')
                ->setLabelAttributes(array(
                    'class' => 'checkbox-inline',
                ))->setOptions(array(
            'use_hidden_element' => true
        ));
        $this->add($ativo);


        //Categoria
        $categoria = new ObjectSelect('category');
        $categoria->setLabel('Categoria')->setOptions(array(
            'object_manager' => $this->getObjectManager(),
            'target_class' => 'Categoria\Entity\Category',
            'property' => 'nome',
            'empty_option' => '--Selecione--',
            'is_method' => true,
            'find_method' => array(
                'name' => 'findBy',
                'params' => array(
                    'criteria' => array(),
                    // Use key 'orderBy' if using ORM
                    'orderBy' => array('nome' => 'ASC'),
                ),
            ),
        ))->setAttributes(array(
            'id' => 'category',
            'class' => 'form-control',
        ));

        $this->add($categoria);


        //botao submit
        $button = new Button('submit');
        $button->setLabel('Salvar')
                ->setAttributes(array(
                    'type' => 'submit',
                    'class' => 'btn btn-default'
        ));

        $this->add($button);




        $this->setInputFilter(new PostFilter($categoria->getValueOptions()));
    }

    public function getObjectManager() {
        return $this->objectManager;
    }

    public function setObjectManager(ObjectManager $objectManager) {
        $this->objectManager = $objectManager;
    }

}
