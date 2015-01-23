<?php

namespace Pronit\ComprasBundle\Model\Documentos\Facturas;

use Doctrine\ORM\EntityManager;
use Exception;
use Pronit\CoreBundle\Entity\Documentos\ClaseDocumento;
use Pronit\CoreBundle\Entity\Documentos\Documento;
use Pronit\CoreBundle\Entity\Documentos\Item;
use Pronit\CoreBundle\Entity\Documentos\ItemFinanzas;
use Pronit\CoreBundle\Entity\Operaciones\Operacion;
use Pronit\CoreBundle\Model\Contabilidad\Customizing\IImputacionesCustomizingManager as FIIImputacionesCustomizingManager;
use Pronit\CoreBundle\Model\Documentos\IGeneradorItemsFinanzas;
use Pronit\CoreBundle\Model\Operaciones\Contextos\Documentos\Facturas\ContextoDocumentoFactura;
use Pronit\CoreBundle\Model\Operaciones\Contextos\Documentos\Facturas\ContextoItemDocumentoFactura;
use Pronit\CustomizingBundle\Model\Operaciones\IOperacionesCustomizingManager;

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
         * Generar items de finanzas a partir de los items del documento 
         */
        foreach ($documento->getItems() as $item) {
            $this->generarDesdeItem($item);
        }

        /*
         * Generar items de finanzas a partir del documento
         * 
         * TODO: Utilizar servicios para obtener las operaciones de nivel documento
         */
        $asociaciones = $this->em->getRepository("Pronit\CustomizingBundle\Entity\Operaciones\AsociacionOperacionClaseDocumento")->findByClaseDocumento(ClaseDocumento::CODIGO_FACTURAACREEDOR);
        foreach ($asociaciones as $asociacion) {
            $operacion = $asociacion->getOperacion();
            $contexto = new ContextoDocumentoFactura($operacion, $documento, $this->fiImputacionesCustomizingManager, $this->em);

            if ($operacion->aceptaContexto($contexto)) {
                $itemFinanzasDTOs = $operacion->ejecutar($contexto);
                $this->generarItemsFinanzasDesdeDTOs($operacion, $documento, $itemFinanzasDTOs);
            } else {
                throw new Exception('La operación no puede ejecutarse en el contexto provisto.');
            }
        }
    }

    protected function generarDesdeItem(Item $item) {

        $clasificador = $item->getClasificador();
        $operacionesContables = $this->operacionesCustomizingManager->getOperacionesContablesByClasificadorItem($clasificador);

        foreach ($operacionesContables as $operacion) {
            $contexto = new ContextoItemDocumentoFactura($operacion, $item, $this->fiImputacionesCustomizingManager, $this->em);

            if ($operacion->aceptaContexto($contexto)) {
                $itemFinanzasDTOs = $operacion->ejecutar($contexto);
                $this->generarItemsFinanzasDesdeDTOs($operacion, $item->getDocumento(), $itemFinanzasDTOs);
            } else {
                throw new Exception('La operación no puede ejecutarse en el contexto provisto.');
            }
        }
    }

    protected function generarItemsFinanzasDesdeDTOs(Operacion $operacion, Documento $documento, $itemFinanzasDTOs) {
        /**
         * Permitir compatibilidad con respuestas vacías o respuestas
         * con un único DTO.
         * En todos los casos se normaliza a un arreglo de DTOs (o vacío).
         */
        if ($itemFinanzasDTOs == null) {
            $itemFinanzasDTOs = array();
        }
        if (!is_array($itemFinanzasDTOs)) {
            $itemFinanzasDTOs = array($itemFinanzasDTOs);
        }

        /**
         * Por cada DTO generar el Item de finanzas correspondiente en el
         * documento.
         */
        foreach ($itemFinanzasDTOs as $itemFinanzasDTO) {
            $itemFinanzas = new ItemFinanzas($operacion, $itemFinanzasDTO->getCuenta());
            $itemFinanzas->setImporte($itemFinanzasDTO->getImporte());
            $documento->addItemFinanzas($itemFinanzas);
        }
    }

}
