<?php

namespace Pronit\GestionMaterialesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Pronit\ParametrizacionGeneralBundle\Entity\SistemaMedicion;

/**
 * 
 *
 * @author ldelia
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
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\GestionMaterialesBundle\Entity\CategoriaValoracion")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $categoriaValoracion;    
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\ParametrizacionGeneralBundle\Entity\SistemaMedicion")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $sistemaMedicion;    
    
    public function __construct()
    {
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

    public function getCategoriaValoracion()
    {
        return $this->categoriaValoracion;
    }

    public function setCategoriaValoracion(CategoriaValoracion $categoriaValoracion)
    {
        $this->categoriaValoracion = $categoriaValoracion;
    }
    
    public function getSistemaMedicion()
    {
        return $this->sistemaMedicion;
    }

    public function setSistemaMedicion(SistemaMedicion $sistemaMedicion)
    {
        $this->sistemaMedicion = $sistemaMedicion;
    }    
}

