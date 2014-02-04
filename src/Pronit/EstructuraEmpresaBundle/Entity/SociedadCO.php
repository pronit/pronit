<?php

namespace Pronit\EstructuraEmpresaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * 
 *
 * @author gcaseres
 * @ORM\Entity
 * @ORM\Table(name="eempre_sociedadesco")
 */
class SociedadCO extends Sociedad
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    private $id;
    
    public function getId()
    {
        return $this->id;
    }
    
}

