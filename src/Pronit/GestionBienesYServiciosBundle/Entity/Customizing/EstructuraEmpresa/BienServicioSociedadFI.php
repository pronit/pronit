<?php

namespace Pronit\GestionBienesYServiciosBundle\Entity\Customizing\EstructuraEmpresa;

use Doctrine\ORM\Mapping as ORM;

use Pronit\EstructuraEmpresaBundle\Entity\SociedadFI;
use Pronit\GestionBienesYServiciosBundle\Entity\BienServicio;
/**
 * 
 *
 * @author ldelia
 * @ORM\Entity
 * @ORM\Table(name="gestionbienesyservicios_bienesserviciossociedadesfi")
 */
class BienServicioSociedadFI
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Pronit\GestionBienesYServiciosBundle\Entity\BienServicio")
     */    
    protected $bienServicio;    
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\EstructuraEmpresaBundle\Entity\SociedadFI")
     */    
    protected $sociedadFI;    
    
    /**
     * @ORM\Column(type="string", length=10)
     */        
    protected $codigo;
    
    /**
     * @ORM\Column(type="float", nullable=true)
     */    
    protected $precioValoracionPromedio;    

    /**
     * @ORM\Column(type="float", nullable=true)
     */    
    protected $precioValoracionEstandar;        
    
    public function getId()
    {
        return $this->id;
    }
 
    /**
     * 
     * @return BienServicio
     */
    public function getBienServicio()
    {
        return $this->bienServicio;
    }

    public function setBienServicio(BienServicio $bienServicio)
    {
        $this->bienServicio = $bienServicio;
    }
    
    /**
     * 
     * @return SociedadFI
     */    
    public function getSociedadFI()
    {
        return $this->sociedadFI;
    }

    public function setSociedadFI(SociedadFI $sociedadFI)
    {
        $this->sociedadFI = $sociedadFI;
    }    
    
    public function getCodigo()
    {
        return $this->codigo;
    }

    public function getPrecioValoracionPromedio()
    {
        return $this->precioValoracionPromedio;
    }

    public function getPrecioValoracionEstandar()
    {
        return $this->precioValoracionEstandar;
    }

    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    public function setPrecioValoracionPromedio($precioValoracionPromedio)
    {
        $this->precioValoracionPromedio = $precioValoracionPromedio;
    }

    public function setPrecioValoracionEstandar($precioValoracionEstandar)
    {
        $this->precioValoracionEstandar = $precioValoracionEstandar;
    }  
    
    public function __toString()
    {
        return $this->getBienServicio() . ' (' . $this->getSociedadFI() . ')';
    }
}