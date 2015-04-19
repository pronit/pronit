<?php

namespace Pronit\CoreBundle\Entity\Documentos\Ventas;

use Doctrine\ORM\Mapping as ORM;

use Pronit\EstructuraEmpresaBundle\Entity\CentroLogistico;
use Pronit\ParametrizacionGeneralBundle\Entity\Moneda;
use Pronit\CoreBundle\Entity\Customizing\Deudores\DeudorSociedadFI;

use Pronit\CoreBundle\Entity\Documentos\Documento;
use Pronit\CoreBundle\Entity\Documentos\Ventas\Estados\EstadoVentas;
use Pronit\CoreBundle\Entity\Documentos\Ventas\Estados\Inicial;
use Pronit\CoreBundle\Entity\Documentos\Ventas\Estados\Contabilizado;


abstract class Ventas extends Documento
{
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Customizing\Deudores\DeudorSociedadFI")
     */
    protected $deudorSociedad;
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\ParametrizacionGeneralBundle\Entity\Moneda")
     */
    protected $moneda;

    /**
     * @ORM\ManyToOne(targetEntity="Pronit\EstructuraEmpresaBundle\Entity\CentroLogistico")
     */
    protected $centroLogistico;
    
    /**
     * @ORM\OneToOne(targetEntity="Pronit\CoreBundle\Entity\Documentos\Ventas\Estados\EstadoVentas", cascade={"persist", "remove"}, orphanRemoval=true)
     **/    
    protected $estadoVentas; 
    
    public function __construct()
    {
        parent::__construct();
        $this->setEstadoVentas( new Inicial() );     
    }    
    
    public function getEstadoVentas()
    {
        return $this->estadoVentas;
    }

    protected function setEstadoVentas(EstadoVentas $estadoVentas)
    {
        $this->estadoVentas = $estadoVentas;
    }    
    
    public function contabilizar()
    {
        parent::contabilizar();
        
        $this->estadoVentas = new Contabilizado();
    }
    
    public function isModificable()
    {
        return $this->getEstadoVentas() instanceof Inicial;
    }        
    
    function getDeudorSociedad()
    {
        return $this->deudorSociedad;
    }

    function getMoneda()
    {
        return $this->moneda;
    }

    function getCentroLogistico()
    {
        return $this->centroLogistico;
    }

    function setDeudorSociedad(DeudorSociedadFI $deudorSociedad)
    {
        $this->deudorSociedad = $deudorSociedad;
    }

    function setMoneda(Moneda $moneda)
    {
        $this->moneda = $moneda;
    }

    function setCentroLogistico(CentroLogistico $centroLogistico)
    {
        $this->centroLogistico = $centroLogistico;
    }

    public function getImporteNeto()
    {
        $importeNeto = 0;
        
        /* @var $item \Pronit\CoreBundle\Entity\Documentos\Ventas\ItemVentas */
        foreach ( $this->getItems() as $item ){
            
            $importeNeto = $importeNeto + $item->getImporteNeto();
        }
        
        return $importeNeto;
    }        
}

