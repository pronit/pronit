<?php

namespace Pronit\CoreBundle\Entity\Personas;

use Doctrine\ORM\Mapping as ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="core_persona")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"PersonaFisicaValue" = "Pronit\CoreBundle\Entity\Personas\PersonaFisica", "PersonaJuridicaValue" = "Pronit\CoreBundle\Entity\Personas\PersonaJuridica"})
 */
abstract class Persona
{
   /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;    
    public function __construct()
    {
    }
    
    public function getId()
    {
        return $this->id;
    }
}
