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
  * @ORM\Table(name="gmateriales_material")
 */
class Material
{    
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    protected $id;

    /**
     * @ORM\Column(type="string", length=10)
     */        
    protected $codigo;
    
    /**
     * @ORM\Column(type="string", length=50)
     */    
    protected $nombre;
    
    public function __construct($codigo, $nombre)
    {
        $this->setCodigo($codigo);
        $this->setNombre($nombre);
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setNombre($valor)
    {
        $this->nombre = $valor;
    }
    
    public function getNombre()
    {
        return $this->nombre;
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

