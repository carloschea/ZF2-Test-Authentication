<?php

namespace Nivel\Form;

use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;

/**
 * Description of NivelFilter
 *
 * @author Rick
 */
class NivelFilter extends InputFilter {

    public function __construct() {
        $nome = new Input('nome');




        $nome->setRequired(true)
                ->getFilterChain()
                ->attach(new StringTrim())
                ->attach(new StripTags());
        $nome->getValidatorChain()->attach(new NotEmpty());


        $this->add($nome);
    }

}
