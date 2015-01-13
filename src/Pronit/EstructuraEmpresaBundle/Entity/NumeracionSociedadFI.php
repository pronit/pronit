<?php

namespace Pronit\EstructuraEmpresaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="eempre_numeracionsociedadfi")
 */
class NumeracionSociedadFI
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    private $id;
    
    /**
     * @ORM\OneToOne(targetEntity="SociedadFI", inversedBy="numeracion")
     */
    private $sociedadFI;        

    /**
     * @ORM\Column(type="integer") 
     */
    private $asiento;
    
    public function __construct( SociedadFI $sociedad, $asiento )
    {
        $this->sociedadFI = $sociedad;
        $this->asiento = $asiento;
    }    
    
    function getSociedadFI()
    {
        return $this->sociedadFI;
    }

    function getAsiento()
    {
        return $this->asiento;
    }
    
    function setAsiento($asiento)
    {
        $this->asiento = $asiento;
    }    
}

