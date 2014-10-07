<?php

namespace Pronit\ComprasBundle\Entity\Documentos\Estados;

use Doctrine\ORM\Mapping as ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="compras_estadocompras")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"InicialValue" = "Pronit\ComprasBundle\Entity\Documentos\Estados\Inicial","ContabilizadoValue" = "Pronit\ComprasBundle\Entity\Documentos\Estados\Contabilizado"})
 */
abstract class EstadoCompras
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
