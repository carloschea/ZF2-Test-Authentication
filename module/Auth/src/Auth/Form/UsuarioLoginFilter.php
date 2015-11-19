<?php

namespace Auth\Form;

use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;

/**
 * Description of UsuarioFilter
 *
 * @author Rick
 */

class UsuarioLoginFilter extends InputFilter {

    protected $nivel;

    public function __construct() {
        //email
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
    }

}
