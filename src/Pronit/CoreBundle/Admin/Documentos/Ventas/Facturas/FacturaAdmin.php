<?php
namespace Pronit\CoreBundle\Admin\Documentos\Ventas\Facturas;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Admin\AdminInterface;

use Pronit\CoreBundle\Entity\Documentos\Ventas\Facturas\Factura;
use Pronit\CoreBundle\Entity\Documentos\Ventas\Facturas\ItemFactura;

/**
 *
 * @author ldelia
 */
class FacturaAdmin extends Admin
{   
    protected $baseRouteName = 'pronit_ventas_facturas';
    
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('numero', null, array('route' => array('name' => 'show')))
            ->add('estadoVentas')
            ->add('sociedad')
            ->add('centroLogistico', null, array('label'=>'Centro Logístico') )
            ->add('fecha', 'date', array( 'format' => 'd/m/Y' ))
            ->add('deudorSociedad', null, array('label'=>'Proveedor') )            
            ->add('condicionPagos', null, array('label'=>'Condición de Pagos') )
            ->add('moneda')
            
        ;
    }
    
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('Cabecera')
                ->add('numero')
                ->add('estadoVentas')
                ->add('sociedad')                
                ->add('centroLogistico')
                ->add('fecha', 'date', array( 'format' => 'd/m/Y' ))                                                
                ->add('deudorSociedad', null, array('label'=>'Proveedor') )                  
                ->add('condicionPagos', null, array('label'=>'Condición de Pagos') )         
                ->add('moneda')                
                ->add('textoCabecera')
            ->end()      
            ->with('Items')
                ->add('items', null, array('template' => 'PronitCoreBundle:Documentos\Ventas\Factura\show:items.html.twig'))
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
                ->add('centroLogistico')
                ->add('entradamercancias_id', 'hidden', array('data' => $entradamercancias_id, 'mapped' => false))
                ->add('fecha', 'date', array('widget' => 'single_text'))                                                
            ->end()
            ->with('Cabecera')
                ->add('deudorSociedad', null, array('label'=>'Proveedor') )
                ->add('condicionPagos', null, array('label'=>'Condición de Pagos', 'required' => true) )
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
                        'admin_code' => 'pronit.admin.core.ventas.facturas.itemfactura'
                    )
                )
            ->end()                    
        ; 
    }        
    
    public function getNewInstance()
    {
        $factura = new Factura();
        
        $salidamercancias_id = $this->request->query->get('salidamercancias_id');
        
        /* 
         * Obtener clasificador item por defecto para SalidaMercancias
         * TODO: Debería definirse como customizing.
         */        
        $clasificadores = $this->getConfigurationPool()->getContainer()->get('doctrine')
                ->getRepository('Pronit\CoreBundle\Entity\Documentos\Ventas\Facturas\ClasificadorItemFactura')
                ->createQueryBuilder('q')
                ->setMaxResults(1)
                ->getQuery()->getResult();
        $clasificador = $clasificadores[0];        

        /* @var $salidaMercancias \Pronit\CoreBundle\Entity\Documentos\Ventas\SalidasMercancias\SalidaMercancias  */
        $salidaMercancias = $this->getModelManager()->find('Pronit\CoreBundle\Entity\Documentos\Ventas\SalidasMercancias\SalidaMercancias', $salidamercancias_id);
        
        if( $salidaMercancias ){
            
            $factura->setSociedad( $salidaMercancias->getSociedad() );
            $factura->setMoneda( $salidaMercancias->getMoneda() );
            $factura->setCentroLogistico( $salidaMercancias->getCentroLogistico() );
            $factura->setDeudorSociedad( $salidaMercancias->getDeudorSociedad() );

            /* @var $itemSalidaMercancias \Pronit\CoreBundle\Entity\Documentos\Ventas\SalidasMercancias\ItemSalidaMercancias  */            
            foreach ( $salidaMercancias->getItems() as $itemSalidaMercancias ) 
            {
                /* @var $item ItemFactura */

                $item = new ItemFactura();
                $item->setClasificador($clasificador);        
                $item->setBienServicio($itemSalidaMercancias->getBienServicio());
                $item->setPrecioUnitario($itemSalidaMercancias->getPrecioUnitario());
                $item->setCantidad($itemSalidaMercancias->getCantidad());        
                $item->setEscala($itemSalidaMercancias->getEscala());
                $item->setItemSalidaMercanciasFacturado( $itemSalidaMercancias );

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

            /* @var $factura \Pronit\CoreBundle\Entity\Documentos\Ventas\Facturas\Factura  */            
            $factura = $this->getObject($id);
            
            if( $factura->isModificable() ){
                
                $menu->addChild( 'Contabilizar', array('uri' => $admin->generateUrl('contabilizar', array('id' => $id))) )
                        ->setLinkAttribute('class', 'glyphicon glyphicon-ok');                
            }
        }
    }    
    
    public function isGranted($name, $factura = null)
    {
        /* @var $factura \Pronit\CoreBundle\Entity\Documentos\Ventas\Facturas\Factura  */            
        
        if (( $name == 'EDIT' ) && ( ! is_null($factura)) ){            
            return $factura->isModificable() && parent::isGranted($name, $factura);
        }else{
            return parent::isGranted($name, $factura);
        }        
    }
    
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('contabilizar', $this->getRouterIdParameter() . '/contabilizar');
    }    
}