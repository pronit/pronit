<?php

namespace Pronit\CoreBundle\Entity\Documentos\Ventas;

use Doctrine\ORM\Mapping as ORM;

use Pronit\CoreBundle\Entity\Documentos\Item;
use Pronit\ParametrizacionGeneralBundle\Entity\Escala;
use Pronit\GestionBienesYServiciosBundle\Entity\BienServicio;

abstract class ItemVentas extends Item
{
    /**
     * @ORM\Column(type="float")
     */    
    protected $cantidad;
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\ParametrizacionGeneralBundle\Entity\Escala")
     */    
    protected $escala;    
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\GestionBienesYServiciosBundle\Entity\BienServicio")
     */    
    protected $bienServicio;    
    
    /**
     * @ORM\Column(type="float")
     */    
    protected $precioUnitario;    

    public function getPrecioUnitario()
    {
        return $this->precioUnitario;
    }

    public function setPrecioUnitario($precioUnitario)
    {
        $this->precioUnitario = $precioUnitario;
    }    
    
    public function getImporteNeto()
    {
        return $this->getPrecioUnitario() * $this->getCantidad();
    }    
            
    public function getBienServicio()
    {
        return $this->bienServicio;
    }

    public function setBienServicio(BienServicio $bienServicio)
    {
        $this->bienServicio = $bienServicio;
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

    public function setEscala(Escala $escala)
    {
        /** @todo validar que $escala sea parte de $material->getSistemaMedicion() */        
        $this->escala = $escala;
    }
    
}

