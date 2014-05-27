<?php

namespace Pronit\ContabilidadBundle\Entity\CuentasContables;

use Doctrine\ORM\Mapping as ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="conta_itemplancuentas")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"ItemCuentaPlanCuentasValue" = "Pronit\ContabilidadBundle\Entity\CuentasContables\ItemCuentaPlanCuentas"})
 */
abstract class ItemPlanCuentas
{
   /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;    
    
    /**
     * @ORM\Column(type="string")
     */        
    protected $codigo;

    /** @ORM\ManyToOne(targetEntity="PlanCuentas", inversedBy="items") */
    private $planCuentas;    
 
    public function __construct()
    {
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function getCodigo()
    {
        return $this->codigo;
    }

    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }    

    public function getPlanCuentas()
    {
        return $this->planCuentas;
    }

    public function setPlanCuentas($planCuentas)
    {
        $this->planCuentas = $planCuentas;
    }    
}
