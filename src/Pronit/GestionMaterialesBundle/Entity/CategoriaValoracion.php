<?php

namespace Pronit\GestionMaterialesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * 
 *
 * @author ldelia
 */
/** 
 * @ORM\Entity
  * @ORM\Table(name="gmateriales_categoriavaloracion")
 */
class CategoriaValoracion
{    
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    protected $id;

    /**
     * @ORM\Column(type="string", length=5)
     */        
    protected $codigo;
    
    /**
     * @ORM\Column(type="string", length=30)
     */    
    protected $descripcion;
    
    public function __construct()
    {
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }
   
    public function getCodigo()
    {
        return $this->codigo;
    }

    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }    
}

