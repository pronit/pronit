<?php
namespace Pronit\CoreBundle\Entity\Contabilidad\Movimientos\GestionMovimiento;

use Pronit\CoreBundle\Entity\Contabilidad\Movimientos\Movimiento;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="core_gestionmovimiento")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
    "GestionMovimientoDeudorValue" = "Pronit\CoreBundle\Entity\Contabilidad\Movimientos\GestionMovimiento\GestionMovimientoDeudor",
    "GestionMovimientoAcreedorValue" = "Pronit\CoreBundle\Entity\Contabilidad\Movimientos\GestionMovimiento\GestionMovimientoAcreedor"
 })
 */
abstract class GestionMovimiento
{
    
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Contabilidad\Movimientos\Movimiento")
     */
    private $movimientoGestionado;
    
    /**
     * @ORM\OneToMany(targetEntity="Pronit\CoreBundle\Entity\Contabilidad\Movimientos\GestionMovimiento\MovimientoCompensatorio", mappedBy="gestionMovimiento")
     */
    private $movimientosCompensatorios;
    
    public function __construct(Movimiento $movimientoGestionado)
    {
        $this->movimientoGestionado = $movimientoGestionado;
        $this->movimientosCompensatorios = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    function getMovimientoGestionado()
    {
        return $this->movimientoGestionado;
    }    
    
    public function __toString()
    {
        return (string) $this->getMovimientoGestionado();
    }
}