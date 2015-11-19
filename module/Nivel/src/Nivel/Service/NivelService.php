<?php

namespace Nivel\Service;

use Base\Service\AbstractService;
use Doctrine\ORM\EntityManager;

/**
 * Description of NivelService
 *
 * @author Rick
 */
class NivelService extends AbstractService {

    public function __construct(EntityManager $em) {
        $this->entity = 'Nivel\Entity\Nivel';
        parent::__construct($em);
    }

}
