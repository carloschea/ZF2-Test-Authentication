<?php

namespace Usuario\Entity;

use Auth\Entity\Session;

/**
 * UsuarioRepository
 */
class UsuarioRepository extends \Doctrine\ORM\EntityRepository {

    public function findByLoginAndPassword($login, $password) {
        /*
          $userLogin = $this->createQueryBuilder('u')
          ->where('u.login = :a1')
          ->setParameter('a1', $login)->getQuery()->getOneOrNullResult();
         * 
         */

        $userLogin = $this->createQueryBuilder('u')
                        ->join('u.login', 'l')
                        ->where('l.login = :a1')
                        ->setParameter('a1', $login)->getQuery()->getOneOrNullResult();


        if (!is_null($userLogin)) {
            if ($userLogin->getLogin()->encryptPassword($password) == $userLogin->getLogin()->getSenha()) {
                //var_dump($userLogin) ;die;
                $session = new Session;
                $session->setNome($userLogin->getNome());
                $session->setLogin($userLogin->getLogin()->getLogin());
                $session->setNivel($userLogin->getNivel()->getId());
                return $session;
            }
        }
        return false;
    }

    public function findByEmail($email) {
        $user = $this->createQueryBuilder('u')
                        ->where('u.email = :a1')
                        ->setParameter('a1', $email)->getQuery()->getOneOrNullResult();
        
        if (!is_null($user)) {
            return $user;
        }
        return false;
    }

}
