<?php

namespace Pronit\CoreBundle\Entity\Controlling;

use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Pronit\CoreBundle\Entity\Documentos\Item;

/**
 * Componente del detalle de una imputación
 *
 * @ORM\Entity
 * @ORM\Table(
 *      name="controlling_itemimputacionobjetocosto", 
 *      uniqueConstraints={
 *          @ORM\UniqueConstraint(name="itemimputacion_unique", columns={"objetoCosto_id", "cuentaContable_id", "itemDocumento_id"})
 *      }
 * )
 * 
 * @author gcaseres
 */
class ItemImputacion {
    
    /**
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * 
     * @ORM\ManyToOne(targetEntity="Imputacion", inversedBy="items") 
     * @ORM\JoinColumns({
     *      @ORM\JoinColumn(name="objetoCosto_id", referencedColumnName="objetoCosto_id"),
     *      @ORM\JoinColumn(name="cuentaContable_id", referencedColumnName="cuentaContable_id")
     * })
     * 
     * @var Imputacion
     */
    private $imputacion;
    
    /**
     * 
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Documentos\Item")
     *
     * @var Item
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
     * @ORM\Column(type="float")
     * 
     * @var float
     */
    private $importe;

    public function __construct(Imputacion $imputacion, DateTime $fecha, Item $item, $importe) {
        $this->fecha = $fecha;
        $this->itemDocumento = $item;
        $this->importe = $importe;
        $this->imputacion = $imputacion;
    }
    
    /**
     * 
     * @return Item
     */
    public function getItemDocumento() {
        return $this->itemDocumento;
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
     * @return float
     */
    public function getImporte() {
        return $this->importe;
    }
}
