<?php

namespace Login\Form;

use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;
use Zend\Validator\Identical;

/**
 * Description of LoginFilter
 *
 * @author Rick
 */
class NewPasswordFilter extends InputFilter {

    public function __construct() {
        
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
        $this->add($confsenha);

        
    }

}
