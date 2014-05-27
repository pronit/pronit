<?php

namespace Pronit\CustomizingBundle\Entity\Operaciones;

use Doctrine\ORM\Mapping as ORM;

/**
 * 
 *
 * @author ldelia
 * @ORM\Entity
 * @ORM\Table(name="custom_asociacionoperacionclasificadoritem")
 */
class AsociacionOperacionClasificadorItem
{  
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Documentos\ClasificadorItem")
     * @ORM\JoinColumn(nullable=false)
     */    
    protected $clasificador;    
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Operaciones\Operacion")
     * @ORM\JoinColumn(nullable=false)
     */    
    protected $operacion;    
    
    public function __construct()
    {
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function getClasificador()
    {
        return $this->clasificador;
    }

    public function getOperacion()
    {
        return $this->operacion;
    }

    public function setClasificador($clasificador)
    {
        $this->clasificador = $clasificador;
    }

    public function setOperacion($operacion)
    {
        $this->operacion = $operacion;
    }    
}

