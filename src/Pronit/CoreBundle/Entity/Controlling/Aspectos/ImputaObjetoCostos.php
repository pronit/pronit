<?php

namespace Pronit\CoreBundle\Entity\Controlling\Aspectos;

use Doctrine\ORM\Mapping as ORM;
use Pronit\CoreBundle\Entity\Aspectos\Aspecto;
use Pronit\CoreBundle\Entity\Operaciones\Operacion;

/**
 *
 * @author ldelia
 * @ORM\Entity
 */
class ImputaObjetoCostos extends Aspecto {

    /**
     * 
     * @ORM\Column(type="integer")
     * 
     * @var int
     */
    private $signo;

    public function __construct(Operacion $operacion) {
        parent::__construct($operacion);
    }

}
