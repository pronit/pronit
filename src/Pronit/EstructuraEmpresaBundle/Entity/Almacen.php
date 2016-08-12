<?php

namespace Pronit\EstructuraEmpresaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Pronit\EstructuraEmpresaBundle\Entity\CentroLogistico;
use Pronit\Geographic\CoreBundle\Entity\DivisionAdministrativa;

/**
 * @ORM\Entity
 * @ORM\Table(name="eempre_almacenes")
 */
class Almacen
{    
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    private $id;
    
    /**
     * @ORM\Column(type="string", length=10)
     */        
    protected $codigo;
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\EstructuraEmpresaBundle\Entity\CentroLogistico", inversedBy="almacenes")
     * @ORM\JoinColumn(nullable=false)
     */    
    protected $centroLogistico;    
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\Geographic\CoreBundle\Entity\DivisionAdministrativa")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $divisionAdministrativa;
       
    /**
     * @ORM\Column(type="string", length=100)
     */    
    private $nombre;

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
    
    /**
     * 
     * @return \Pronit\EstructuraEmpresaBundle\Entity\CentroLogistico
     */
    public function getCentroLogistico()
    {
        return $this->centroLogistico;
    }

    public function setCentroLogistico(CentroLogistico $centroLogistico)
    {
        $this->centroLogistico = $centroLogistico;
    }
       
    /**
     * 
     * @return \Pronit\Geographic\CoreBundle\Entity\DivisionAdministrativa
     */
    public function getDivisionAdministrativa()
    {
        return $this->divisionAdministrativa;
    }

    public function setDivisionAdministrativa(DivisionAdministrativa $divisionAdministrativa)
    {
        $this->divisionAdministrativa = $divisionAdministrativa;
    }    

    public function __toString() 
    {
        return (string)$this->getNombre();
    }
}


