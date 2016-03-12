<?php

namespace Pronit\ComprasBundle\Model\Documentos\EntradasMercancias;

use Doctrine\ORM\EntityManager;
use Exception;
use Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\EntradaMercancias;
use Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\ItemEntradaMercancias;
use Pronit\CoreBundle\Entity\Documentos\ClaseDocumento;
use Pronit\CoreBundle\Entity\Documentos\Documento;
use Pronit\CoreBundle\Entity\Documentos\Item;
use Pronit\CoreBundle\Entity\Documentos\ItemFinanzas;
use Pronit\CoreBundle\Entity\Documentos\ItemFinanzasEntradaMercancias;
use Pronit\CoreBundle\Entity\Operaciones\Operacion;
use Pronit\CoreBundle\Model\Aspectos\IAspectoManager;
use Pronit\CoreBundle\Model\Contabilidad\Customizing\IImputacionesCustomizingManager as FIIImputacionesCustomizingManager;
use Pronit\CoreBundle\Model\Documentos\IGeneradorItemsFinanzas;
use Pronit\CoreBundle\Model\Operaciones\Contextos\Documentos\ContextoDocumentoEntradaMercancias;
use Pronit\CoreBundle\Model\Operaciones\Contextos\Documentos\ContextoItemDocumentoEntradaMercancias;
use Pronit\CustomizingBundle\Entity\Operaciones\MappingClaseDocumentoOperacion;
use Pronit\CustomizingBundle\Entity\Operaciones\MappingClasificadorItemOperacion;
use Pronit\CustomizingBundle\Model\Operaciones\IOperacionesCustomizingManager;
use Pronit\GestionBienesYServiciosBundle\Model\Customizing\Contabilidad\IImputacionesCustomizingManager as MMIImputacionesCustomizingManager;

/**
 * Description of GeneradorItemsFinanzas
 *
 * @author gcaseres
 */
class GeneradorItemsFinanzas implements IGeneradorItemsFinanzas {

    /**
     *
     * @var IAspectoManager
     */
    private $operacionesCustomizingManager;
    private $mmImputacionesCustomizingManager;
    private $fiImputacionesCustomizingManager;
    private $em;

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

        $this->generarDesdeEntradaMercancias($documento);
    }

    protected function generarDesdeItem(Item $item) {
        $this->generarDesdeItemEntradaMercancias($item);
    }

    protected function generarDesdeEntradaMercancias(EntradaMercancias $entradaMercancias) {
        $claseDocumento = $this->em->getRepository('Pronit\CoreBundle\Entity\Documentos\ClaseDocumento')->find(ClaseDocumento::CODIGO_ENTRADAMERCANCIAS);
        /* @var $claseDocumento ClaseDocumento */

        $mappings = $this->operacionesCustomizingManager->getMappingsByClaseDocumento($claseDocumento);

        foreach ($mappings as $mapping) {
            /* @var $mapping MappingClaseDocumentoOperacion */

            /* @var $operacion Operacion */
            $operacion = $mapping->getOperacion();
            $funcion = $mapping->getFuncion();
            $cuenta = $this->fiImputacionesCustomizingManager->getCuenta($operacion);

            $contexto = new ContextoDocumentoEntradaMercancias($operacion, $entradaMercancias);
            $importe = $funcion->ejecutar($contexto);

            if ($importe != 0) {
                $itemFinanzas = new ItemFinanzas($operacion, $cuenta);
                $itemFinanzas->setImporte($importe);

                $entradaMercancias->addItemFinanzas($itemFinanzas);
            }
        }
    }

    protected function generarDesdeItemEntradaMercancias(ItemEntradaMercancias $item) {
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
                $itemFinanzas = new ItemFinanzasEntradaMercancias($operacion, $cuenta, $item->getObjetoCosto(), $item);
                $itemFinanzas->setImporte($importe);
                $documento->addItemFinanzas($itemFinanzas);
            }
        }
    }

}
