<?php

namespace Post\Form;

use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;
use Zend\Validator\InArray;

/**
 * Description of PostFilter
 *
 * @author Rick
 */
class PostFilter extends InputFilter {

    protected $categoria;

    public function __construct(Array $categoria = array()) {
        $this->categoria = $categoria;
        //Titulo
        $titulo = new Input('titulo');
        $titulo->setRequired(true)
                ->getFilterChain()
                ->attach(new StringTrim())
                ->attach(new StripTags());
        $titulo->getValidatorChain()->attach(new NotEmpty());
        $this->add($titulo);


        //Descricao
        $descricao = new Input('descricao');
        $descricao->setRequired(false)
                ->getFilterChain()
                ->attach(new StringTrim())
                ->attach(new StripTags());
        $this->add($descricao);


        //Texto
        $texto = new Input('texto');
        $texto->setRequired(true)
                ->getFilterChain()
                ->attach(new StringTrim())
                ->attach(new StripTags());
        $texto->getValidatorChain()->attach(new NotEmpty());
        $this->add($texto);


        //ativo
        $ativo = new Input('ativo');
        $ativo->setRequired(true)
                ->getFilterChain()
                ->attach(new StringTrim())
                ->attach(new StripTags());
        $this->add($ativo);



        $inArray = new InArray();
        $inArray->setOptions(array('haystack' => $this->haystack($this->categoria)));

        $categoria = new Input('category');
        $categoria->setRequired(true)
                ->getFilterChain()
                ->attach(new StringTrim())
                ->attach(new StripTags());
        $categoria->getValidatorChain()->attach($inArray);
        $this->add($categoria);
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
