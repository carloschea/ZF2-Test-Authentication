<?php

namespace Nivel\Controller;

use Base\Controller\AbstractController;

/**
 * Description of IndexController
 *
 * @author Rick
 */
class IndexController extends AbstractController {

    function __construct() {
        $this->form = 'Nivel\Form\NivelForm';
        $this->cotroller = 'nivel';
        $this->route = 'nivel/default';
        $this->service = 'Nivel\Service\NivelService';
        $this->entity = 'Nivel\Entity\Nivel';
        $this->itemCountPerPage = '10';
    }
/*
    public function inserirAction() {
        var_dump($this->getRequest()->getPost());
        die;
    }*/

}
