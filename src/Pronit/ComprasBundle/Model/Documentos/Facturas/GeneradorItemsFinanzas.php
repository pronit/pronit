<?php

namespace Pronit\ComprasBundle\Model\Documentos\Facturas;

use Doctrine\ORM\EntityManager;
use Pronit\ComprasBundle\Entity\Documentos\Facturas\Factura;
use Pronit\ComprasBundle\Entity\Documentos\Facturas\ItemFactura;
use Pronit\CoreBundle\Entity\Documentos\ClaseDocumento;
use Pronit\CoreBundle\Entity\Documentos\Documento;
use Pronit\CoreBundle\Entity\Documentos\ItemFinanzas;
use Pronit\CoreBundle\Entity\Documentos\ItemFinanzasPago;
use Pronit\CoreBundle\Model\Contabilidad\Customizing\IImputacionesCustomizingManager as FIIImputacionesCustomizingManager;
use Pronit\CoreBundle\Model\Documentos\IGeneradorItemsFinanzas;
use Pronit\CoreBundle\Model\Operaciones\Contextos\Documentos\Facturas\ContextoItemDocumentoFactura;
use Pronit\CoreBundle\Model\Operaciones\Contextos\Impuestos\ContextoCalculoImpuesto;
use Pronit\CustomizingBundle\Entity\Operaciones\MappingClaseDocumentoOperacion;
use Pronit\CustomizingBundle\Entity\Operaciones\MappingClasificadorItemOperacion;
use Pronit\CustomizingBundle\Model\Operaciones\IOperacionesCustomizingManager;
use Pronit\ParametrizacionGeneralBundle\Entity\ItemCondicionPagos;

/**
 * Description of GeneradorItemsFinanzas
 *
 * @author gcaseres
 */
class GeneradorItemsFinanzas implements IGeneradorItemsFinanzas {

    protected $operacionesCustomizingManager;
    protected $fiImputacionesCustomizingManager;
    protected $em;

    public function __construct(EntityManager $em, IOperacionesCustomizingManager $operacionesCustomizingManager, FIIImputacionesCustomizingManager $fiImputacionesCustomizingManager) {
        $this->em = $em;
        $this->operacionesCustomizingManager = $operacionesCustomizingManager;
        $this->fiImputacionesCustomizingManager = $fiImputacionesCustomizingManager;
    }

    public function generar(Documento $documento) {

        /*
         * Generar items de finanzas a partir de los items del documento.
         */
        foreach ($documento->getItems() as $item) {
            $this->generarDesdeItem($item);
        }
        
        $this->generarParaCondicionPagos($documento);
    }

    /**
     * Genera los items de finanzas a partir de la condición de pagos.
     * 
     * 
     * @param Factura $documento
     */
    protected function generarParaCondicionPagos(Factura $documento) {
        /*
         * Se obtiene la operación designada para la imputación a la cuenta de
         * acreedor. Se generaran tantos items finanzas como pagos tenga la
         * condición.
         * Se asume que hay solo un mapping definido para procesar condición
         * de pagos pues no tiene sentido que  exista mas de uno.
         */


        $claseDocumento = $this->em->getRepository('Pronit\CoreBundle\Entity\Documentos\ClaseDocumento')->find(ClaseDocumento::CODIGO_FACTURAACREEDOR);
        /* @var $mappingCondicionPagos MappingClaseDocumentoOperacion */
        $mappingCondicionPagos = $this->operacionesCustomizingManager->getMappingsCondicionPagosByClaseDocumento($claseDocumento);

        $operacion = $mappingCondicionPagos->getOperacion();
        $cuenta = $documento->getProveedorSociedad()->getAcreedor()->getCuenta();

        $importeTotal = $documento->getImporteTotal();

        $numeroPago = 1;
        foreach ($documento->getCondicionPagos()->getItems() as /* @var $itemCondicionPagos ItemCondicionPagos */ $itemCondicionPagos) {            
            $importe = $importeTotal * $itemCondicionPagos->getPorcentaje() / 100;

            $itemFinanzas = new ItemFinanzasPago($numeroPago, $operacion, $cuenta);
            $itemFinanzas->setImporte($importe);
            $documento->addItemFinanzas($itemFinanzas);
            
            $numeroPago++;
        }
    }

    protected function generarDesdeItem(ItemFactura $item) {
        $documento = $item->getDocumento();

        /**
         * Obtener operaciones según el mapping:
         * ClasificadorItemFactura -> (Operacion, Funcion)
         */
        $clasificador = $item->getClasificador();
        $mappingsClasificadorItemOperacion = $this->operacionesCustomizingManager->getMappingsByClasificadorItem($clasificador);

        foreach ($mappingsClasificadorItemOperacion as /* @var $mappingClasificadorItemOperacion MappingClasificadorItemOperacion */ $mappingClasificadorItemOperacion) {
            $operacion = $mappingClasificadorItemOperacion->getOperacion();
            $funcion = $mappingClasificadorItemOperacion->getFuncion();
            $contexto = new ContextoItemDocumentoFactura($item, $this->em);
            $cuenta = $this->fiImputacionesCustomizingManager->getCuenta($operacion);

            $importe = $funcion->ejecutar($contexto);

            if ($importe != 0) {
                $itemFinanzas = new ItemFinanzas($operacion, $cuenta);
                $itemFinanzas->setImporte($importe);
                $documento->addItemFinanzas($itemFinanzas);
            }
        }
        
        $this->generarDesdeItemParaIndicadorImpuestos($item);
    }

    protected function generarDesdeItemParaIndicadorImpuestos(ItemFactura $item) {
        $documento = $item->getDocumento();
        /**
         * Obtener operaciones según el customizing de Indicador de Impuestos
         * TODO: Debería seguirse el concepto de mapping y obtenerlos desde un
         * servicio.
         */
        foreach ($item->getIndicadorImpuestos()->getItems() as $itemIndicadorImpuestos) {
            $operacion = $itemIndicadorImpuestos->getOperacionContable();
            $funcion = $itemIndicadorImpuestos->getFuncion();
            $contexto = new ContextoCalculoImpuesto($item->getImporteNeto(), $itemIndicadorImpuestos->getAlicuota());
            $cuenta = $this->fiImputacionesCustomizingManager->getCuenta($operacion);

            $importe = $funcion->ejecutar($contexto);

            if ($importe != 0) {
                $itemFinanzas = new ItemFinanzas($operacion, $cuenta);
                $itemFinanzas->setImporte($importe);
                $documento->addItemFinanzas($itemFinanzas);
            }
        }
    }

}
