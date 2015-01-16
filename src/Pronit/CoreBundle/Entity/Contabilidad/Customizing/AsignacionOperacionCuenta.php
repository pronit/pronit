<?php

namespace Pronit\CoreBundle\Entity\Contabilidad\Customizing;

use Doctrine\ORM\Mapping as ORM;

use Pronit\CoreBundle\Entity\Operaciones\Operacion;
use Pronit\CoreBundle\Entity\Contabilidad\CuentasContables\Cuenta;
/**
 *
 * @author ldelia
 * @ORM\Entity
 * @ORM\Table(name="conta_asignacionoperacioncuenta")
 */
class AsignacionOperacionCuenta
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Operaciones\Operacion")
     * @ORM\JoinColumn(nullable=false)
     */    
    protected $operacion;    

    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Contabilidad\CuentasContables\Cuenta")
     * @ORM\JoinColumn(nullable=false)
     */    
    protected $cuenta;    
    
    public function getId()
    {
        return $this->id;
    }

    public function getOperacion()
    {
        return $this->operacion;
    }

    public function getCuenta()
    {
        return $this->cuenta;
    }

    public function setOperacion(Operacion $operacion)
    {
        $this->operacion = $operacion;
    }

    public function setCuenta(Cuenta $cuenta)
    {
        $this->cuenta = $cuenta;
    }
}
