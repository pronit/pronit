<?php

namespace Pronit\EstructuraEmpresaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * 
 *
 * @author gcaseres
 * @ORM\Entity
 * @ORM\Table(name="eempre_sociedadesgl")
 */
class SociedadGL extends Sociedad
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="SociedadCO")
     */
    private $sociedadCO;    
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getSociedadCO()
    {
        return $this->sociedadCO;
    }

    public function setSociedadCO($sociedadCO)
    {
        $this->sociedadCO = $sociedadCO;
    }    
}

