<?php

namespace Pronit\CoreBundle\Entity\Personas;

use Doctrine\ORM\Mapping as ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="core_rolpersona")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"ProveedorValue" = "Pronit\CoreBundle\Entity\Personas\Proveedor"})
 */
abstract class RolPersona
{
   /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;    
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Personas\Persona")
     * @ORM\JoinColumn(nullable=false)
     */    
    protected $persona;
    
    
    public function __construct()
    {
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getPersona()
    {
        return $this->persona;
    }

    public function setPersona(Persona $persona)
    {
        $this->persona = $persona;
    }    
}
