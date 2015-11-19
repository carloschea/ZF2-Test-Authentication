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
class ForgotUsernameFilter extends InputFilter {

    public function __construct() {
        $email= new Input('email');
        $email->setRequired(true)
                ->getFilterChain()
                ->attach(new StringTrim())
                ->attach(new StripTags());
        $email->getValidatorChain()->attach(new NotEmpty());
        $this->add($email);

        
    }

}
