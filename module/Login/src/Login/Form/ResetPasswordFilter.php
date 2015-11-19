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
class ResetPasswordFilter extends InputFilter {

    public function __construct() {
        $login = new Input('login');
        $login->setRequired(true)
                ->getFilterChain()
                ->attach(new StringTrim())
                ->attach(new StripTags());
        $login->getValidatorChain()->attach(new NotEmpty());
        $this->add($login);

        
    }

}
