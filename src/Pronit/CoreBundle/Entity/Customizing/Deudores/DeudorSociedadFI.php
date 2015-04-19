<?php

namespace Pronit\CoreBundle\Entity\Customizing\Deudores;


use Doctrine\ORM\Mapping as ORM;

use Pronit\CoreBundle\Entity\Personas\Deudor;
use Pronit\EstructuraEmpresaBundle\Entity\SociedadFI;

/**
 *
 * @author ldelia
 * @ORM\Entity
 */
class DeudorSociedadFI
{    
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Personas\Deudor")
     */    
    protected $deudor;
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\EstructuraEmpresaBundle\Entity\SociedadFI")
     */    
    protected $sociedadFI;    
    
    /**
     * @ORM\Column(type="string", length=10)
     */        
    protected $codigo;    
        
    public function getId()
    {
        return $this->id;
    }

    /**
     * 
     * @return Deudor
     */
    public function getDeudor()
    {
        return $this->deudor;
    }

    public function getSociedadFI()
    {
        return $this->sociedadFI;
    }

    public function getCodigo()
    {
        return $this->codigo;
    }

    public function setDeudor(Deudor $deudor)
    {
        $this->deudor = $deudor;
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
        return $this->getDeudor() . $sociedadFI;
    }    
}
