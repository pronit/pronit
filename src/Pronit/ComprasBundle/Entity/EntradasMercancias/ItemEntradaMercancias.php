<?php

namespace Pronit\ComprasBundle\Entity\EntradasMercancias;

use Doctrine\ORM\Mapping as ORM;

use Pronit\CoreBundle\Entity\Documentos\Item;
use Pronit\ComprasBundle\Entity\Pedidos\ItemPedido;
use Pronit\GestionBienesYServiciosBundle\Entity\Material;

/**
 *
 * @author ldelia
 * @ORM\Entity
*/
class ItemEntradaMercancias extends Item
{
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\GestionBienesYServiciosBundle\Entity\Material")
     */    
    protected $material;    
    
    /**
     * @ORM\Column(type="float")
     */    
    protected $cantidad;
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\ComprasBundle\Entity\Pedidos\ItemPedido")
     */    
    protected $itemPedido;    
    
    /**
     * @ORM\Column(type="float")
     */    
    protected $precioUnitario;    
        
    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }    
    
    /**
     * 
     * @return \Pronit\GestionBienesYServiciosBundle\Entity\Material
     */
    public function getMaterial()
    {
        return $this->material;
    }

    public function setMaterial(Material $material)
    {
        $this->material = $material;
    }    
    
    public function getItemPedido()
    {
        return $this->itemPedido;
    }

    public function setItemPedido(ItemPedido $itemPedido)
    {
        $this->itemPedido = $itemPedido;
    }
    
    public function getPrecioUnitario()
    {
        return $this->precioUnitario;
    }

    public function setPrecioUnitario($precioUnitario)
    {
        $this->precioUnitario = $precioUnitario;
    }    
}

