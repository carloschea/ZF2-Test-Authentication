<?php

namespace Login\Service;

use Base\Service\AbstractService;
use Doctrine\ORM\EntityManager;

/**
 * Description of LoginService
 *
 * @author Rick
 */
class LoginService extends AbstractService {

    public function __construct(EntityManager $em) {
        $this->entity = 'Login\Entity\Login';
        parent::__construct($em);
    }

}
