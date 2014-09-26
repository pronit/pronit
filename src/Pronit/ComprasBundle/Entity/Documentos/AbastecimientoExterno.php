<?php

namespace Pronit\ComprasBundle\Entity\Documentos;

use Doctrine\ORM\Mapping as ORM;

use Pronit\EstructuraEmpresaBundle\Entity\CentroLogistico;
use Pronit\ParametrizacionGeneralBundle\Entity\Moneda;
use Pronit\ComprasBundle\Entity\Customizing\Acreedores\ProveedorSociedadFI;

abstract class AbastecimientoExterno extends Compras
{
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\ParametrizacionGeneralBundle\Entity\Moneda")
     */
    protected $moneda;

    /**
     * @ORM\ManyToOne(targetEntity="Pronit\EstructuraEmpresaBundle\Entity\CentroLogistico")
     */
    protected $centroLogistico;
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\ComprasBundle\Entity\Customizing\Acreedores\ProveedorSociedadFI")
     */
    protected $proveedorSociedad;
    
    public function getMoneda()
    {
        return $this->moneda;
    }

    public function setMoneda(Moneda $moneda)
    {
        $this->moneda = $moneda;
    } 

    public function getProveedorSociedad()
    {
        return $this->proveedorSociedad;
    }

    public function setProveedorSociedad(ProveedorSociedadFI $proveedorSociedad)
    {
        $this->proveedorSociedad = $proveedorSociedad;
    }    
    
    public function getCentroLogistico()
    {
        return $this->centroLogistico;
    }

    public function setCentroLogistico(CentroLogistico $centroLogistico)
    {
        $this->centroLogistico = $centroLogistico;
    }    
}