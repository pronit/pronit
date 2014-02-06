<?php

namespace Pronit\EstructuraEmpresaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * 
 *
 * @author ldelia
 * @ORM\Entity
 * @ORM\Table(name="eempre_varianteejerciciosociedad")
 */
class VarianteEjercicioSociedad
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Sociedad", inversedBy="variantesEjercicio")
     */
    private $sociedad;    
    
    /**
     * @ORM\Column(type="date")
     */
    private $fechaDesde;        

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fechaHasta;        

    /**
     * @ORM\Column(type="integer")
     */
    private $numeroEjercicio;            

    /**
     * @ORM\ManyToOne(targetEntity="Pronit\ParametrizacionGeneralBundle\Entity\VarianteEjercicio")
     */
    private $varianteEjercicio;    
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getSociedad()
    {
        return $this->sociedad;
    }

    public function setSociedad($sociedad)
    {
        $this->sociedad = $sociedad;
    }

    public function getFechaDesde()
    {
        return $this->fechaDesde;
    }

    public function setFechaDesde($fechaDesde)
    {
        $this->fechaDesde = $fechaDesde;
    }    

    public function getFechaHasta()
    {
        return $this->fechaHasta;
    }

    public function setFechaHasta($fechaHasta)
    {
        $this->fechaHasta = $fechaHasta;
    }

    public function getNumeroEjercicio()
    {
        return $this->numeroEjercicio;
    }

    public function setNumeroEjercicio($numeroEjercicio)
    {
        $this->numeroEjercicio = $numeroEjercicio;
    }    
    
    public function getVarianteEjercicio()
    {
        return $this->varianteEjercicio;
    }

    public function setVarianteEjercicio($varianteEjercicio)
    {
        $this->varianteEjercicio = $varianteEjercicio;
    }    
}

