<?php

namespace Pronit\GestionBienesYServiciosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones\PresentacionCompra;
use Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones\PresentacionVenta;

use \Doctrine\Common\Collections\ArrayCollection;
/**
 * 
 *
 * @author ldelia
 * @ORM\Entity
 */
class Material extends BienServicio
{    
    /**
     * @ORM\OneToMany(targetEntity="Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones\PresentacionCompra", cascade={"ALL"}, mappedBy="material")
     */    
    protected $presentacionesCompra;
    
    /**
     * @ORM\OneToMany(targetEntity="Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones\PresentacionVenta", cascade={"ALL"}, mappedBy="material")
     */    
    protected $presentacionesVenta;    

    public function __construct()
    {
        $this->setPresentacionesCompra( new ArrayCollection() );
        $this->setPresentacionesVenta( new ArrayCollection() );
    }
    
    public function getPresentacionesCompra()
    {
        return $this->presentacionesCompra;
    }
    
    public function setPresentacionesCompra($presentacionCompra)
    {
        /* Lo necesita Sonada para el CRUD de Materiales */
        $this->presentacionesCompra = $presentacionCompra;
    }    

    public function addPresentacionesCompra(PresentacionCompra $presentacionCompra)
    {
        /* @todo este metodo lo necesita Sonata para el CRUD de materiales. */
        $this->addPresentacionCompra($presentacionCompra);
    }
            
    public function addPresentacionCompra(PresentacionCompra $presentacionCompra)
    {
        $presentacionCompra->setMaterial($this);
        $this->presentacionesCompra[] = $presentacionCompra;
    }

    public function removePresentacionCompra(PresentacionCompra $presentacionCompra)
    {
        $this->presentacionesCompra->removeElement( $presentacionCompra );
    }    

    public function getPresentacionesVenta()
    {
        return $this->presentacionesVenta;
    }

    public function setPresentacionesVenta($presentacionVenta)
    {
        /* Lo necesita Sonada para el CRUD de Materiales */
        $this->presentacionesVenta = $presentacionVenta;
    }    

    public function addPresentacionesVenta(PresentacionVenta $presentacionVenta)
    {
        /* Lo necesita Sonada para el CRUD de Materiales */
        $this->addPresentacionVenta($presentacionVenta);
    }
    
    public function addPresentacionVenta(PresentacionVenta $presentacionVenta)
    {
        $presentacionVenta->setMaterial($this);
        $this->presentacionesVenta[] = $presentacionVenta;
    }

    public function removePresentacionVenta(PresentacionVenta $presentacionVenta)
    {
        $this->presentacionesVenta->removeElement( $presentacionVenta );
    }    
    
}