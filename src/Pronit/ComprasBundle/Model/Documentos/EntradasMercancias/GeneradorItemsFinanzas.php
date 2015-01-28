<?php

namespace Pronit\ComprasBundle\Model\Documentos\EntradasMercancias;

use Doctrine\ORM\EntityManager;
use Exception;
use Pronit\CoreBundle\Entity\Documentos\Documento;
use Pronit\CoreBundle\Entity\Documentos\Item;
use Pronit\CoreBundle\Entity\Documentos\ItemFinanzas;
use Pronit\CoreBundle\Model\Contabilidad\Customizing\IImputacionesCustomizingManager as FIIImputacionesCustomizingManager;
use Pronit\CoreBundle\Model\Documentos\IGeneradorItemsFinanzas;
use Pronit\CoreBundle\Model\Operaciones\Contextos\Documentos\ContextoItemDocumentoEntradaMercancias;
use Pronit\CustomizingBundle\Entity\Operaciones\MappingClasificadorItemOperacion;
use Pronit\CustomizingBundle\Model\Operaciones\IOperacionesCustomizingManager;
use Pronit\GestionBienesYServiciosBundle\Model\Customizing\Contabilidad\IImputacionesCustomizingManager as MMIImputacionesCustomizingManager;

/**
 * Description of GeneradorItemsFinanzas
 *
 * @author gcaseres
 */
class GeneradorItemsFinanzas implements IGeneradorItemsFinanzas {

    protected $operacionesCustomizingManager;
    protected $mmImputacionesCustomizingManager;
    protected $fiImputacionesCustomizingManager;
    protected $em;

    public function __construct(EntityManager $em, IOperacionesCustomizingManager $operacionesCustomizingManager, MMIImputacionesCustomizingManager $mmImputacionesCustomizingManager, FIIImputacionesCustomizingManager $fiImputacionesCustomizingManager) {
        $this->em = $em;
        $this->operacionesCustomizingManager = $operacionesCustomizingManager;
        $this->mmImputacionesCustomizingManager = $mmImputacionesCustomizingManager;
        $this->fiImputacionesCustomizingManager = $fiImputacionesCustomizingManager;
    }

    public function generar(Documento $documento) {

        /*
         * Generar items de finanzas a partir de los items del documento 
         */
        foreach ($documento->getItems() as $item) {
            $this->generarDesdeItem($item);
        }


        /*
         * TODO: Generar items de finanzas a partir del documento
         */
    }

    protected function generarDesdeItem(Item $item) {
        $documento = $item->getDocumento();
        $clasificador = $item->getClasificador();
        $mappingsClasificadorItemOperacion = $this->operacionesCustomizingManager->getMappingsByClasificadorItem($clasificador);

        foreach ($mappingsClasificadorItemOperacion as /* @var $mappingClasificadorItemOperacion MappingClasificadorItemOperacion */ $mappingClasificadorItemOperacion) {
            $operacion = $mappingClasificadorItemOperacion->getOperacion();
            $funcion = $mappingClasificadorItemOperacion->getFuncion();
            $contexto = new ContextoItemDocumentoEntradaMercancias($item, $this->em);

            $cuenta = $this->mmImputacionesCustomizingManager->getCuenta($clasificador, $operacion, $item->getBienServicio()->getCategoriaValoracion());
            if ($cuenta == null) {
                $cuenta = $this->fiImputacionesCustomizingManager->getCuenta($operacion);
            }
            if ($cuenta == null) {
                throw new Exception("No se pudo determinar la cuenta contable a imputar.");
            }


            $importe = $funcion->ejecutar($contexto);

            if ($importe != 0) {
                $itemFinanzas = new ItemFinanzas($operacion, $cuenta);
                $itemFinanzas->setImporte($importe);
                $documento->addItemFinanzas($itemFinanzas);
            }
        }
    }

}
