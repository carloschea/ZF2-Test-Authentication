<?php

namespace Usuario\Form;

use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;
use Zend\Validator\Identical;
use Zend\Validator\InArray;

/**
 * Description of UsuarioFilter
 *
 * @author Rick
 */
class UsuarioFilter extends InputFilter {

    protected $nivel;

    public function __construct(Array $nivel = array()) {
        $this->nivel = $nivel;
        //Nome
        $nome = new Input('nome');
        $nome->setRequired(true)
                ->getFilterChain()
                ->attach(new StringTrim())
                ->attach(new StripTags());
        $nome->getValidatorChain()->attach(new NotEmpty());
        $this->add($nome);


        //email
        $email = new Input('email');
        $email->setRequired(true)
                ->getFilterChain()
                ->attach(new StringTrim())
                ->attach(new StripTags());
        $email->getValidatorChain()->attach(new NotEmpty());
        $this->add($email);



        //nivel
        $inArray = new InArray();
        $inArray->setOptions(array('haystack' => $this->haystack($this->nivel)));

        $nivel1 = new Input('nivel');
        $nivel1->setRequired(true)
                ->getFilterChain()
                ->attach(new StringTrim())
                ->attach(new StripTags());
        $nivel1->getValidatorChain()->attach($inArray);
        $this->add($nivel1);




        //login
        $login = new Input('login');
        $login->setRequired(true)
                ->getFilterChain()
                ->attach(new StringTrim())
                ->attach(new StripTags());
        $login->getValidatorChain()->attach(new NotEmpty());
        $this->add($login);

        $senha = new Input('senha');
        $senha->setRequired(true)
                ->getFilterChain()
                ->attach(new StringTrim())
                ->attach(new StripTags());
        $senha->getValidatorChain()->attach(new NotEmpty());
        $this->add($senha);


        $confsenha = new Input('conf-senha');
        $confsenha->setRequired(true)
                ->getFilterChain()
                ->attach(new StringTrim())
                ->attach(new StripTags());
        $confsenha->getValidatorChain()->attach(new NotEmpty());

        $confsenha->getValidatorChain()->attach(new Identical(array(
            'token' => 'senha',
            'messages' => array(
                'notSame' => 'The two given passwords do not match',
                'missingToken' => 'No password was provided to match against'
            )
        )));
//var_dump('ssss22');die;

        $this->add($confsenha);
    }
    
    

    public function haystack(Array $haystack = array()) {
        $array = array();
        foreach ($haystack as $value) {
            if ($value) {
                $array[$value['value']] = $value['label'];
            }
        }

        return array_keys($array);
    }

}