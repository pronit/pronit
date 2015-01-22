<?php

namespace Pronit\ComprasBundle\Model\Documentos\EntradasMercancias;

use Doctrine\ORM\EntityManager;
use Exception;
use Pronit\CoreBundle\Entity\Documentos\Documento;
use Pronit\CoreBundle\Entity\Documentos\Item;
use Pronit\CoreBundle\Entity\Documentos\ItemFinanzas;
use Pronit\CoreBundle\Entity\Operaciones\Operacion;
use Pronit\CoreBundle\Model\Contabilidad\Customizing\IImputacionesCustomizingManager as FIIImputacionesCustomizingManager;
use Pronit\CoreBundle\Model\Documentos\IGeneradorItemsFinanzas;
use Pronit\CoreBundle\Model\Operaciones\Contextos\Documentos\ContextoItemDocumentoEntradaMercancias;
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

        $clasificador = $item->getClasificador();
        $operacionesContables = $this->operacionesCustomizingManager->getOperacionesContablesByClasificadorItem($clasificador);

        foreach ($operacionesContables as $operacion) {
            $contexto = new ContextoItemDocumentoEntradaMercancias($operacion, $item, $this->mmImputacionesCustomizingManager, $this->fiImputacionesCustomizingManager, $this->em);
           
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
