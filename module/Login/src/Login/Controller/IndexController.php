<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Login\Controller;

use Base\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;

//require_once '../../../../../vendor/PHPMailer/class.phpmailer.php';
/**
 * Description of IndexController
 *
 * @author Rick
 */
class IndexController extends AbstractController {

    private $form1;
    private $form2;
    private $form3;

    function __construct() {
        $this->form1 = 'Login\Form\ResetPasswordForm';
        $this->form2 = 'Login\Form\ForgotUsernameForm';
        $this->form3 = 'Login\Form\NewPasswordForm';
        $this->cotroller = 'loginfff';
        $this->route = 'loginfff/default';
        $this->service = 'Login\Service\LoginService';
        $this->entity = 'Login\Entity\Login';
        $this->itemCountPerPage = '10';
    }

    public function resetPasswordAction() {
        $this->form1 = $this->getServiceLocator()->get($this->form1);
        if (is_string($this->form1)) {
            $form = new $this->form1;
        } else {
            $form = $this->form1;
        }


        $request = $this->getRequest();

        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $arrayRequest = $request->getPost()->toArray();

                $login = new Login();
                $login->setLogin($form->get('login')->getValue());
                $login->setSenha($form->get('senha')->getValue());

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

    public function forgotUsernameAction() {
        $this->form2 = $this->getServiceLocator()->get($this->form2);
        if (is_string($this->form2)) {
            $form = new $this->form2;
        } else {
            $form = $this->form2;
        }


        $request = $this->getRequest();

        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                //$arrayRequest = $request->getPost()->toArray();
                //$em = $this->getEm();
                
                //$user = $em->getRepository('Usuario\Entity\Usuario')->findByEmail($arrayRequest['email']);

                //if ($user) {
                if (true) {
                    

                    //

                    $nomeRemetente = 'Site';

                    $emailRemetenteSMTP = '';
                    $senhaEmailRemetente = '';



                    //$nomeDestinatario = $user->getNome();
                    $nomeDestinatario = 'nome do destinatario';
                    //$emailDestinatario = $user->getEmail();
                    $emailDestinatario = '';

                    
                    // Setup SMTP transport using LOGIN authentication plain ou login

                    $message = new Message();
                    $message->addTo($emailDestinatario)
                            ->addFrom($emailRemetenteSMTP)
                            ->setSubject('Assunto Teste')
                            ->setBody('texto de exemplo.');


                    $transport = new SmtpTransport();


                    $options = new SmtpOptions(array(
                        'name' => 'smtp.gmail.com',
                        'host' => 'smtp.gmail.com',
                        //'host' => '64.233.186.108',
                        //'host' => '10.0.0.37',
                        'connection_class' => 'plain',
                        // 587 for TLS and 465 for SSL
                        'port' => '587',
                        //'port' => '25',
                        'connection_config' => array(
                            'ssl' => 'tls', // Page would hang without this line being added tls or ssl
                            'username' => $emailRemetenteSMTP,
                            'password' => $senhaEmailRemetente,
                        ),
                    ));
                    $transport->setOptions($options);
                    $transport->send($message);
                    
                    $this->flashMessenger()->addSuccessMessage('E-mail enviado com Sucesso');
                    /*
                      if ($transport->) {

                      $this->flashMessenger()->addSuccessMessage('E-mail enviado com Sucesso');
                      } else {

                      $this->flashMessenger()->addErrorMessage('Não foi possivel enviar o e-mail...');
                      }
                     * 
                     */

                    
                } else {
                    $this->flashMessenger()->addErrorMessage('Não foi encontrado nenhum e-mail!');
                }



                return $this->redirect()
                                ->toRoute($this->route, array('controller' => $this->controller, 'action' => 'forgot_username'));
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

    public function setNewPasswordAction() {
        $this->form3 = $this->getServiceLocator()->get($this->form3);
        if (is_string($this->form3)) {
            $form = new $this->form3;
        } else {
            $form = $this->form3;
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

    public function getEm() {
        if ($this->em == null) {
            $this->em = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
        }
        return $this->em;
    }

    /*
      public function indexAction() {

      }
     */

    /*
      public function inserirAction() {
      var_dump($this->getRequest()->getPost());
      die;
      } */
}
