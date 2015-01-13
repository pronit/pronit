<?php

namespace Pronit\CoreBundle\Entity\Impuestos;

use Doctrine\ORM\Mapping as ORM;
use Pronit\CoreBundle\Entity\Operaciones\OperacionContable;

/** 
 * @ORM\Entity
 * @ORM\Table(name="core_itemindicadorimpuestos")
 */
class ItemIndicadorImpuestos
{
   /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /** @ORM\ManyToOne(targetEntity="IndicadorImpuestos", inversedBy="items") */
    protected $indicadorImpuestos;
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Operaciones\OperacionContable")
     * @ORM\JoinColumn(nullable=false)
     */    
    protected $operacionContable;
    
    /**
     * @ORM\Column(type="float")
     */    
    protected $alicuota;
    
    public function __construct(IndicadorImpuestos $indicadorImpuestos, OperacionContable $operacionContable, $alicuota )
    {
        $this->setIndicadorImpuestos($indicadorImpuestos);
        $this->setOperacionContable($operacionContable);
        $this->setAlicuota($alicuota);
    }
    
    public function getId()
    {
        return $this->id;
    }

    /**
     * 
     * @return IndicadorImpuestos
     */
    function getIndicadorImpuestos()
    {
        return $this->indicadorImpuestos;
    }

    /**
     * 
     * @return OperacionContable
     */
    function getOperacionContable()
    {
        return $this->operacionContable;
    }

    function setIndicadorImpuestos(IndicadorImpuestos $indicadorImpuestos)
    {
        $this->indicadorImpuestos = $indicadorImpuestos;
    }

    function setOperacionContable(OperacionContable $operacionContable)
    {
        $this->operacionContable = $operacionContable;
    }    
    
    function getAlicuota()
    {
        return $this->alicuota;
    }

    function setAlicuota($alicuota)
    {
        $this->alicuota = $alicuota;
    }    
}
