<?php

namespace Auth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;

/**
 * Description of IndexController
 *
 * @author Rick
 */
class IndexController extends AbstractActionController
{
    public function loginAction()
    {
        $form = $this->getServiceLocator()->get('Auth\Form\UsuarioLoginForm');

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

                return $this->redirect()->toRoute('auth/default', array('controller' => 'index', 'action' => 'login'));
            }
        }

        return new ViewModel(array('form' => $form));
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
}
