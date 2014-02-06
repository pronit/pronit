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
    

    public function getId()
    {
        return $this->id;
    }    
            
     /**
     *
     * @ORM\OneToMany(targetEntity="MonedaLegal", mappedBy="sociedad", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $monedasLegales;

     /**
     *
     * @ORM\OneToMany(targetEntity="MonedaFuerte", mappedBy="sociedad", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $monedasFuertes;
    
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
    
    public function setMonedasLegales($value)
    {
        $this->monedasLegales = $value;
    }
    
    public function getMonedasLegales()
    {
        return $this->monedasLegales;
    }
    
    /**
     * Este método es un Alias de <u>Sociedad::addMonedaLegal()</u>
     * 
     * Se utiliza debido a que symfony realiza singularización solo en inglés.
     * 
     * @param \Pronit\EstructuraEmpresaBundle\Entity\MonedaLegal $moneda
     */
    public function addMonedasLegale(MonedaLegal $moneda)
    {
        $this->addMonedaLegal($moneda);
    }

    /**
     * Este método es un Alias de <u>Sociedad::removeMonedaLegal()</u>
     * 
     * Se utiliza debido a que symfony realiza singularización solo en inglés.
     * 
     * @param \Pronit\EstructuraEmpresaBundle\Entity\MonedaLegal $moneda
     */
    public function removeMonedasLegale(MonedaLegal $moneda)
    {
        $this->removeMonedaLegal($moneda);
    }
    
    
    public function addMonedaLegal(MonedaLegal $moneda)
    {        
        $moneda->setSociedad($this);
        $this->monedasLegales->add($moneda);
    }

    public function removeMonedaLegal(MonedaLegal $moneda)
    {
        $this->monedasLegales->removeElement($moneda);
        
    }

    
    
    public function setMonedasFuertes($value)
    {
        $this->monedasFuertes = $value;
    }
    
    public function getMonedasFuertes()
    {
        return $this->monedasFuertes;
    }
    
    /**
     * Este método es un Alias de <u>Sociedad::addMonedaFuerte()</u>
     * 
     * Se utiliza debido a que symfony realiza singularización solo en inglés.
     * 
     * @param \Pronit\EstructuraEmpresaBundle\Entity\MonedaFuerte $moneda
     */
    public function addMonedasFuerte(MonedaFuerte $moneda)
    {
        $this->addMonedaFuerte($moneda);
    }

    /**
     * Este método es un Alias de <u>Sociedad::removeMonedaFuerte()</u>
     * 
     * Se utiliza debido a que symfony realiza singularización solo en inglés.
     * 
     * @param \Pronit\EstructuraEmpresaBundle\Entity\MonedaFuerte $moneda
     */
    public function removeMonedasFuerte(MonedaFuerte $moneda)
    {
        $this->removeMonedaLegal($moneda);
    }
    
    
    public function addMonedaFuerte(MonedaFuerte $moneda)
    {        
        $moneda->setSociedad($this);
        $this->monedasFuertes->add($moneda);
    }

    public function removeMonedaFuerte(MonedaFuerte $moneda)
    {
        $this->monedasFuertes->removeElement($moneda);
    }
    
    public function __toString() 
    {
        return (string)$this->getNombre();
    }
}

