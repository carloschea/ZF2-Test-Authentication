<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Home\Controller;

use Base\Controller\AbstractController;
use Zend\View\Model\ViewModel;

/**
 * Description of IndexController
 *
 * @author Rick
 */
class IndexController extends AbstractController {

    function __construct() {
        
    }

    public function indexAction() {
        
       
        return new ViewModel();
    }

    public function debugAction() {
        //return new ViewModel();        
    }

}
