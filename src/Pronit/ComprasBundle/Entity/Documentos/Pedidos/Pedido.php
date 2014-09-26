<?php

namespace Pronit\ComprasBundle\Entity\Documentos\Pedidos;

use Exception;
use Doctrine\ORM\Mapping as ORM;

use Pronit\ComprasBundle\Entity\Documentos\AbastecimientoExterno;
use Pronit\ComprasBundle\Entity\Documentos\Pedidos\Estados\EstadoPedido;
use Pronit\ComprasBundle\Entity\Documentos\Pedidos\Estados\SinEntregar;

use Pronit\CoreBundle\Entity\Documentos\Item;
use Pronit\ComprasBundle\Entity\Documentos\Pedidos\ItemPedido;

/**
 *
 * @author ldelia
 * @ORM\Entity
 */
class Pedido extends AbastecimientoExterno
{      
    /**
     * @ORM\OneToOne(targetEntity="Pronit\ComprasBundle\Entity\Documentos\Pedidos\Estados\EstadoPedido", cascade={"persist", "remove"}, orphanRemoval=true)
     **/    
    protected $estado;
    
    public function __construct()
    {
        parent::__construct();
        $this->setEstado( new SinEntregar() );
    }    
    
    public function addItem(Item $item)
    {
        if (! $item instanceof ItemPedido )
        {
            throw new Exception;
        }
        
        parent::addItem($item);
    }    
    
    public function getEstado()
    {
        return $this->estado;
    }

    public function setEstado(EstadoPedido $estado)
    {
        $this->estado = $estado;
    }    
}

