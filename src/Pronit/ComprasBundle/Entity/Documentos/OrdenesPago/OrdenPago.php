<?php

namespace Pronit\ComprasBundle\Entity\Documentos\OrdenesPago;

use Doctrine\ORM\Mapping as ORM;
use Exception;

use Pronit\CoreBundle\Entity\Documentos\Documento;
use Pronit\CoreBundle\Entity\Documentos\Item;
use Pronit\ComprasBundle\Entity\Customizing\Acreedores\ProveedorSociedadFI;
use Pronit\ParametrizacionGeneralBundle\Entity\Moneda;

use Pronit\ComprasBundle\Entity\Documentos\Estados\EstadoCompras;
use Pronit\ComprasBundle\Entity\Documentos\Estados\Inicial;
use Pronit\ComprasBundle\Entity\Documentos\Estados\Contabilizado;

/**
 *
 * @author ldelia
 * @ORM\Entity
 */
class OrdenPago extends Documento
{
    /**
     * @ORM\OneToOne(targetEntity="Pronit\ComprasBundle\Entity\Documentos\Estados\EstadoCompras", cascade={"persist", "remove"}, orphanRemoval=true)
     **/    
    protected $estadoCompras;        
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\ParametrizacionGeneralBundle\Entity\Moneda")
     */
    protected $moneda;
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\ComprasBundle\Entity\Customizing\Acreedores\ProveedorSociedadFI")
     */
    protected $proveedorSociedad;
    
    
    //$itemsGestionMovimiento
    
    public function __construct()
    {
        parent::__construct();
        $this->setEstadoCompras( new Inicial() );     
    }    

    
    public function addItem(Item $item) 
    {
        if (!$item instanceof ItemOrdenPago ) {
            throw new Exception;
        }
        parent::addItem($item);
    }
    
    public function getMoneda()
    {
        return $this->moneda;
    }

    public function setMoneda(Moneda $moneda)
    {
        $this->moneda = $moneda;
    } 
    
    /**
     * 
     * @return ProveedorSociedadFI
     */
    public function getProveedorSociedad()
    {
        return $this->proveedorSociedad;
    }

    public function setProveedorSociedad(ProveedorSociedadFI $proveedorSociedad)
    {
        $this->proveedorSociedad = $proveedorSociedad;
    }        
    
    public function getEstadoCompras()
    {
        return $this->estadoCompras;
    }

    protected function setEstadoCompras(EstadoCompras $estadoCompras)
    {
        $this->estadoCompras = $estadoCompras;
    }    
    
    public function contabilizar()
    {
        parent::contabilizar();
        
        $this->estadoCompras = new Contabilizado();
        
//        /* Cuando la factura se contabiliza se "contabilizan" su items */
//        
//        /* @var $itemFactura \Pronit\ComprasBundle\Entity\Documentos\Facturas\ItemFactura  */
//        foreach( $this->getItems() as $itemFactura ){
//            
//            $itemFactura->contabilizar();
//        }        
        
    }
    
    public function isModificable()
    {
        return $this->getEstadoCompras() instanceof Inicial;
    }        
}
