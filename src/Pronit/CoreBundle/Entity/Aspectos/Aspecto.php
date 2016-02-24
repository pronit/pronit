<?php

namespace Pronit\CoreBundle\Entity\Aspectos;

use Doctrine\ORM\Mapping as ORM;
use Pronit\CoreBundle\Entity\Operaciones\Operacion;

/** 
 * @ORM\Entity
 * @ORM\Table(name="core_aspectos")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
        "ImputaObjetoCostosValue" = "Pronit\CoreBundle\Entity\Controlling\Aspectos\ImputaObjetoCostos", 
    })
 */
abstract class Aspecto 
{
   /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;    
    
    /** 
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Operaciones\Operacion") 
     */
    private $operacion;
    
    function getOperacion() 
    {
        return $this->operacion;
    }

    public function __construct(Operacion $operacion) 
    {
        $this->operacion = $operacion;
    }    
}
