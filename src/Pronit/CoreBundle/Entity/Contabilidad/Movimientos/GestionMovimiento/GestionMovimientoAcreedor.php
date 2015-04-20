<?php

namespace Pronit\CoreBundle\Entity\Contabilidad\Movimientos\GestionMovimiento;

use Doctrine\ORM\Mapping as ORM;
use Pronit\CoreBundle\Entity\Personas\Acreedor;
use Pronit\CoreBundle\Entity\Contabilidad\Movimientos\Movimiento;

/**
 * @ORM\Entity
 */
class GestionMovimientoAcreedor extends GestionMovimiento {

    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Personas\Acreedor")
     */
    protected $acreedor;

    /**
     *
     * @var \DateTime
     * @ORM\Column(type="date") 
     */
    private $fechaVencimiento;

    public function __construct(Movimiento $movimientoGestionado, Acreedor $acreedor, \DateTime $fechaVencimiento = null) {
        parent::__construct($movimientoGestionado);
        $this->setAcreedor($acreedor);
        $this->fechaVencimiento = $fechaVencimiento;
    }

    function getAcreedor() {
        return $this->acreedor;
    }

    function setAcreedor(Acreedor $acreedor) {
        $this->acreedor = $acreedor;
    }

    /**
     * 
     * @param \DateTime $value
     */
    function setFechaVencimiento(\DateTime $value) {
        $this->fechaVencimiento = $value;
    }

    /**
     * 
     * @return \DateTime
     */
    function getFechaVencimiento() {
        return $this->fechaVencimiento;
    }

}
