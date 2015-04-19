<?php

namespace Pronit\CoreBundle\Entity\Documentos\Ventas\Estados;

use Doctrine\ORM\Mapping as ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="ventas_estadoventas")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"InicialValue" = "Pronit\CoreBundle\Entity\Documentos\Ventas\Estados\Inicial","ContabilizadoValue" = "Pronit\CoreBundle\Entity\Documentos\Ventas\Estados\Contabilizado"})
 */
abstract class EstadoVentas
{
   /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;    

    /** 
     * @ORM\Column(type="datetime") 
     */
    protected $fecha;
    
    public function __construct()
    {
        $this->fecha = new \DateTime();
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function getFecha()
    {
        return $this->fecha;
    }    
}
