<?php

namespace Pronit\GestionBienesYServiciosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Pronit\ParametrizacionGeneralBundle\Entity\SistemaMedicion;

use Pronit\GestionBienesYServiciosBundle\Entity\TipoBienServicio;

/**
 * 
 *
 * @author ldelia
 * @ORM\Entity
 * @ORM\Table(name="gestionbienesyservicios_bienesservicios")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"MaterialValue" = "Pronit\GestionBienesYServiciosBundle\Entity\Material","ServicioValue" = "Pronit\GestionBienesYServiciosBundle\Entity\Servicio"})
 */
abstract class BienServicio
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
     * @ORM\ManyToOne(targetEntity="Pronit\GestionBienesYServiciosBundle\Entity\CategoriaValoracion")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $categoriaValoracion;    
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\ParametrizacionGeneralBundle\Entity\SistemaMedicion")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $sistemaMedicion;    
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\GestionBienesYServiciosBundle\Entity\TipoBienServicio")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $tipo;    
    
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

    public function getTipo()
    {
        return $this->tipo;
    }

    public function setTipo( TipoBienServicio $tipo)
    {
        $this->tipo = $tipo;
    }    
    
    public function __toString()
    {
        return $this->getCodigo() . " - " . $this->getNombre();            
    }   
}