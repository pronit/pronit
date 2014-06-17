<?php

namespace Pronit\ComprasBundle\Model\Contabilidad\Esquemas\EntradasMercancias;

use Pronit\ContabilidadBundle\Model\Esquemas\IGeneradorEsquemaContable;

use Pronit\CoreBundle\Entity\Documentos\Documento;
use Pronit\CustomizingBundle\Model\Operaciones\IOperacionesCustomizingManager;
use Pronit\GestionMaterialesBundle\Model\Customizing\Contabilidad\IImputacionesCustomizingManager as MMIImputacionesCustomizingManager;
use Pronit\ContabilidadBundle\Model\Customizing\IImputacionesCustomizingManager as FIIImputacionesCustomizingManager;

use Pronit\ComprasBundle\Entity\EntradasMercancias\EntradaMercancias;
use Pronit\ComprasBundle\Entity\EntradasMercancias\ItemEntradaMercancias;

use Pronit\ContabilidadBundle\Model\Esquemas\EsquemaContable;
use Pronit\ContabilidadBundle\Model\Esquemas\ItemEsquemaContable;

use Pronit\CoreBundle\Entity\Contabilidad\OperacionContable;
use Pronit\CoreBundle\Entity\Documentos\ClasificadorItem;
use Pronit\GestionMaterialesBundle\Entity\CategoriaValoracion;

use Pronit\CoreBundle\Model\Operaciones\Contextos\Documentos\ContextoItemDocumentoEntradaMercancias;

/**
 * Description of GeneradorEsquemaContable
 *
 * @author ldelia
 */
class GeneradorEsquemaContable implements IGeneradorEsquemaContable
{
    protected $operacionesCustomizingManager;
    protected $mmImputacionesCustomizingManager;
    protected $fiImputacionesCustomizingManager;
    
    public function __construct(IOperacionesCustomizingManager $operacionesCustomizingManager, MMIImputacionesCustomizingManager $mmImputacionesCustomizingManager, FIIImputacionesCustomizingManager $fiImputacionesCustomizingManager )
    {
        $this->setOperacionesCustomizingManager($operacionesCustomizingManager);
        $this->setMmImputacionesCustomizingManager($mmImputacionesCustomizingManager);
        $this->setFiImputacionesCustomizingManager($fiImputacionesCustomizingManager);
    }
    
    /**
     * 
     * @param \Pronit\CoreBundle\Entity\Documentos\Documento $documento
     * @return \Pronit\ContabilidadBundle\Model\Esquemas\EsquemaContable
     */
    public function generar(Documento $documento)
    {
        return $this->generarDeEntradaMercancia($documento);
    }
    
    /**
     * 
     * @param \Pronit\ComprasBundle\Entity\EntradasMercancias\EntradaMercancias $entradaMercancias
     */
    protected function generarDeEntradaMercancia(EntradaMercancias $entradaMercancias)
    {
        $esquema = new EsquemaContable();        
        
        foreach( $entradaMercancias->getItems() as $item )
        {
            $itemsEsquema = $this->generarItemsEsquema($item);
            foreach ($itemsEsquema as $itemEsquema )
            {
                $esquema->addItem($itemEsquema);
            }
        }
        
        return $esquema;
    }
    
    /**
     * 
     * @param \Pronit\ComprasBundle\Entity\EntradasMercancias\ItemEntradaMercancias $item
     * @return \Pronit\ContabilidadBundle\Model\Esquemas\ItemEsquemaContable[]
     */
    protected function generarItemsEsquema(ItemEntradaMercancias $item)
    {
        $contexto = new ContextoItemDocumentoEntradaMercancias( $item );
        
        $items = array();

        $clasificador = $item->getClasificador();
        $categoriaValoracion = $item->getMaterial()->getCategoriaValoracion();        
                
        $operacionesContables = $this->getOperacionesCustomizingManager()->getOperacionesContablesByClasificadorItem($clasificador);
        
        /* @var $operacionContable \Pronit\CoreBundle\Entity\Contabilidad\OperacionContable */        
        foreach( $operacionesContables as $operacionContable ){
            
            $cuenta = $this->getCuentaAImputar($operacionContable, $clasificador, $categoriaValoracion);
            
            if( $operacionContable->aceptaContexto($contexto) ){
                $monto = $operacionContable->ejecutar($contexto);
            }            
            
            $items[] = new ItemEsquemaContable( $item, $operacionContable, $cuenta, $monto );
        }                
        return $items;
    }
    
    protected function getCuentaAImputar(OperacionContable $operacionContable, ClasificadorItem $clasificador, CategoriaValoracion $categoriaValoracion)
    {        
        $cuenta = $this->getMmImputacionesCustomizingManager()->getCuenta($clasificador, $operacionContable, $categoriaValoracion);
        
        if( is_null($cuenta) ){
            
            $cuenta = $this->getFiImputacionesCustomizingManager()->getCuenta($operacionContable);
      
            if( is_null($cuenta) ){
                throw new \Exception('No se ha definido una imputación contable para la operacion ' . $operacionContable->getNombre());
            }else{
                return $cuenta;    
            }
            
        }else{
            return $cuenta;
        }
    }
    
    /**
     * 
     * @return \Pronit\CustomizingBundle\Model\Operaciones\IOperacionesCustomizingManager
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
     * @return \Pronit\GestionMaterialesBundle\Model\Customizing\Contabilidad\IImputacionesCustomizingManager
     */
    protected function getMmImputacionesCustomizingManager()
    {
        return $this->mmImputacionesCustomizingManager;
    }

    protected function setMmImputacionesCustomizingManager(MMIImputacionesCustomizingManager $mmImputacionesCustomizingManager)
    {
        $this->mmImputacionesCustomizingManager = $mmImputacionesCustomizingManager;
    }    
    
    /**
     * 
     * @return \Pronit\ContabilidadBundle\Model\Customizing\IImputacionesCustomizingManager
     */
    protected function getFiImputacionesCustomizingManager()
    {
        return $this->fiImputacionesCustomizingManager;
    }

    protected function setFiImputacionesCustomizingManager(FIIImputacionesCustomizingManager $fiImputacionesCustomizingManager)
    {
        $this->fiImputacionesCustomizingManager = $fiImputacionesCustomizingManager;
    }    
}
