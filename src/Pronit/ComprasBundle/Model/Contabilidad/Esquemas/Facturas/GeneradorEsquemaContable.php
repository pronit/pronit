<?php

namespace Pronit\ComprasBundle\Model\Contabilidad\Esquemas\Facturas;

use Doctrine\ORM\EntityManager;
use Exception;
use Pronit\ComprasBundle\Entity\Documentos\Facturas\Factura;
use Pronit\ComprasBundle\Entity\Documentos\Facturas\ItemFactura;
use Pronit\CoreBundle\Entity\Documentos\ClasificadorItem;
use Pronit\CoreBundle\Entity\Documentos\Documento;
use Pronit\CoreBundle\Entity\Operaciones\OperacionContable;
use Pronit\ParametrizacionGeneralBundle\Entity\ItemCondicionPagos;

use Pronit\CoreBundle\Model\Contabilidad\Customizing\IImputacionesCustomizingManager;
use Pronit\CoreBundle\Model\Contabilidad\Customizing\IImputacionesCustomizingManager as FIIImputacionesCustomizingManager;
use Pronit\CoreBundle\Model\Contabilidad\Esquemas\EsquemaContable;
use Pronit\CoreBundle\Model\Contabilidad\Esquemas\IGeneradorEsquemaContable;
use Pronit\CoreBundle\Model\Contabilidad\Esquemas\ItemEsquemaContable;

use Pronit\CoreBundle\Model\Operaciones\Contextos\Documentos\Facturas\ContextoItemDocumentoFactura;
use Pronit\CoreBundle\Model\Operaciones\Contextos\Impuestos\ContextoCalculoImpuesto;
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
        return $this->generarDeFactura($documento);
    }

    /**
     * 
     * @param \Pronit\ComprasBundle\Entity\Documentos\Facturas\Factura $factura
     */
    protected function generarDeFactura(Factura $factura) 
    {
        $esquema = new EsquemaContable();

        foreach ($factura->getItems() as $item) {
            $itemsEsquema = $this->generarItemsEsquemaSegunItemFactura($item);
            foreach ($itemsEsquema as $itemEsquema) {
                $esquema->addItem($itemEsquema);
            }
        }                
        
        /* Actualizar EsquemaContable según Condición de pagos */
        
        $itemsEsquema = $this->generarItemsEsquemaSegunCondicionPagosDeFactura($factura);
        
        foreach ($itemsEsquema as $itemEsquema) {
            $esquema->addItem($itemEsquema);
        }
        
        return $esquema;
    }

    /**
     * 
     * @param Factura $factura
     * @return ItemEsquemaContable[]
     */
    protected function generarItemsEsquemaSegunCondicionPagosDeFactura(Factura $factura) 
    {
        $itemsEsquema = array();
                
        $operacionContable = $this->getOperacionCondicionPagos();
        $cuenta = $factura->getProveedorSociedad()->getAcreedor()->getCuenta();
        
        foreach ( $factura->getCondicionPagos()->getItems() as /* @var $itemCondicionPagos ItemCondicionPagos */ $itemCondicionPagos ){
                    
            $montoCuota = $factura->getImporteTotal() / 100 * $itemCondicionPagos->getPorcentaje();
            
            if( $montoCuota !== 0 ){
                $itemsEsquema[] = new ItemEsquemaContable($operacionContable, $cuenta, $montoCuota );
            }
        }
        
        return $itemsEsquema;
    }
    
    /**
     * 
     * @param ItemFactura $item
     * @return ItemEsquemaContable[]
     */
    protected function generarItemsEsquemaSegunItemFactura(ItemFactura $item) 
    {
        $contexto = new ContextoItemDocumentoFactura($item, $this->entityManager);

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
                    $items[] = new ItemEsquemaContable($operacionContable, $cuenta, $monto);
                }
            } else {
                throw new Exception('La operación no puede ejecutarse en el contexto provisto.');
            }
        }
        
        /* Obtener esquema contable según indicador impuestos */
        
        /* @var $itemIndicadorImpuesto \Pronit\CoreBundle\Entity\Impuestos\ItemIndicadorImpuestos */
        foreach( $item->getIndicadorImpuestos()->getItems() as $itemIndicadorImpuesto ){
            
            $contexto = new ContextoCalculoImpuesto( $item->getImporteNeto(), $itemIndicadorImpuesto->getAlicuota() );
            
            $operacionContable = $itemIndicadorImpuesto->getOperacionContable();
            
            $cuenta = $this->getCuentaAImputar($operacionContable, $clasificador, $categoriaValoracion);

            if ($operacionContable->aceptaContexto($contexto)) {
                $monto = $operacionContable->ejecutar($contexto);
            } else {
                throw new Exception('La operación no puede ejecutarse en el contexto provisto.');
            }
    
            $items[] = new ItemEsquemaContable($operacionContable, $cuenta, $monto);            
        }
        
        return $items;
    }

    protected function getCuentaAImputar(OperacionContable $operacionContable, ClasificadorItem $clasificador, CategoriaValoracion $categoriaValoracion) 
    {
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
     * TODO: Refactorizar. Queda hardcodeada la operación KBS
     */
    protected function getOperacionCondicionPagos()
    {
        return $this->entityManager->getRepository('Pronit\CoreBundle\Entity\Operaciones\OperacionContable')
                                    ->findOneByCodigo('KBS');
    }

    /**
     * 
     * @return IOperacionesCustomizingManager
     */
    protected function getOperacionesCustomizingManager() 
    {
        return $this->operacionesCustomizingManager;
    }

    protected function setOperacionesCustomizingManager(IOperacionesCustomizingManager $operacionesCustomizingManager) 
    {
        $this->operacionesCustomizingManager = $operacionesCustomizingManager;
    }

    /**
     * 
     * @return IImputacionesCustomizingManager2
     */
    protected function getMmImputacionesCustomizingManager() 
    {
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
