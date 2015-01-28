<?php

namespace Pronit\EstructuraEmpresaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @author gcaseres
 * @ORM\Entity
 */
class SociedadFI extends Sociedad
{
    
    /**
     * @ORM\ManyToOne(targetEntity="SociedadGL")
     */
    private $sociedadGL;        

    /**
     * @ORM\OneToMany(targetEntity="Pronit\EstructuraEmpresaBundle\Entity\CentroLogistico", mappedBy="sociedadFI", cascade={"ALL"})
     */
    private $centrosLogisticos;    
    
    public function __construct()
    {
        parent::__construct();
        
        $this->centrosLogisticos = new \Doctrine\Common\Collections\ArrayCollection();
    }    
    
    public function getSociedadGL()
    {
        return $this->sociedadGL;
    }

    public function setSociedadGL($sociedadGL)
    {
        $this->sociedadGL = $sociedadGL;
    }    
    
    public function getCentrosLogisticos()
    {
        return $this->centrosLogisticos;
    }
    
    public function setCentrosLogisticos( $centrosLogisticos)
    {
        $this->centrosLogisticos = $centrosLogisticos;
    }
    
    public function addCentroLogistico( CentroLogistico $centro )
    {
        $centro->setSociedadFI($this);
        $this->centrosLogisticos[] = $centro;
    }
}

