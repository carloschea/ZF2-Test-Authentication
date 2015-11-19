<?php

namespace Login\Entity;

use Base\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * AlterarSenha
 *
 * @ORM\Table(name="alterar_senha", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQUE_ALTERAR_SENHA_LOGIN_ID", columns={"login_id"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Login\Entity\AlterarSenhaRepository")
 */
class AlterarSenha extends AbstractEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=60, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $token;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_request", type="datetime", nullable=false)
     */
    private $dateRequest;

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
     * Set token
     *
     * @return string
     */
    public function setToken()
    {
        return $this->token;
    }
    
    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set dateRequest
     *
     * @param \DateTime $dateRequest
     *
     * @return AlterarSenha
     */
    public function setDateRequest($dateRequest)
    {
        $this->dateRequest = $dateRequest;
    
        return $this;
    }

    /**
     * Get dateRequest
     *
     * @return \DateTime
     */
    public function getDateRequest()
    {
        return $this->dateRequest;
    }

    /**
     * Set login
     *
     * @param \Login\Entity\Login $login
     *
     * @return AlterarSenha
     */
    public function setLogin(\Login\Entity\Login $login = null)
    {
        $this->login = $login;
    
        return $this;
    }

    /**
     * Get login
     *
     * @return \Login\Entity\Login
     */
    public function getLogin()
    {
        return $this->login;
    }
}
