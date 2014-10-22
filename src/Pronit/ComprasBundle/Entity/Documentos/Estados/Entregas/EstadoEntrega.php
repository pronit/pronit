<?php

namespace Pronit\ComprasBundle\Entity\Documentos\Estados\Entregas;

use Doctrine\ORM\Mapping as ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="compras_estadoentrega")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"SinEntregarValue" = "Pronit\ComprasBundle\Entity\Documentos\Estados\Entregas\SinEntregar","EntregadoParcialmenteValue" = "Pronit\ComprasBundle\Entity\Documentos\Estados\Entregas\EntregadoParcialmente","FinalizadoValue" = "Pronit\ComprasBundle\Entity\Documentos\Estados\Entregas\Finalizado"})
 */
abstract class EstadoEntrega
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
