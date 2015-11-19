<?php

namespace Usuario\Entity;

use Base\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Usuario
 *
 * @ORM\Table(name="usuario", indexes={@ORM\Index(name="FK_USUARIO_LOGIN", columns={"login_id"}), @ORM\Index(name="FK_USUARIO_NIVEL", columns={"nivel_id"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Usuario\Entity\UsuarioRepository")
 */
class Usuario extends AbstractEntity {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=45, nullable=false)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=45, nullable=false)
     */
    private $email;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", nullable=false)
     */
    private $status = 0;

    /**
     * @var \Login\Entity\Login
     *
     * @ORM\ManyToOne(targetEntity="Login\Entity\Login")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="login_id", referencedColumnName="id")
     * })
     */
    private $login;

    /**
     * @var \Nivel\Entity\Nivel
     *
     * @ORM\ManyToOne(targetEntity="Nivel\Entity\Nivel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="nivel_id", referencedColumnName="id")
     * })
     */
    private $nivel = 1;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set nome
     *
     * @param string $nome
     *
     * @return Usuario
     */
    public function setNome($nome) {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNome() {
        return $this->nome;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Usuario
     */
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return Usuario
     */
    public function setStatus($status) {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Set login
     *
     * @param \Login\Entity\Login $login
     *
     * @return Usuario
     */
    public function setLogin(\Login\Entity\Login $login = null) {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return \Login\Entity\Login
     */
    public function getLogin() {
        return $this->login;
    }

    /**
     * Set nivel
     *
     * @param \Nivel\Entity\Nivel $nivel
     *
     * @return Usuario
     */
    public function setNivel(\Nivel\Entity\Nivel $nivel = null) {
        $this->nivel = $nivel;

        return $this;
    }

    /**
     * Get nivel
     *
     * @return \Nivel\Entity\Nivel
     */
    public function getNivel() {
        return $this->nivel;
    }

}
