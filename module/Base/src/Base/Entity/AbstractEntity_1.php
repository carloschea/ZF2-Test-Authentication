<?php

namespace Base\Entity;

use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * Description of AbstractEntity
 *
 * @author Rick
 */
abstract class AbstractEntity {
    
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    public function __construct(Array $options = array()) {
        $hydrator = new ClassMethods();
        $hydrator->hydrate($options, $this);
    }

    public function toArray() {
        $hydrator = new ClassMethods();
        return $hydrator->extract($this);
    }

}
