<?php

namespace Pronit\ComprasBundle\Entity\Documentos\Pedidos\Estados;

use Doctrine\ORM\Mapping as ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="compras_estadopedido")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"SinEntregarValue" = "Pronit\ComprasBundle\Entity\Documentos\Pedidos\Estados\SinEntregar","EntregadoParcialmenteValue" = "Pronit\ComprasBundle\Entity\Documentos\Pedidos\Estados\EntregadoParcialmente","FinalizadoValue" = "Pronit\ComprasBundle\Entity\Documentos\Pedidos\Estados\Finalizado"})
 */
abstract class EstadoPedido
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
