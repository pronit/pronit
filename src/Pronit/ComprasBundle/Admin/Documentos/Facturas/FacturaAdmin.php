<?php
namespace Pronit\ComprasBundle\Admin\Documentos\Facturas;

use Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\ItemEntradaMercancias;
use Pronit\ComprasBundle\Entity\Documentos\Facturas\Factura;
use Pronit\ComprasBundle\Entity\Documentos\Facturas\ItemFactura;
use Pronit\ComprasBundle\Entity\Documentos\Pedidos\Pedido;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

/**
 *
 * @author gcaseres
 */
class FacturaAdmin extends Admin
{   
    protected $baseRouteName = 'pronit_facturas';
    
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('numero')
            ->add('estado')
            ->add('sociedad')
            ->add('fecha', 'date', array( 'format' => 'd/m/Y' ))
            ->add('proveedorSociedad', null, array('label'=>'Proveedor') ) 
            ->add('centroLogistico')
            ->add('moneda')
            ->add('_action', 'actions', array(
                    'actions' => array(
                        'show' => array(),
                        'edit' => array(),
                    ),                
                )
            )                
        ;
    }
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Facturas')
                ->add('numero')
                ->add('sociedad')                
                ->add('fecha', 'date', array('widget' => 'single_text'))                                                
                ->add('proveedorSociedad', null, array('label'=>'Proveedor') )
                ->add('centroLogistico')
                ->add('moneda')
                ->add('textoCabecera')
            ->end()
            ->with('Items')
                ->add('items', 
                    'sonata_type_collection', 
                    array(
                        'cascade_validation' => true, 
                        'by_reference' => false, 
                    ), 
                    array(
                        'edit' => 'inline',
                        'inline' => 'table',                    
                        'admin_code' => 'pronit.admin.compras.facturas.itemfactura'
                    )
                )
            ->end()                    
        ; 
    }        
    
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('create' , 'list'));        
    }    
    
    public function getNewInstance()
    {
        $factura = new Factura();
        
        $entradamercancia_id = $this->request->query->get('entradamercancia_id');
        
        /* @var $pedido Pedido  */
        $entradaMercancias = $this->getModelManager()->find('Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\EntradaMercancias', $entradamercancia_id);        
        
        if( $entradaMercancias ){
            
            $factura->setSociedad( $entradaMercancias->getSociedad() );
            $factura->setMoneda( $entradaMercancias->getMoneda() );
            $factura->setCentroLogistico( $entradaMercancias->getCentroLogistico() );
            $factura->setProveedorSociedad( $entradaMercancias->getProveedorSociedad() );

            foreach ( $entradaMercancias->getItems() as $itemEntradaMercancias ) 
            {
                /* @var $itemEntradaMercancias ItemEntradaMercancias */

                $item = new ItemFactura();
                $item->setClasificador($itemEntradaMercancias->getClasificador());        
                $item->setBienServicio($itemEntradaMercancias->getBienServicio());
                $item->setPrecioUnitario($itemEntradaMercancias->getPrecioUnitario());
                $item->setCantidad($itemEntradaMercancias->getCantidad());        
                $item->setEscala($itemEntradaMercancias->getEscala());

                $factura->addItem($item);
            }
        }
        return $factura;
    }
}