<?php

namespace Pronit\EstructuraEmpresaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * 
 *
 * @author gcaseres
 * @ORM\Entity
 * @ORM\Table(name="eempre_sociedadesfi")
 */
class SociedadFI extends Sociedad
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="SociedadGL")
     */
    private $sociedadGL;    
    
    
    public function getId()
    {
        return $this->id;
    }

    public function getSociedadGL()
    {
        return $this->sociedadGL;
    }

    public function setSociedadGL($sociedadGL)
    {
        $this->sociedadGL = $sociedadGL;
    }    
}

