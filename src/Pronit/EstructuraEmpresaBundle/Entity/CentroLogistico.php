<?php

namespace Pronit\EstructuraEmpresaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Pronit\EstructuraEmpresaBundle\Entity\SociedadFI;
use Pronit\Geographic\CoreBundle\Entity\DivisionAdministrativa;

/**
 * @ORM\Entity
 * @ORM\Table(name="eempre_centros")
 */
class CentroLogistico
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
     * @ORM\ManyToOne(targetEntity="Pronit\EstructuraEmpresaBundle\Entity\SociedadFI", inversedBy="centrosLogisticos")
     * @ORM\JoinColumn(nullable=false)
     */    
    protected $sociedadFI;    
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\Geographic\CoreBundle\Entity\DivisionAdministrativa")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $divisionAdministrativa;
       
    /**
     * @ORM\Column(type="string", length=100)
     */    
    private $nombre;
    
    /**
     * @ORM\OneToMany(targetEntity="Pronit\EstructuraEmpresaBundle\Entity\Almacen", mappedBy="centroLogistico", cascade={"ALL"})
     */
    private $almacenes;        
    
    public function __construct()
    {
        $this->almacenes = new \Doctrine\Common\Collections\ArrayCollection();        
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
     * @return \Pronit\EstructuraEmpresaBundle\Entity\SociedadFI
     */
    public function getSociedadFI()
    {
        return $this->sociedadFI;
    }

    public function setSociedadFI( SociedadFI $sociedadFI)
    {
        $this->sociedadFI = $sociedadFI;
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
    
    public function getAlmacenes()
    {
        return $this->almacenes;
    }

    public function addAlmacen( Almacen $almacen )
    {
        $almacen->setCentroLogistico($this);
        $this->almacenes[] = $almacen;
    }

    public function __toString() 
    {
        return (string) $this->getCodigo() . ' - ' . $this->getNombre();
    }
}

