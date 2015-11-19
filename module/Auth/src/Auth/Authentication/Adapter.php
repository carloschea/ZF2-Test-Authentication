<?php

namespace Auth\Authentication;

use Doctrine\ORM\EntityManager;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;

/**
 * Description of Adapter
 *
 * @author Rick
 */
class Adapter implements AdapterInterface {

    protected $em;
    protected $login;
    protected $senha;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    function getLogin() {
        return $this->login;
    }

    function getSenha() {
        return $this->senha;
    }

    function setLogin($login) {
        $this->login = $login;
        return $this;
    }

    function setSenha($senha) {
        $this->senha = $senha;
        return $this;
    }

    public function authenticate() {
        $user = $this->em->getRepository('Usuario\Entity\Usuario')->findByLoginAndPassword($this->getLogin(), $this->getSenha());
        if ($user) {
            return new Result(Result::SUCCESS, $user, array());
        } else {
           //$this->translate("Login e/ou senha nao encontrados");
            return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, array('Login e/ou senha nao encontrados'));

        }
    }
}
