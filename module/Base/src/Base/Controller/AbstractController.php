<?php

namespace Base\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter;




/**
 * Description of AbstractController
 *
 * @author Rick
 */
abstract class AbstractController extends AbstractActionController {

    protected $em;
    protected $entity;
    protected $controller;
    protected $route;
    protected $service;
    protected $form;
    protected $itemCountPerPage = 2;

    abstract function __construct();

    /**
     * listar Registro
     */
    public function indexAction() {
        $list = $this->getEm()->getRepository($this->entity)->findAll();

        $page = $this->params()->fromRoute('page');
        $paginator = new Paginator(new ArrayAdapter($list));
        $paginator->setCurrentPageNumber($page)->setDefaultItemCountPerPage($this->itemCountPerPage);


        if ($this->flashMessenger()->hasSuccessMessages()) {
            return new ViewModel(array(
                'data' => $paginator,
                'page' => $page,
                'success' => $this->flashMessenger()->getSuccessMessages()
            ));
        }

        if ($this->flashMessenger()->hasErrorMessages()) {
            return new ViewModel(array(
                'data' => $paginator,
                'page' => $page,
                'error' => $this->flashMessenger()->getErrorMessages()
            ));
        }
        if ($this->flashMessenger()->hasInfoMessages()) {
            return new ViewModel(array(
                'data' => $paginator,
                'page' => $page,
                'warning' => $this->flashMessenger()->getInfoMessages()
            ));
        }

        $this->flashMessenger()->clearMessages();


        return new ViewModel(array('data' => $paginator, 'page' => $page));
    }

    /**
     * Inserir Registro
     */
    public function inserirAction() {
        if (is_string($this->form)) {
            $form = new $this->form;
        } else {
            $form = $this->form;
        }

        $request = $this->getRequest();

        //var_dump($form);die;
        if ($request->isPost()) {
            //var_dump($form);die;
            //var_dump('teste1');

            $form->setData($request->getPost());
            if ($form->isValid()) {
                //var_dump('teste2');die;

                $servive = $this->getServiceLocator()->get($this->service);
                if ($servive->save($request->getPost()->toArray())) {
                    $this->flashMessenger()->addSuccessMessage('Cadastrado com Sucesso');
                } else {
                    $this->flashMessenger()->addErrorMessage('Nao foi possivel cadastrar!');
                }
                return $this->redirect()
                                ->toRoute($this->route, array('controller' => $this->controller, 'action' => 'inserir'));
            }
        }


        if ($this->flashMessenger()->hasSuccessMessages()) {
            return new ViewModel(array(
                'form' => $form,
                'success' => $this->flashMessenger()->getSuccessMessages()
            ));
        }

        if ($this->flashMessenger()->hasErrorMessages()) {
            return new ViewModel(array(
                'form' => $form,
                'error' => $this->flashMessenger()->getErrorMessages()
            ));
        }
        $this->flashMessenger()->clearMessages();





        return new ViewModel(array('form' => $form));
    }

    /**
     * Editar Registro
     */
    public function editarAction() {
        if (is_string($this->form)) {
            $form = new $this->form;
        } else {
            $form = $this->form;
        }

        $request = $this->getRequest();
        $param = $this->params()->fromRoute('id', 0);
        $repository = $this->getEm()->getRepository($this->entity)->find($param);
        if ($repository) {

            $array = array();
            foreach ($repository->toArray() as $key => $value) {
                if ($value instanceof \DateTime) {
                    $array[$key] = $value->format('d/m/Y');
                } else {
                    $array[$key] = $value;
                }
            }

            $form->setData($array);

            if ($request->isPost()) {
                $form->setData($request->getPost());
                if ($form->isValid()) {
                    $servive = $this->getServiceLocator()->get($this->service);
                    $data = $request->getPost()->toArray();
                    $data['id'] = (int) $param;

                    if ($servive->save($data)) {
                        $this->flashMessenger()->addSuccessMessage('Atualizado com Sucesso!');
                    } else {
                        $this->flashMessenger()->addErrorMessage('Nao foi possivel atualizar!');
                    }
                    return $this->redirect()
                                    ->toRoute($this->route, array('controller' => $this->controller, 'action' => 'editar', 'id' => $param));
                }
            }
        } else {
            $this->flashMessenger()->addInfoMessage('Registro nao encontrado');
            return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
        }

        if ($this->flashMessenger()->hasSuccessMessages()) {
            return new ViewModel(array(
                'form' => $form,
                'success' => $this->flashMessenger()->getSuccessMessages(),
                'id' => $param
            ));
        }

        if ($this->flashMessenger()->hasErrorMessages()) {
            return new ViewModel(array(
                'form' => $form,
                'error' => $this->flashMessenger()->getErrorMessages(),
                'id' => $param
            ));
        }
        if ($this->flashMessenger()->hasInfoMessages()) {
            return new ViewModel(array(
                'form' => $form,
                'warning' => $this->flashMessenger()->getInfoMessages(),
                'id' => $param
            ));
        }

        $this->flashMessenger()->clearMessages();


        return new ViewModel(array('form' => $form, 'id' => $param));
    }

    /**
     * Excluir Registro
     */
    public function excluirAction() {
        $servive = $this->getServiceLocator()->get($this->service);
        $id = $this->params()->fromRoute('id', 0);
        if ($servive->remove(array('id' => $id))) {
            $this->flashMessenger()->addSuccessMessage('Registro deletado com Sucesso!');
        } else {
            $this->flashMessenger()->addErrorMessage('Nao foi possivel deletar o registro!');
        }

        return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
    }

    public function getEm() {
        if ($this->em == null) {
            $this->em = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
        }
        return $this->em;
    }

    

}
