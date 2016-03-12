<?php

namespace Pronit\CoreBundle\Entity\Controlling;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Pronit\CoreBundle\Entity\Contabilidad\CuentasContables\Cuenta;
use Pronit\CoreBundle\Entity\Documentos\Item as ItemDocumento;

/**
 * @ORM\Entity
 * @ORM\Table(name="controlling_imputacionobjetocosto")
 */
class Imputacion {

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="ObjetoCosto", inversedBy="imputaciones") 
     */
    private $objetoCosto;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Contabilidad\CuentasContables\Cuenta") 
     */
    private $cuentaContable;

    /**
     *
     * @ORM\OneToMany(targetEntity="ItemImputacion", mappedBy="imputacion", cascade={"ALL"})
     * 
     * @var ArrayCollection
     */
    private $items;

    /**
     * @ORM\Column(type="float")
     */
    private $importe;

    public function __construct(ObjetoCosto $objetoCosto, Cuenta $cuentaContable) {
        $this->importe = 0;
        $this->items = new ArrayCollection();
        $this->objetoCosto = $objetoCosto;
        $this->cuentaContable = $cuentaContable;
    }

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

    public function setObjetoCosto($objetoCosto) {
        $this->objetoCosto = $objetoCosto;
    }

    /**
     * 
     * @return Cuenta
     */
    public function getCuentaContable() {
        return $this->cuentaContable;
    }

    public function setCuentaContable($cuentaContable) {
        $this->cuentaContable = $cuentaContable;
    }

    public function addItem(DateTime $fecha, ItemDocumento $item, $importe) {
        $this->items->add(new ItemImputacion($this, $fecha, $item, $importe));
        $this->importe += $importe;
    }
    
    /**
     * 
     * @return ArrayCollection
     */
    public function getItems() {
        return $this->items;
    }

}
