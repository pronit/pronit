<?php
namespace Pronit\ComprasBundle\Admin\Documentos\EntradasMercancias;

use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Admin\AbstractAdmin as AdminInterface;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

use Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\EntradaMercancias;
use Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\ItemEntradaMercancias;

use Pronit\CoreBundle\Entity\Documentos\ClaseDocumento;
/**
 *
 * @author ldelia
 */
class EntradaMercanciasAdmin extends Admin
{   
    protected $baseRouteName = 'pronit_entradas_mercancias';
    
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('numero', null, array('route' => array('name' => 'show')))
            ->add('estadoCompras')
            ->add('estadoFacturacion')
            ->add('sociedad')
            ->add('fecha', 'date', array( 'format' => 'd/m/Y' ))
            ->add('proveedorSociedad', null, array('label'=>'Proveedor') ) 
            ->add('centroLogistico')
            ->add('moneda')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('numero')
            ->add('sociedad')                             
            ->add('fecha')
            /*->add('estadoEntrega', 'doctrine_orm_callback',
                  array(
                      'callback' => function($queryBuilder, $alias, $field, $value) {
                        if (!$value['value']) {
                            return;
                        }                                                
                        
                        $queryBuilder->join($alias .'.estadoEntrega', 'e');
                        $queryBuilder->andWhere( $queryBuilder->expr()->in(                                  
                                   'e.id',                                  
                                    'SELECT e2.id '
                                    . ' FROM '.$value['value'].' e2 '                                
                               ) 
                        );                        

                        return true;
                    },
                    'field_type' => 'choice',
                    'field_options' => array(
                        'choices' => array( 
                            'Pronit\ComprasBundle\Entity\Documentos\Estados\Entregas\SinEntregar' => 'Sin Entregar',
                            'Pronit\ComprasBundle\Entity\Documentos\Estados\Entregas\EntregadoParcialmente' => 'Entregado Parcialmente',
                            'Pronit\ComprasBundle\Entity\Documentos\Estados\Entregas\Finalizado' => 'Finalizado',
                        ),
                    )
                )
            ) */           
            ->add('proveedorSociedad', null, array('label'=>'Proveedor') )  
            ->add('centroLogistico')
            ->add('textoCabecera')
        ;
    }
    
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('Cabecera')
                ->add('numero')
                ->add('estadoCompras')
                ->add('estadoFacturacion')
                ->add('sociedad')                
                ->add('fecha', 'date', array( 'format' => 'd/m/Y' ))                                                
                ->add('proveedorSociedad', null, array('label'=>'Proveedor') )                  
                ->add('centroLogistico')
                ->add('moneda')                
                ->add('textoCabecera')
            ->end()      
            ->with('Items')
                ->add('items', null, array('template' => 'PronitComprasBundle:Documentos\EntradaMercancias\show:items.html.twig'))
            ->end()  

        ;
    }        
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $pedido_id = $this->request->query->get('pedido_id');

        $formMapper
            ->with('Entrada de Mercancías', array('class' => 'col-md-6'))->end()
            ->with('Cabecera', array('class' => 'col-md-6'))->end()
            ->with('Items', array('class' => 'col-md-12') )->end()
        ;   
        
        $formMapper
            ->with('Entrada de Mercancías')
                ->add('numero')
                ->add('fecha', 'date', array('widget' => 'single_text'))                                                
                ->add('pedido_id', 'hidden', array('data' => $pedido_id, 'mapped' => false)) 
                ->add('sociedad')                
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
                        'admin_code' => 'pronit.admin.compras.entradasmercancias.itementradamercancias'
                    )
                )
            ->end()                    
        ; 
    }        
    
    public function getNewInstance()
    {
        /* @var $clase \Pronit\CoreBundle\Entity\Documentos\ClaseDocumento  */
        $clase = $this->getModelManager()->find('Pronit\CoreBundle\Entity\Documentos\ClaseDocumento', ClaseDocumento::CODIGO_ENTRADAMERCANCIAS);                
        
        $entradaMercancia = new EntradaMercancias();
        $entradaMercancia->setClase($clase);
        
        $pedido_id = $this->request->query->get('pedido_id');
        
        /* 
         * Obtener clasificador item por defecto para EntradaMercancias
         * TODO: Debería definirse como customizing.
         */        
        $clasificadores = $this->getConfigurationPool()->getContainer()->get('doctrine')
                ->getRepository('Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\ClasificadorItemEntradaMercancias')
                ->createQueryBuilder('q')
                ->setMaxResults(1)
                ->getQuery()->getResult();
        $clasificador = $clasificadores[0];
        
        /* @var $pedido \Pronit\ComprasBundle\Entity\Documentos\Pedidos\Pedido  */
        $pedido = $this->getModelManager()->find('Pronit\ComprasBundle\Entity\Documentos\Pedidos\Pedido', $pedido_id);        
        
        if( $pedido ){        
            
            $entradaMercancia->setSociedad( $pedido->getSociedad() );
            $entradaMercancia->setMoneda( $pedido->getMoneda() );
            $entradaMercancia->setCentroLogistico( $pedido->getCentroLogistico() );
            $entradaMercancia->setProveedorSociedad( $pedido->getProveedorSociedad() );

            foreach ( $pedido->getItems() as $itemPedido ) 
            {
                /* @var $itemPedido \Pronit\ComprasBundle\Entity\Documentos\Pedidos\ItemPedido  */

                $item = new ItemEntradaMercancias();
                $item->setClasificador($clasificador);       
                $item->setPresentacionCompra( $itemPedido->getPresentacionCompra() );
                $item->setPrecioUnitario($itemPedido->getPrecioUnitario());
                $item->setCantidad($itemPedido->getCantidadPendienteDeEntrega());        
                $item->setEscala($itemPedido->getEscala());
                $item->setItemPedidoEntregado( $itemPedido );

                if( $itemPedido->getAlmacen() ){
                    $item->setAlmacen($itemPedido->getAlmacen());    
                }                
                
                if( $itemPedido->getObjetoCosto() ){
                    $item->setObjetoCosto($itemPedido->getObjetoCosto());    
                }                

                $entradaMercancia->addItem($item);
            }
        }
        return $entradaMercancia;
    }
    
    protected function configureTabMenu(MenuItemInterface $menu, $action, \Sonata\AdminBundle\Admin\AdminInterface $childAdmin = null)
    {        
        if( $action == "show"){
            
            $admin = $this->isChild() ? $this->getParent() : $this;
            $id = $admin->getRequest()->get('id');

            /* @var $entradaMercancias \Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\EntradaMercancias  */            
            $entradaMercancias = $this->getObject($id);
            
            if( $entradaMercancias->isModificable() ){
                
                $menu->addChild( 'Contabilizar', array('uri' => $admin->generateUrl('contabilizar', array('id' => $id))) )
                        ->setLinkAttribute('class', 'glyphicon glyphicon-ok');                
            }else{
                
                if(! $entradaMercancias->isFacturacionFinalizada() ){
                    $menu->addChild( 'Crear Factura', array('uri' => $admin->generateUrl('crearFacturaDesdeEntradaMercancias', array('id' => $id))) )
                            ->setLinkAttribute('class', 'glyphicon glyphicon-import');                
                }                
            }            
  
        }
    }
    
    public function isGranted($name, $entradaMercancias = null)
    {
        /* @var $entradaMercancias \Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\EntradaMercancias  */            
        
        if (( $name == 'EDIT' ) && ( ! is_null($entradaMercancias)) ){            
            return $entradaMercancias->isModificable() && parent::isGranted($name, $entradaMercancias);
        }else{
            return parent::isGranted($name, $entradaMercancias);
        }        
    }
    
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('contabilizar', $this->getRouterIdParameter() . '/contabilizar');
        $collection->add('crearFacturaDesdeEntradaMercancias', $this->getRouterIdParameter() . '/new');
    }        
}
