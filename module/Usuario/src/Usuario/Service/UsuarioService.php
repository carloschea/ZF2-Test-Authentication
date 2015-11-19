<?php

namespace Usuario\Service;

use Base\Service\AbstractService;
use Doctrine\ORM\EntityManager;

/**
 * Description of UsuarioService
 *
 * @author Rick
 */
class UsuarioService extends AbstractService {

    public function __construct(EntityManager $em) {
        $this->entity = 'Usuario\Entity\Usuario';
        
        parent::__construct($em);
    }

    public function save(Array $data = array()) {
        $data['login'] = $this->em->getRepository('Login\Entity\Login')->find($data['login']);
        $data['nivel'] = $this->em->getRepository('Nivel\Entity\Nivel')->find($data['nivel']);
        return parent::save($data);
    }

}
