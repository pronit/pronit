<?php

namespace Pronit\CoreBundle\Entity\Documentos\Ventas\Facturas;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


use Pronit\CoreBundle\Entity\Documentos\Ventas\Facturas\ClasificadorItemFactura;
use Pronit\CoreBundle\Entity\Documentos\ClasificadorItem;
use Pronit\CoreBundle\Entity\Impuestos\IndicadorImpuestos;
use Pronit\CoreBundle\Entity\Documentos\Ventas\ItemVentas;

use Pronit\CoreBundle\Entity\Documentos\Ventas\SalidasMercancias\ItemSalidaMercancias;

use Pronit\CoreBundle\Model\Operaciones\Contextos\Impuestos\ContextoCalculoImpuesto;

use \Exception;


/**
 *
 * @author ldelia
 * @ORM\Entity
*/
class ItemFactura extends ItemVentas
{
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Documentos\Ventas\SalidasMercancias\ItemSalidaMercancias")
     */    
    protected $itemSalidaMercanciasFacturado;
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Impuestos\IndicadorImpuestos")
     */    
    protected $indicadorImpuestos;


    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 
     * @return IndicadorImpuestos
     */
    function getIndicadorImpuestos()
    {
        return $this->indicadorImpuestos;
    }

    function setIndicadorImpuestos(IndicadorImpuestos $indicadorImpuestos)
    {
        $this->indicadorImpuestos = $indicadorImpuestos;
    }    
    
    public function setClasificador(ClasificadorItem $clasificador) 
    {
        if (!$clasificador instanceof ClasificadorItemFactura) {
            throw new Exception("Los items de factura solo admiten clasificadores de items de factura.");
        }
        parent::setClasificador($clasificador);
    }
    
    /**
     * 
     * @return ItemEntradaMercancias
     */
    function getItemSalidaMercanciasFacturado()
    {
        return $this->itemSalidaMercanciasFacturado;
    }

    function setItemSalidaMercanciasFacturado(ItemSalidaMercancias $item)
    {
        $this->itemSalidaMercanciasFacturado = $item;
        $item->addItemFacturador($this);
    }        
    
    public function getImporteTotal()
    {
        $importeTotal = $this->getImporteNeto();
        
        /* @var $itemIndicadorImpuesto \Pronit\CoreBundle\Entity\Impuestos\ItemIndicadorImpuestos */
        foreach( $this->getIndicadorImpuestos()->getItems() as $itemIndicadorImpuesto ){
            $funcion = $itemIndicadorImpuesto->getFuncion();
            
            $contexto = new ContextoCalculoImpuesto($this->getImporteNeto(), $itemIndicadorImpuesto->getAlicuota() );
            
            
            
            //if ($operacionContable->aceptaContexto($contexto)) {
                $monto = $funcion->ejecutar($contexto);
                
                $importeTotal = $importeTotal + $monto;
            //} else {
//                throw new Exception('La operación no puede ejecutarse en el contexto provisto.');
//            }
        }
        
        return $importeTotal;
    }

    public function contabilizar()
    {
        // todo: en un futuro va a existir tambien la relacion referenciaItemPedido ( proceso pedido - factura - salida mercancias )
        
        // en ese momento debemos registrar la facturación en uno u otro
        
        $this->getItemSalidaMercanciasFacturado()->registrarFacturacion($this);
        
        $this->getItemSalidaMercanciasFacturado()->getItemPedidoEntregado()->registrarFacturacion($this);
    }
    
    public function __toString()
    {
        return $this->getId();
    }    
    
}
