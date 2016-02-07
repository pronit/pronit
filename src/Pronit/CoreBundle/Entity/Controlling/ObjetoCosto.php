<?php

namespace Pronit\CoreBundle\Entity\Controlling;

use Doctrine\ORM\Mapping as ORM;
use \Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\EntradaMercancias;
use Pronit\CoreBundle\Entity\Contabilidad\CuentasContables\Cuenta;
/** 
 * @ORM\Entity
 * @ORM\Table(name="controlling_objetocosto")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
        "CentroCostoValue" = "Pronit\CoreBundle\Entity\Controlling\CentroCosto",
        "CentroBeneficioValue" = "Pronit\CoreBundle\Entity\Controlling\CentroBeneficio", 
        "OrdenValue" = "Pronit\CoreBundle\Entity\Controlling\Orden"
    })
 */
abstract class ObjetoCosto
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    protected $id;    
    
    /**
     * @ORM\Column(type="string", length=100)
     */        
    protected $nombre;
    
    public function __construct()
    {
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setNombre($valor)
    {
        $this->nombre = $valor;
    }
    
    public function getNombre()
    {
        return $this->nombre;
    }
    public function __toString() 
    {        
        return (string)$this->getNombre();
    }
}

