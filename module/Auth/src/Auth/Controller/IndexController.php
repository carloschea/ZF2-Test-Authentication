<?php

namespace Auth\Controller;

use Base\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use Zend\Log\Logger;
use Zend\Log\Writer\Stream;

/**
 * Description of IndexController
 *
 * @author Rick
 */
class IndexController extends AbstractController {

    //protected $champralliesTable;
    //protected $formEdit;
    //protected $viewModel;

    function __construct() {
        $this->form = 'Auth\Form\UsuarioLoginForm';
        $this->cotroller = 'auth';
        $this->route = 'auth/default';
    }

    public function loginAction() {
        $viewModel = new ViewModel();

        //$logger = new Logger;
        ///$writer = new Stream('./data/log/Logger.log');
        //$logger->addWriter($writer);
        //$logger->log(Logger::DEBUG, 'Informational message LOG');
        //$logger->info('Informational message INFO');
        $this->form = $this->getServiceLocator()->get($this->form);
        if (is_string($this->form)) {
            $form = new $this->form;
        } else {
            $form = $this->form;
        }

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost()->toArray());
            if ($form->isValid()) {
                $data = $form->getData();
                $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
                $adapter = $auth->getAdapter();
                $adapter->setLogin($data['login'])->setSenha($data['senha']);
                if ($auth->authenticate()->isValid()) {
                    $this->flashMessenger()->addSuccessMessage('Login realizado com sucesso!');
                    return $this->redirect()->toRoute('home', array('controller' => 'home', 'action' => 'index'));
                }
                $mensagem = $auth->authenticate()->getMessages();
                $this->flashMessenger()->addErrorMessage($mensagem[0]);
                //return $this->redirect()
                //              ->toRoute($this->route, array('controller' => $this->controller,'form' => $data));
                $viewModel = new ViewModel(array('form' => $form));

                return $viewModel;
            }
        }

        $this->flashMessenger()->clearMessages();
        $viewModel = new ViewModel(array('form' => $form));
        return $viewModel;
    }

    public function logoutAction() {
        $auth = new AuthenticationService();
        if ($auth->hasIdentity()) {
            //$identity = $auth->getIdentity();
            $auth->clearIdentity();
            $this->flashMessenger()->addSuccessMessage('Voce acabou de ser desconectado!');
        }
        //$this->_redirect('/user');
        return $this->redirect()->toRoute('home', array('controller' => 'home', 'action' => 'index'));
    }

    public function getEm() {
        if ($this->em == null) {
            $this->em = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
        }
        return $this->em;
    }

}
