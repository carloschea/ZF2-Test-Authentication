<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Usuario\Controller;

use Base\Controller\AbstractController;
use Login\Entity\Login;
use Usuario\Entity\Usuario;
use Zend\View\Model\ViewModel;

/**
 * Description of IndexController
 *
 * @author Rick
 */
class IndexController extends AbstractController {

    protected $champralliesTable;
    protected $formEdit;

    function __construct() {
        $this->form = 'Usuario\Form\UsuarioForm';
        $this->formEdit = 'Usuario\Form\UsuarioEditForm';
        $this->formLogin = 'Usuario\Form\UsuarioLoginForm';
        $this->cotroller = 'usuario';
        $this->route = 'usuario/default';
        $this->service = 'Usuario\Service\UsuarioService';
        $this->entity = 'Usuario\Entity\Usuario';
        $this->itemCountPerPage = '4';
    }

    public function inserirAction() {
        $this->form = $this->getServiceLocator()->get($this->form);



        if (is_string($this->form)) {
            $form = new $this->form;
        } else {
            $form = $this->form;
        }


        $request = $this->getRequest();

        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $arrayRequest = $request->getPost()->toArray();

                $login = new Login();
                $login->setLogin($form->get('login')->getValue());
                $login->setSenha($login->encryptPassword($form->get('senha')->getValue()));

                $usuario = new Usuario();
                $usuario->setNome($arrayRequest['nome']);
                $usuario->setEmail($arrayRequest['email']);

                //$em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
                $em = $this->getEm();


                $em->getConnection()->beginTransaction(); // suspend auto-commit
                try {
                    $em->persist($login);
                    $em->flush();
                    $usuario->setLogin($em->getRepository('Login\Entity\Login')->find($login->getId()));
                    $usuario->setNivel($em->getRepository('Nivel\Entity\Nivel')->find($arrayRequest['nivel']));
                    $em->persist($usuario);
                    $em->flush();

                    $em->getConnection()->commit();
                    $this->flashMessenger()->addSuccessMessage('Cadastrado com Sucesso');
                } catch (Exception $e) {
                    $em->getConnection()->rollback();
                    var_dump('eeeee');
                    die;
                    $this->flashMessenger()->addErrorMessage('Nao foi possivel cadastrar!');
                    //throw $e;
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

    public function editarAction() {
        $this->formEdit = $this->getServiceLocator()->get($this->formEdit);

        if (is_string($this->formEdit)) {
            $form = new $this->formEdit;
        } else {
            $form = $this->formEdit;
        }

        $request = $this->getRequest();
        $param = $this->params()->fromRoute('id', 0);
        $repository = $this->getEm()->getRepository($this->entity)->find($param);
        if ($repository) {

            $array = array();
            foreach ($repository->toArray() as $key => $value) {
                if ($key == 'login') {
                    $array[$key] = $value->getLogin();
                } else if ($value instanceof \DateTime) {
                    $array[$key] = $value->format('d/m/Y');
                } else {
                    $array[$key] = $value;
                }
            }

            $form->setData($array);

            if ($request->isPost()) {
                $form->setData($request->getPost());
                if ($form->isValid()) {

                    $data = $request->getPost()->toArray();
                    $data['id'] = (int) $param;


                    try {
                        $em = $this->getEm();
                        $usuario = $em->getRepository('Usuario\Entity\Usuario')->find($data['id']);
                        $usuario->setNome($data['nome']);
                        $usuario->setEmail($data['email']);
                        $usuario->setNivel($em->getRepository('Nivel\Entity\Nivel')->find($data['nivel']));
                        $usuario->getLogin()->setLogin($data['login']);
                        $em->flush();
                        $this->flashMessenger()->addSuccessMessage('Atualizado com Sucesso!');
                    } catch (Exception $e) {
                        $this->flashMessenger()->addErrorMessage('Nao foi possivel atualizar!');
                        //throw $e;
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

    public function excluirAction() {
        try {
            $id = $this->params()->fromRoute('id', 0);
            $em = $this->getEm();
            $usuario = $em->getRepository('Usuario\Entity\Usuario')->find($id);
            $em->remove($usuario);
            $em->remove($usuario->getLogin());
            $em->flush();

            $this->flashMessenger()->addSuccessMessage('Registro deletado com Sucesso!');
        } catch (Exception $e) {

            $this->flashMessenger()->addErrorMessage('Nao foi possivel deletar o registro!');
            //throw $this->createNotFoundException('No guest found for id '.$id);
            //throw $e;
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
