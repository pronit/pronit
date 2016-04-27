<?php

namespace Pronit\CoreBundle\Model\Controlling\Documentos\ImputacionSecundaria;

use Doctrine\ORM\EntityManager;
use Exception;

use Pronit\CoreBundle\Entity\Controlling\Documentos\ItemImputacionSecundaria;
use Pronit\CoreBundle\Entity\Documentos\ClaseDocumento;
use Pronit\CoreBundle\Entity\Documentos\Documento;
use Pronit\CoreBundle\Entity\Documentos\Item;
use Pronit\CoreBundle\Entity\Documentos\ItemFinanzas;
use Pronit\CoreBundle\Entity\Operaciones\Operacion;
use Pronit\CoreBundle\Model\Aspectos\IAspectoManager;
use Pronit\CoreBundle\Model\Contabilidad\Customizing\IImputacionesCustomizingManager as FIIImputacionesCustomizingManager;
use Pronit\CoreBundle\Model\Documentos\IGeneradorItemsFinanzas;
use Pronit\CoreBundle\Model\Operaciones\Contextos\Controlling\Documentos\ImputacionSecundaria\ContextoItemDocumentoImputacionSecundaria;
use Pronit\CustomizingBundle\Entity\Operaciones\MappingClaseDocumentoOperacion;
use Pronit\CustomizingBundle\Entity\Operaciones\MappingClasificadorItemOperacion;
use Pronit\CustomizingBundle\Model\Operaciones\IOperacionesCustomizingManager;
use Pronit\GestionBienesYServiciosBundle\Model\Customizing\Contabilidad\IImputacionesCustomizingManager as MMIImputacionesCustomizingManager;

class GeneradorItemsFinanzas implements IGeneradorItemsFinanzas 
{
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

    }

    protected function generarDesdeItem(Item $item) {
        $this->generarDesdeItemImputacionSecundaria($item);
    }

    protected function generarDesdeItemImputacionSecundaria(ItemImputacionSecundaria $item) 
    {
        $documento = $item->getDocumento();
        $clasificador = $item->getClasificador();
        $mappingsClasificadorItemOperacion = $this->operacionesCustomizingManager->getMappingsByClasificadorItem($clasificador);

        foreach ($mappingsClasificadorItemOperacion as /* @var $mappingClasificadorItemOperacion MappingClasificadorItemOperacion */ $mappingClasificadorItemOperacion) {
            $operacion = $mappingClasificadorItemOperacion->getOperacion();
            $funcion = $mappingClasificadorItemOperacion->getFuncion();
            $contexto = new ContextoItemDocumentoImputacionSecundaria($item, $this->em);

            $cuenta = $item->getObjetoCosto()->getCuentaContable();
            
            $importe = $funcion->ejecutar($contexto);

            if ($importe != 0) {                
                $itemFinanzas = new ItemFinanzas($operacion, $cuenta, $item, $importe);
                $documento->addItemFinanzas($itemFinanzas);
            }
        }
    }

}
