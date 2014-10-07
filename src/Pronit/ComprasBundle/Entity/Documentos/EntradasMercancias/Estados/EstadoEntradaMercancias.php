<?php

namespace Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\Estados;

use Doctrine\ORM\Mapping as ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="compras_estadoentradamercancias")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"SinFacturarValue" = "Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\Estados\SinFacturar","FacturadoParcialmenteValue" = "Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\Estados\FacturadoParcialmente","FacturadoValue" = "Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\Estados\Facturado"})
 */
abstract class EstadoEntradaMercancias
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
