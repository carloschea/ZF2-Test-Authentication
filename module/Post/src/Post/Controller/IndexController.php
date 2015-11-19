<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Post\Controller;

use Base\Controller\AbstractController;

/**
 * Description of IndexController
 *
 * @author Rick
 */
class IndexController extends AbstractController {

    function __construct() {
        $this->form = 'Post\Form\PostForm';
        $this->cotroller = 'post';
        $this->route = 'post/default';
        $this->service = 'Post\Service\PostService';
        $this->entity = 'Post\Entity\Post';
        $this->itemCountPerPage = '2';
    }

    public function inserirAction() {
        $this->form = $this->getServiceLocator()->get($this->form);
        return parent::inserirAction();
    }

    public function editarAction() {
        $this->form = $this->getServiceLocator()->get($this->form);
        return parent::editarAction();
    }

}
