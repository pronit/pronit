<?php

namespace Pronit\ParametrizacionGeneralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * 
 *
 * @author gcaseres
 * @ORM\Entity
 * @ORM\Table(name="pgener_periodovarianteejercicio")
 */
class PeriodoVarianteEjercicio
{
    
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="VarianteEjercicio", inversedBy="periodos")
     */
    private $varianteEjercicio;    
    
    /**
     * @ORM\Column(type="string", length=15)
     */    
    private $nombre;
    
    /**
     * @ORM\Column(type="string", length=3)
     */    
    private $abreviatura;
    
    /**
     * @ORM\Column(type="integer")
     */    
    private $mes;
    
    /**
     * @ORM\Column(type="integer")
     */    
    private $periodo;

    /**
     * @ORM\Column(type="integer")
     */    
    private $diaComienzo;
    
    /**
     * @ORM\Column(type="integer")
     */    
    private $mesComienzo;    

    /**
     * @ORM\Column(type="integer")
     */    
    private $diaFin;
    
    /**
     * @ORM\Column(type="integer")
     */    
    private $mesFin;        
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getVarianteEjercicio()
    {
        return $this->varianteEjercicio;
    }

    public function setVarianteEjercicio($varianteEjercicio)
    {
        $this->varianteEjercicio = $varianteEjercicio;
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

    public function getMes()
    {
        return $this->mes;
    }

    public function setMes($mes)
    {
        $this->mes = $mes;
    }

    public function getPeriodo()
    {
        return $this->periodo;
    }

    public function setPeriodo($periodo)
    {
        $this->periodo = $periodo;
    }

    public function getDiaComienzo()
    {
        return $this->diaComienzo;
    }

    public function setDiaComienzo($diaComienzo)
    {
        $this->diaComienzo = $diaComienzo;
    }

    public function getMesComienzo()
    {
        return $this->mesComienzo;
    }

    public function setMesComienzo($mesComienzo)
    {
        $this->mesComienzo = $mesComienzo;
    }

    public function getDiaFin()
    {
        return $this->diaFin;
    }

    public function setDiaFin($diaFin)
    {
        $this->diaFin = $diaFin;
    }

    public function getMesFin()
    {
        return $this->mesFin;
    }

    public function setMesFin($mesFin)
    {
        $this->mesFin = $mesFin;
    }
    
    public function __toString() 
    {
        return (string)$this->getNombre();
    }
    
}

