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
class UsuarioEditFilter extends InputFilter {

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
