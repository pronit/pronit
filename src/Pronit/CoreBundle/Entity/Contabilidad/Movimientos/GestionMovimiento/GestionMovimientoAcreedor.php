<?php
namespace Pronit\CoreBundle\Entity\Contabilidad\Movimientos\GestionMovimiento;

use Doctrine\ORM\Mapping as ORM;
use Pronit\CoreBundle\Entity\Personas\Acreedor;
use Pronit\CoreBundle\Entity\Contabilidad\Movimientos\Movimiento;

/** 
 * @ORM\Entity
 */
class GestionMovimientoAcreedor extends GestionMovimiento
{
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Personas\Acreedor")
     */    
    protected $acreedor;

    public function __construct(Movimiento $movimientoGestionado, Acreedor $acreedor)
    {
        parent::__construct($movimientoGestionado);
        $this->setAcreedor($acreedor);
    }
    
    function getAcreedor()
    {
        return $this->acreedor;
    }

    function setAcreedor(Acreedor $acreedor)
    {
        $this->acreedor = $acreedor;
    }    
}