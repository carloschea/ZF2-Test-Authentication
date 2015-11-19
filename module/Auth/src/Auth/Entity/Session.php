<?php

namespace Auth\Entity;

class Session {

    private $nome;
    private $login;
    private $nivel;

    function getNome() {
        return $this->nome;
    }

    function getLogin() {
        return $this->login;
    }

    function getNivel() {
        return $this->nivel;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setLogin($login) {
        $this->login = $login;
    }

    function setNivel($nivel) {
        $this->nivel = $nivel;
    }

}
