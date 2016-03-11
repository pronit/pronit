<?php

namespace Pronit\CoreBundle\Entity\Controlling;

use Doctrine\ORM\Mapping as ORM;

use Pronit\CoreBundle\Entity\Contabilidad\CuentasContables\Cuenta;

use Pronit\CoreBundle\Entity\Documentos\Item;

/** 
 * @ORM\Entity
 * @ORM\Table(name="controlling_imputacionobjetocosto")
 */
class Imputacion 
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    protected $id;    

    /** 
     * @ORM\ManyToOne(targetEntity="ObjetoCosto", inversedBy="imputaciones") 
     */
    protected $objetoCosto;    

    /** 
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Contabilidad\CuentasContables\Cuenta") 
     */
    protected $cuentaContable;    
    
    /**
     * @ORM\Column(type="float")
     */    
    protected $importe;    
    
    /**
     * @ORM\Column(type="date")
     */    
    protected $fecha;    
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Documentos\Item") 
     */
    protected $item;    

    function getImporte() 
    {
        return $this->importe;
    }

    function setImporte($importe) 
    {
        $this->importe = $importe;
    }    
    
    function getObjetoCosto() {
        return $this->objetoCosto;
    }

    function setObjetoCosto($objetoCosto) {
        $this->objetoCosto = $objetoCosto;
    }

    function getFecha() {
        return $this->fecha;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }    
    
    function getCuentaContable() {
        return $this->cuentaContable;
    }

    function setCuentaContable($cuentaContable) {
        $this->cuentaContable = $cuentaContable;
    }    
    
    function getItem() 
    {
        return $this->item;
    }

    function setItem(Item $item) 
    {
        $this->item = $item;
    }    
}
