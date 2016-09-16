<?php

namespace Pronit\ComprasBundle\Entity\Documentos;

use Doctrine\ORM\Mapping as ORM;

use Pronit\CoreBundle\Entity\Documentos\Item;
use Pronit\ParametrizacionGeneralBundle\Entity\Escala;
use Pronit\GestionBienesYServiciosBundle\Entity\BienServicio;
use Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones\PresentacionCompra;


abstract class ItemCompras extends Item
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
     * @todo esto debería desaparecer. Se deja para mantener compatibilidad
     * @ORM\ManyToOne(targetEntity="Pronit\GestionBienesYServiciosBundle\Entity\BienServicio")
     */    
    protected $bienServicio;    
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones\PresentacionCompra")
     */    
    protected $presentacionCompra;
                
    public function getBienServicio()
    {
        return $this->bienServicio;
    }

    public function setBienServicio(BienServicio $bienServicio)
    {
        $this->bienServicio = $bienServicio;
    }

    /**
     * @return PresentacionCompra
     */
    function getPresentacionCompra() 
    {
        return $this->presentacionCompra;
    }

    function setPresentacionCompra(PresentacionCompra $presentacionCompra) 
    {
        $this->presentacionCompra = $presentacionCompra;
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

