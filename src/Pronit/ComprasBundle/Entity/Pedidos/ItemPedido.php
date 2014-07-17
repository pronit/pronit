<?php

namespace Pronit\ComprasBundle\Entity\Pedidos;

use Doctrine\ORM\Mapping as ORM;

use Pronit\CoreBundle\Entity\Documentos\Item;
use Pronit\ParametrizacionGeneralBundle\Entity\Escala;
use Pronit\GestionBienesYServiciosBundle\Entity\BienServicio;

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
     * @ORM\ManyToOne(targetEntity="Pronit\GestionBienesYServiciosBundle\Entity\BienServicio")
     */    
    protected $bienservicio;    
    
    /**
     * @ORM\Column(type="float")
     */    
    protected $cantidad;
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\ParametrizacionGeneralBundle\Entity\Escala")
     */    
    protected $escala;    
    
    /**
     * @ORM\Column(type="float")
     */    
    protected $importe;    
    
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
        /** @todo validar que $escala sea parte de $material->getSistemaMedicion() */        
        $this->escala = $escala;
    }

    public function setImporte($importe)
    {
        $this->importe = $importe;
    }
    
    public function getBienServicio()
    {
        return $this->bienservicio;
    }

    public function setBienServicio(BienServicio $bienServicio)
    {
        $this->bienservicio = $bienServicio;
    }    
}

