<?php

namespace Pronit\CoreBundle\Entity\Controlling;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Pronit\CoreBundle\Entity\Contabilidad\CuentasContables\Cuenta;
use Pronit\CoreBundle\Entity\Documentos\Item as ItemDocumento;

/**
 * @ORM\Entity
 * @ORM\Table(name="controlling_imputacionobjetocosto")
 */
class Imputacion {

    /**
     * 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="ObjetoCosto", inversedBy="imputaciones") 
     * 
     * @var ObjetoCosto
     */
    private $objetoCosto;

    /**
     * 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Documentos\Item")
     *
     * @var ItemDocumento
     */
    private $itemDocumento;

    /**
     * 
     * @ORM\Column(type="date")
     * 
     * @var DateTime
     */
    private $fecha;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Contabilidad\CuentasContables\Cuenta") 
     */
    private $cuentaContable;

    /**
     * @ORM\Column(type="float")
     */
    private $importe;

    public function __construct(ObjetoCosto $objetoCosto, DateTime $fecha, ItemDocumento $itemDocumento, Cuenta $cuentaContable, $importe) {
        $this->importe = $importe;
        $this->objetoCosto = $objetoCosto;
        $this->cuentaContable = $cuentaContable;
        $this->itemDocumento = $itemDocumento;
        $this->fecha = $fecha;
    }

    /**
     * 
     * @return float
     */
    public function getImporte() {
        return $this->importe;
    }

    /**
     * 
     * @return ObjetoCosto
     */
    public function getObjetoCosto() {
        return $this->objetoCosto;
    }

    /**
     * 
     * @return Cuenta
     */
    public function getCuentaContable() {
        return $this->cuentaContable;
    }

    /**
     * 
     * @return DateTime
     */
    public function getFecha() {
        return $this->fecha;
    }

    /**
     * 
     * @return Item
     */
    public function getItemDocumento() {
        return $this->itemDocumento;
    }

}
