<?php

namespace Pronit\CustomizingBundle\Entity\Acreedores;

use Doctrine\ORM\Mapping as ORM;

use Pronit\EstructuraEmpresaBundle\Entity\SociedadFI;
use Pronit\CoreBundle\Entity\Personas\Acreedor;

/**
 * 
 *
 * @author ldelia
 * @ORM\Entity
 * @ORM\Table(name="custom_acreedoressociedadesfi")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"ProveedorSociedadFIValue" = "Pronit\ComprasBundle\Entity\Customizing\Acreedores\ProveedorSociedadFI"})
 */
abstract class AcreedorSociedadFI
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Personas\Acreedor")
     */    
    protected $acreedor;    
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\EstructuraEmpresaBundle\Entity\SociedadFI")
     */    
    protected $sociedadFI;    
    
    /**
     * @ORM\Column(type="string", length=10)
     */        
    protected $codigo;    

    /** @todo cuenta */
    
    public function getId()
    {
        return $this->id;
    }

    public function getAcreedor()
    {
        return $this->acreedor;
    }

    public function getSociedadFI()
    {
        return $this->sociedadFI;
    }

    public function getCodigo()
    {
        return $this->codigo;
    }

    public function setAcreedor(Acreedor $acreedor)
    {
        $this->acreedor = $acreedor;
    }

    public function setSociedadFI(SociedadFI $sociedadFI)
    {
        $this->sociedadFI = $sociedadFI;
    }

    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    public function __toString()
    {
        $sociedadFI = (!is_null($this->getSociedadFI())) ? ' (' . $this->getSociedadFI() . ')' : '';
        return $this->getAcreedor() . $sociedadFI;
    }
}