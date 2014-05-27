<?php

namespace Pronit\ComprasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Pronit\CoreBundle\Entity\Documentos\Item;
use Pronit\ParametrizacionGeneralBundle\Entity\Escala;
use Pronit\GestionMaterialesBundle\Entity\Material;

/**
 *
 * @author ldelia
 */
/** 
 * @ORM\Entity
*/
class ItemPedido extends Item
{
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\GestionMaterialesBundle\Entity\Material")
     * @ORM\JoinColumn(nullable=false)
     */    
    protected $material;    
    
    /**
     * @ORM\Column(type="float")
     */    
    protected $cantidad;
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\ParametrizacionGeneralBundle\Entity\Escala")
     * @ORM\JoinColumn(nullable=false)
     */    
    protected $escala;    
    
    /**
     * @ORM\Column(type="float")
     */    
    protected $importe;    
    
    public function __construct(Material $material, $cantidad, Escala $escala, $importe)
    {
        parent::__construct();
        
        $this->setMaterial($material);
        $this->setCantidad($cantidad);
        $this->setEscala($escala);
        $this->setImporte($importe);

        /** @todo validar que $escala sea parte de $material->getSistemaMedicion() */
    }    
    
    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }    
    
    public function getEscala()
    {
        return $this->escala;
    }

    public function getImporte()
    {
        return $this->importe;
    }

    public function setEscala(Escala $escala)
    {
        $this->escala = $escala;
    }

    public function setImporte($importe)
    {
        $this->importe = $importe;
    }
    
    public function getMaterial()
    {
        return $this->material;
    }

    public function setMaterial(Material $material)
    {
        $this->material = $material;
    }    
}

