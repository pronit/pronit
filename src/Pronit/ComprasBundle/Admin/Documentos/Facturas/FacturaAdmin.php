<?php
namespace Pronit\ComprasBundle\Admin\Documentos\Facturas;

use Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\ItemEntradaMercancias;
use Pronit\ComprasBundle\Entity\Documentos\Facturas\Factura;
use Pronit\ComprasBundle\Entity\Documentos\Facturas\ItemFactura;
use Pronit\ComprasBundle\Entity\Documentos\Pedidos\Pedido;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Admin\AdminInterface;

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
            ->addIdentifier('numero', null, array('route' => array('name' => 'show')))
            ->add('estadoCompras')
            ->add('sociedad')
            ->add('fecha', 'date', array( 'format' => 'd/m/Y' ))
            ->add('proveedorSociedad', null, array('label'=>'Proveedor') ) 
            ->add('centroLogistico')
            ->add('moneda')
        ;
    }
    
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('Cabecera')
                ->add('numero')
                ->add('estadoCompras')
                ->add('sociedad')                
                ->add('fecha', 'date', array( 'format' => 'd/m/Y' ))                                                
                ->add('proveedorSociedad', null, array('label'=>'Proveedor') )                  
                ->add('centroLogistico')
                ->add('moneda')                
                ->add('textoCabecera')
            ->end()      
            ->with('Items')
                ->add('items', null, array('template' => 'PronitComprasBundle:Documentos\Factura\show:items.html.twig'))
            ->end()  

        ;
    }    
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $entradamercancias_id = $this->request->query->get('entradamercancias_id');
        
        $formMapper
            ->with('Factura', array('class' => 'col-md-6'))->end()
            ->with('Cabecera', array('class' => 'col-md-6'))->end()
            ->with('Items', array('class' => 'col-md-12') )->end()
        ;   
        
        $formMapper
            ->with('Factura')
                ->add('numero')
                ->add('sociedad')                
                ->add('entradamercancias_id', 'hidden', array('data' => $entradamercancias_id, 'mapped' => false))
                ->add('fecha', 'date', array('widget' => 'single_text'))                                                
            ->end()
            ->with('Cabecera')
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
    
    public function getNewInstance()
    {
        $factura = new Factura();
        
        $entradamercancias_id = $this->request->query->get('entradamercancias_id');
        
        /* 
         * Obtener clasificador item por defecto para EntradaMercancias
         * TODO: Debería definirse como customizing.
         */        
        $clasificadores = $this->getConfigurationPool()->getContainer()->get('doctrine')
                ->getRepository('Pronit\ComprasBundle\Entity\Documentos\Facturas\ClasificadorItemFactura')
                ->createQueryBuilder('q')
                ->setMaxResults(1)
                ->getQuery()->getResult();
        $clasificador = $clasificadores[0];        

        /* @var $entradaMercancias \Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\EntradaMercancias  */
        $entradaMercancias = $this->getModelManager()->find('Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\EntradaMercancias', $entradamercancias_id);
        
        if( $entradaMercancias ){
            
            $factura->setSociedad( $entradaMercancias->getSociedad() );
            $factura->setMoneda( $entradaMercancias->getMoneda() );
            $factura->setCentroLogistico( $entradaMercancias->getCentroLogistico() );
            $factura->setProveedorSociedad( $entradaMercancias->getProveedorSociedad() );

            /* @var $itemEntradaMercancias \Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\ItemEntradaMercancias  */            
            foreach ( $entradaMercancias->getItems() as $itemEntradaMercancias ) 
            {
                /* @var $item ItemFactura */

                $item = new ItemFactura();
                $item->setClasificador($clasificador);        
                $item->setBienServicio($itemEntradaMercancias->getBienServicio());
                $item->setPrecioUnitario($itemEntradaMercancias->getPrecioUnitario());
                $item->setCantidad($itemEntradaMercancias->getCantidad());        
                $item->setEscala($itemEntradaMercancias->getEscala());
                $item->setItemEntradaMercanciasFacturado( $itemEntradaMercancias );

                $factura->addItem($item);
            }
        }
        return $factura;
    }
    
    protected function configureSideMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null) 
    {        
        if( $action == "show"){
            
            $admin = $this->isChild() ? $this->getParent() : $this;
            $id = $admin->getRequest()->get('id');

            /* @var $factura \Pronit\ComprasBundle\Entity\Documentos\Facturas\Factura  */            
            $factura = $this->getObject($id);
            
            if( $factura->isModificable() ){
                
                $menu->addChild( 'Contabilizar', array('uri' => $admin->generateUrl('contabilizar', array('id' => $id))) )
                        ->setLinkAttribute('class', 'glyphicon glyphicon-ok');                
            }/*else{
                
                if(! $entradaMercancias->isFacturacionFinalizada() ){
                    $menu->addChild( 'Crear Factura', array('uri' => $admin->generateUrl('crearFacturaDesdeEntradaMercancias', array('id' => $id))) )
                            ->setLinkAttribute('class', 'glyphicon glyphicon-import');                
                }                
            }  */          
  
        }
    }    
    
    public function isGranted($name, $factura = null)
    {
        /* @var $factura \Pronit\ComprasBundle\Entity\Documentos\Facturas\Factura  */            
        
        if (( $name == 'EDIT' ) && ( ! is_null($factura)) ){            
            return $factura->isModificable() && parent::isGranted($name, $factura);
        }else{
            return parent::isGranted($name, $factura);
        }        
    }
    
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('contabilizar', $this->getRouterIdParameter() . '/contabilizar');
     //   $collection->add('crearFacturaDesdeEntradaMercancias', $this->getRouterIdParameter() . '/new');
    }    
}