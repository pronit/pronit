<?php
namespace Pronit\CoreBundle\Entity\Contabilidad\Movimientos\GestionMovimiento;

use Pronit\CoreBundle\Entity\Contabilidad\Movimientos\Movimiento;
use Pronit\CoreBundle\Entity\Contabilidad\Movimientos\GestionMovimiento\GestionMovimiento;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="core_gestionmovimiento_movimientocompensatorio")
 */
class MovimientoCompensatorio
{
    
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Contabilidad\Movimientos\GestionMovimiento\GestionMovimiento")
     */
    private $gestionMovimiento;
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Contabilidad\Movimientos\Movimiento")
     */
    private $movimiento;
    
    public function __construct(GestionMovimiento $gestionMovimiento, Movimiento $movimiento)
    {
        $this->gestionMovimiento = $gestionMovimiento;
        $this->movimiento = $movimiento;
    }
    
    public function getImporte() {
        return abs($this->movimiento->getImporte());
    }
}