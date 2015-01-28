<?php

namespace Pronit\CustomizingBundle\Entity\Operaciones;

use Doctrine\ORM\Mapping as ORM;
use Pronit\AutomatizacionBundle\Entity\Funcion;
use Pronit\CoreBundle\Entity\Documentos\ClasificadorItem;
use Pronit\CoreBundle\Entity\Operaciones\OperacionContable;

/**
 * 
 *
 * @author ldelia
 * @ORM\Entity
 * @ORM\Table(name="custom_mappingclasificadoritemoperacion")
 */
class MappingClasificadorItemOperacion
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
     * @var ClasificadorItem
     */    
    protected $clasificador;    
    
    /**     
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Operaciones\OperacionContable")
     * @ORM\JoinColumn(nullable=false)
     * @var OperacionContable
     */    
    protected $operacion;    
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\AutomatizacionBundle\Entity\Funcion")
     * @ORM\JoinColumn(nullable=false)
     * @var Funcion
     */
    protected $funcion;
    
    public function __construct()
    {
    }
    
    public function getId()
    {
        return $this->id;
    }



    /**
     * 
     * @param \Pronit\CoreBundle\Entity\Documentos\ClasificadorItem $clasificador
     */
    public function setClasificador(ClasificadorItem $clasificador)
    {
        $this->clasificador = $clasificador;
    }
    
    /**
     * 
     * @return ClasificadorItem
     */
    public function getClasificador()
    {
        return $this->clasificador;
    }
    

    /**
     * 
     * @param \Pronit\CoreBundle\Entity\Operaciones\OperacionContable $operacion
     */
    public function setOperacion(OperacionContable $operacion)
    {
        $this->operacion = $operacion;
    }    

    /**
     * 
     * @return OperacionContable
     */
    public function getOperacion()
    {
        return $this->operacion;
    }
    
    /**
     * 
     * @param \Pronit\AutomatizacionBundle\Entity\Funcion $value
     */
    public function setFuncion(Funcion $value) {
        $this->funcion = $value;
    }
    
    /**
     * 
     * @return Funcion
     */
    public function getFuncion() {
        return $this->funcion;
    }
}

