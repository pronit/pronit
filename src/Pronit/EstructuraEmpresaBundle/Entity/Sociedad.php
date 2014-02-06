<?php

namespace Pronit\EstructuraEmpresaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="eempre_sociedades")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"sociedadco" = "SociedadCO", "sociedadgl" = "SociedadGL", "sociedadfi" = "SociedadFI"})
 */
abstract class Sociedad
{    
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    private $id;
       
    /**
     * @ORM\Column(type="string", length=100)
     */    
    private $nombre;
    
    /**
     * @ORM\Column(type="string", length=20)
     */    
    private $abreviatura;
    
    /**
     * @ORM\Column(type="string", length=100)
     */        
    private $nombreFantasia;
    
    /**
     * @ORM\Column(type="boolean")
     */        
    private $activa;
    
    //private $oficinaEnteControladorImpositivo;

    /**
     * @ORM\Column(type="date")
     */            
    private $fechaFundacion;

    /**
     * @ORM\OneToMany(targetEntity="VarianteEjercicioSociedad", mappedBy="sociedad", cascade={"persist"}, orphanRemoval=true)
     */        
    private $variantesEjercicio;    

    public function __construct()
    {
        $this->variantesEjercicio = new ArrayCollection();
    }
   
    public function getId()
    {
        return $this->id;
    }    
        
    public function setNombre($valor)
    {
        $this->nombre = $valor;
    }
    
    public function getNombre()
    {
        return $this->nombre;
    }
    
    
    public function setAbreviatura($value)
    {
        $this->abreviatura = $value;
    }
    
    public function getAbreviatura()
    {
        return $this->abreviatura;
    }
    
    public function setNombreFantasia($value)
    {
        $this->nombreFantasia = $value;
    }
    
    public function getNombreFantasia()
    {
        return $this->nombreFantasia;
    }
    
    public function setActiva($value)
    {
        $this->activa = $value;
    }
    
    public function isActiva()
    {
        return $this->activa;
    }
    
    public function setFechaFundacion($value)
    {
        $this->fechaFundacion = $value;
    }
    
    public function getFechaFundacion()
    {
        return $this->fechaFundacion;
    }
    
    public function getVariantesEjercicio()
    {
        return $this->variantesEjercicio;
    }
    
    public function addVariantesEjercicio( VarianteEjercicioSociedad $varianteEjercicio )
    {
        $varianteEjercicio->setSociedad($this);
        $this->getVariantesEjercicio()->add($varianteEjercicio);
    }

    public function removeVariantesEjercicio( VarianteEjercicioSociedad $varianteEjercicio )
    {
        $this->getVariantesEjercicio()->removeElement($varianteEjercicio);
    }
    
    
    public function __toString() 
    {
        return (string)$this->getNombre();
    }
}

