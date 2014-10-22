<?php

namespace Pronit\ComprasBundle\Entity\Documentos\Estados\Facturacion;

use Doctrine\ORM\Mapping as ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="compras_estadofacturacion")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"SinFacturarValue" = "Pronit\ComprasBundle\Entity\Documentos\Estados\Facturacion\SinFacturar","FacturadoParcialmenteValue" = "Pronit\ComprasBundle\Entity\Documentos\Estados\Facturacion\FacturadoParcialmente","FinalizadoValue" = "Pronit\ComprasBundle\Entity\Documentos\Estados\Facturacion\Finalizado"})
 */
abstract class EstadoFacturacion
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
