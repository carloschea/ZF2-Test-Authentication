<?php

namespace Categoria\Service;

use Base\Service\AbstractService;
use Doctrine\ORM\EntityManager;

/**
 * Description of CategoriaService
 *
 * @author Rick
 */
class CategoriaService extends AbstractService {

    public function __construct(EntityManager $em) {
        $this->entity = 'Categoria\Entity\Category';
        parent::__construct($em);
    }

}
