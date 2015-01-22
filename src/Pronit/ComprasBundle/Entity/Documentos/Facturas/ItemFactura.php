<?php

namespace Pronit\ComprasBundle\Entity\Documentos\Facturas;

use Doctrine\ORM\Mapping as ORM;

use Pronit\CoreBundle\Entity\Documentos\ClasificadorItem;
use Pronit\ComprasBundle\Entity\Documentos\ItemAbastecimientoExterno;
use Pronit\ComprasBundle\Entity\Documentos\Pedidos\ItemPedido;
use Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\ItemEntradaMercancias;
use Pronit\CoreBundle\Entity\Impuestos\IndicadorImpuestos;

use Pronit\CoreBundle\Model\Operaciones\Contextos\Impuestos\ContextoCalculoImpuesto;

use \Exception;

/**
 *
 * @author gcaseres
 * @ORM\Entity
 */
class ItemFactura extends ItemAbastecimientoExterno {

    /**
     * @ORM\ManyToOne(targetEntity="Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\ItemEntradaMercancias")
     */    
    protected $itemEntradaMercanciasFacturado;
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Impuestos\IndicadorImpuestos")
     */    
    protected $indicadorImpuestos;
    
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
            throw new Exception("Los items de facturas solo admiten clasificadores de items de facturas.");
        }
        parent::setClasificador($clasificador);
    }
    
    /**
     * 
     * @return ItemEntradaMercancias
     */
    function getItemEntradaMercanciasFacturado()
    {
        return $this->itemEntradaMercanciasFacturado;
    }

    function setItemEntradaMercanciasFacturado(ItemEntradaMercancias $item)
    {
        $this->itemEntradaMercanciasFacturado = $item;
        $item->addItemFacturador($this);
    }        
    
    
    public function contabilizar()
    {
        // todo: en un futuro va a existir tambien la relacion referenciaItemPedido ( proceso pedido - factura - entrada mercancias
        
        // en ese momento debemos registrar la facturación en uno u otro
        
        $this->getItemEntradaMercanciasFacturado()->registrarFacturacion($this);
        
        $this->getItemEntradaMercanciasFacturado()->getItemPedidoEntregado()->registrarFacturacion($this);
    }
    
    public function getImporteTotal()
    {
        $importeTotal = $this->getImporteNeto();
        
        /* @var $itemIndicadorImpuesto \Pronit\CoreBundle\Entity\Impuestos\ItemIndicadorImpuestos */
        foreach( $this->getIndicadorImpuestos()->getItems() as $itemIndicadorImpuesto ){
            $operacionContable = $itemIndicadorImpuesto->getOperacionContable();
            
            $contexto = new ContextoCalculoImpuesto($operacionContable, $this->getImporteNeto(), $itemIndicadorImpuesto->getAlicuota() );
            
            
            
            if ($operacionContable->aceptaContexto($contexto)) {
                $monto = $operacionContable->ejecutar($contexto);
                
                $importeTotal = $importeTotal + $monto;
            } else {
                throw new Exception('La operación no puede ejecutarse en el contexto provisto.');
            }
        }
        
        return $importeTotal;
    }
    
    public function __toString() 
    {
        return $this->getId();
    }

}
