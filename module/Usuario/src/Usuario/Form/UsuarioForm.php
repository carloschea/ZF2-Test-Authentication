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

        $nome = new Text('nome');
        $nome->setLabel('Nome')
                ->setAttributes(array(
                    'id' => 'nome',
                    'maxlength' => 80,
                    'class' => 'form-control',
        ));
        $this->add($nome);



        //input email

        $email = new Text('email');
        $email->setLabel("email")
                ->setAttributes(array(
                    'id' => 'email',
                    'maxlength' => 150,
                    'class' => 'form-control',
        ));
        $this->add($email);

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

        //nivel_id
        $nivel = new ObjectSelect('nivel');
        $nivel->setLabel('Nivel')->setOptions(array(
            'object_manager' => $this->getObjectManager(),
            'target_class' => 'Nivel\Entity\Nivel',
            'property' => 'nome',
            'empty_option' => '--Selecione--',
            'is_method' => true,
            'find_method' => array(
                'name' => 'findBy',
                'params' => array(
                    'criteria' => array(),
                    'orderBy' => array('nome' => 'ASC'),
                ),
            ),
        ))->setAttributes(array(
            'id' => 'nivel',
            'class' => 'form-control',
        ));

        $this->add($nivel);
        
        /*
        $nivel = new ObjectSelect('nivel');
        $nivel->setLabel('Nivel')->setOptions(array(
            'object_manager' => $this->getObjectManager(),
            'target_class' => 'Nivel\Entity\Nivel',
            'property' => 'nome',
            'empty_option' => '--Selecione--',
            'is_method' => true,
            'find_method' => array(
                'name' => 'findBy',
                'params' => array(
                    'criteria' => array(),
                    'orderBy' => array('nome' => 'ASC'),
                ),
            ),
        ))->setAttributes(array(
            'id' => 'nivel',
            'class' => 'form-control',
        ));

        $this->add($nivel);
         */







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
        $button->setLabel('Salvar')
                ->setAttributes(array(
                    'type' => 'submit',
                    'class' => 'btn btn-default'
        ));

        $this->add($button);




        $this->setInputFilter(new UsuarioFilter($nivel->getValueOptions()));
    }

    public function getObjectManager() {
        return $this->objectManager;
    }

    public function setObjectManager(ObjectManager $objectManager) {
        $this->objectManager = $objectManager;
    }

}
