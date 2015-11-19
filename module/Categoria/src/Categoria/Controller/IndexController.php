<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Categoria\Controller;

use Base\Controller\AbstractController;

/**
 * Description of IndexController
 *
 * @author Rick
 */
class IndexController extends AbstractController {

    function __construct() {
        $this->form = 'Categoria\Form\CategoryForm';
        $this->cotroller = 'categoria';
        $this->route = 'categoria/default';
        $this->service = 'Categoria\Service\CategoriaService';
        $this->entity = 'Categoria\Entity\Category';
        $this->itemCountPerPage = '10';
        
        
    }

    /*
      public function inserirAction() {
      var_dump($this->getRequest()->getPost());
      die;
      } */
}
