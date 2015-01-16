<?php

namespace Pronit\ComprasBundle\Model\Contabilidad\Esquemas\EntradasMercancias;

use Doctrine\ORM\EntityManager;
use Exception;
use Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\EntradaMercancias;
use Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\ItemEntradaMercancias;
use Pronit\CoreBundle\Model\Contabilidad\Customizing\IImputacionesCustomizingManager;
use Pronit\CoreBundle\Model\Contabilidad\Customizing\IImputacionesCustomizingManager as FIIImputacionesCustomizingManager;
use Pronit\CoreBundle\Model\Contabilidad\Esquemas\EsquemaContable;
use Pronit\CoreBundle\Model\Contabilidad\Esquemas\IGeneradorEsquemaContable;
use Pronit\CoreBundle\Model\Contabilidad\Esquemas\ItemEsquemaContable;
use Pronit\CoreBundle\Entity\Documentos\ClasificadorItem;
use Pronit\CoreBundle\Entity\Documentos\Documento;
use Pronit\CoreBundle\Entity\Operaciones\OperacionContable;
use Pronit\CoreBundle\Model\Operaciones\Contextos\Documentos\ContextoItemDocumentoEntradaMercancias;
use Pronit\CustomizingBundle\Model\Operaciones\IOperacionesCustomizingManager;
use Pronit\GestionBienesYServiciosBundle\Entity\CategoriaValoracion;
use Pronit\GestionBienesYServiciosBundle\Model\Customizing\Contabilidad\IImputacionesCustomizingManager as IImputacionesCustomizingManager2;
use Pronit\GestionBienesYServiciosBundle\Model\Customizing\Contabilidad\IImputacionesCustomizingManager as MMIImputacionesCustomizingManager;

/**
 * Description of GeneradorEsquemaContable
 *
 * @author ldelia
 */
class GeneradorEsquemaContable implements IGeneradorEsquemaContable {

    protected $operacionesCustomizingManager;
    protected $mmImputacionesCustomizingManager;
    protected $fiImputacionesCustomizingManager;
    protected $entityManager;

    public function __construct(EntityManager $em, IOperacionesCustomizingManager $operacionesCustomizingManager, MMIImputacionesCustomizingManager $mmImputacionesCustomizingManager, FIIImputacionesCustomizingManager $fiImputacionesCustomizingManager) {
        $this->entityManager = $em;
        $this->setOperacionesCustomizingManager($operacionesCustomizingManager);
        $this->setMmImputacionesCustomizingManager($mmImputacionesCustomizingManager);
        $this->setFiImputacionesCustomizingManager($fiImputacionesCustomizingManager);
    }

    /**
     * 
     * @param Documento $documento
     * @return EsquemaContable
     */
    public function generar(Documento $documento) {
        return $this->generarDeEntradaMercancia($documento);
    }

    /**
     * 
     * @param EntradaMercancias $entradaMercancias
     */
    protected function generarDeEntradaMercancia(EntradaMercancias $entradaMercancias) {
        $esquema = new EsquemaContable();

        foreach ($entradaMercancias->getItems() as $item) {
            $itemsEsquema = $this->generarItemsEsquema($item);
            foreach ($itemsEsquema as $itemEsquema) {
                $esquema->addItem($itemEsquema);
            }
        }

        return $esquema;
    }

    /**
     * 
     * @param ItemEntradaMercancias $item
     * @return ItemEsquemaContable[]
     */
    protected function generarItemsEsquema(ItemEntradaMercancias $item) {
        $contexto = new ContextoItemDocumentoEntradaMercancias($item, $this->entityManager);

        $items = array();

        $clasificador = $item->getClasificador();
        $categoriaValoracion = $item->getBienServicio()->getCategoriaValoracion();

        $operacionesContables = $this->getOperacionesCustomizingManager()->getOperacionesContablesByClasificadorItem($clasificador);

        /* @var $operacionContable OperacionContable */
        foreach ($operacionesContables as $operacionContable) {

            $cuenta = $this->getCuentaAImputar($operacionContable, $clasificador, $categoriaValoracion);

            if ($operacionContable->aceptaContexto($contexto)) {
                
                $monto = $operacionContable->ejecutar($contexto);
                if( $monto !== 0 ){
                    $items[] = new ItemEsquemaContable($item, $operacionContable, $cuenta, $monto);                    
                }
                
            } else {
                throw new Exception('La operación no puede ejecutarse en el contexto provisto.');
            }
        }
        return $items;
    }

    protected function getCuentaAImputar(OperacionContable $operacionContable, ClasificadorItem $clasificador, CategoriaValoracion $categoriaValoracion) {
        $cuenta = $this->getMmImputacionesCustomizingManager()->getCuenta($clasificador, $operacionContable, $categoriaValoracion);

        if (is_null($cuenta)) {

            $cuenta = $this->getFiImputacionesCustomizingManager()->getCuenta($operacionContable);

            if (is_null($cuenta)) {
                throw new Exception('No se ha definido una imputación contable para la operacion ' . $operacionContable->getNombre());
            } else {
                return $cuenta;
            }
        } else {
            return $cuenta;
        }
    }

    /**
     * 
     * @return IOperacionesCustomizingManager
     */
    protected function getOperacionesCustomizingManager() {
        return $this->operacionesCustomizingManager;
    }

    protected function setOperacionesCustomizingManager(IOperacionesCustomizingManager $operacionesCustomizingManager) {
        $this->operacionesCustomizingManager = $operacionesCustomizingManager;
    }

    /**
     * 
     * @return IImputacionesCustomizingManager2
     */
    protected function getMmImputacionesCustomizingManager() {
        return $this->mmImputacionesCustomizingManager;
    }

    protected function setMmImputacionesCustomizingManager(MMIImputacionesCustomizingManager $mmImputacionesCustomizingManager) {
        $this->mmImputacionesCustomizingManager = $mmImputacionesCustomizingManager;
    }

    /**
     * 
     * @return IImputacionesCustomizingManager
     */
    protected function getFiImputacionesCustomizingManager() {
        return $this->fiImputacionesCustomizingManager;
    }

    protected function setFiImputacionesCustomizingManager(FIIImputacionesCustomizingManager $fiImputacionesCustomizingManager) {
        $this->fiImputacionesCustomizingManager = $fiImputacionesCustomizingManager;
    }

}
