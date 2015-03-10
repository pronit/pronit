<?php
namespace Pronit\ComprasBundle\Admin\Documentos\OrdenesPago;

use Pronit\ComprasBundle\Entity\Documentos\OrdenesPago\OrdenPago;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Admin\AdminInterface;


use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;


use Pronit\ComprasBundle\Form\Type\ItemPagoType;

/**
 *
 * @author ldelia
 */
class OrdenPagoAdmin extends Admin
{   
    protected $baseRouteName = 'pronit_ordenespago';
    
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('numero', null, array('route' => array('name' => 'show')))
            ->add('estadoCompras')
            ->add('sociedad')
            ->add('fecha', 'date', array( 'format' => 'd/m/Y' ))
            ->add('proveedorSociedad', null, array('label'=>'Proveedor') )            
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
                ->add('moneda')                
                ->add('textoCabecera')
            ->end()      
//            ->with('Items')
//                ->add('items', null, array('template' => 'PronitComprasBundle:Documentos\Factura\show:items.html.twig'))
//            ->end()  

        ;
    }    
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Orden de Pago', array('class' => 'col-md-6'))->end()
            ->with('Cabecera', array('class' => 'col-md-6'))->end()
//            ->with('Items', array('class' => 'col-md-12') )->end()
        ;   
        
        $formMapper
            ->with('Orden de Pago')
                ->add('numero')
                ->add('sociedad')
                ->add('fecha', 'date', array('widget' => 'single_text'))                                                
            ->end()
            ->with('Cabecera')
                ->add('proveedorSociedad', null, array('label'=>'Proveedor') )
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
                        'admin_code' => 'pronit.admin.compras.ordenespago.itemordenpago'
                    )
                )
            ->end()                    
            ->with('Pagos')
                ->add( 
                    $formMapper->create(
                        'itemsPago',
                        'collection', 
                        array(
                            'allow_add' => true,
                            'prototype' => false,
                            'type' => new ItemPagoType()
                        )
                    )
//                    ->addModelTransformer( $this->getConfigurationPool()->getContainer()->get('pronit_compras_transformer.itemspagotransformer') ) 
                )
        ; 
        
        $builder = $formMapper->getFormBuilder();
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {

                $form = $event->getForm();

                $ordenPago = $event->getData();

                if ($ordenPago != null) {
                    $i = 0;
                    foreach ($ordenPago->getItemsPago() as $item) {
                        
                        switch (get_class($item)) {
                            case 'Pronit\ComprasBundle\Entity\Documentos\OrdenesPago\ItemPagoEfectivo':

                                $type = new \Pronit\ComprasBundle\Form\Type\EfectivoItemPagoType();
                                $data_class = 'Pronit\ComprasBundle\Entity\Documentos\OrdenesPago\ItemPagoEfectivo';
                                break;
                            case 'Pronit\ComprasBundle\Entity\Documentos\OrdenesPago\ItemPagoTransferenciaBancaria':
                                $type = new \Pronit\ComprasBundle\Form\Type\TransferenciaItemPagoType();
                                $data_class = 'Pronit\ComprasBundle\Entity\Documentos\OrdenesPago\ItemPagoTransferenciaBancaria';
                                break;
                        }
                        
                        $form->get('itemsPago')->add($i, $type, array('data_class' => $data_class, 'compound' => true ));
                        
                        dump( $form->get('itemsPago')->get(0)->getConfig()->getType() );
                          
//                        $form->get('itemsPago')->get(0)->add('importe', 'integer');

                        //die( get_class( $form->getConfig()->getFormFactory() )  );
                        //dump( $form->getConfig()->getFormFactory()->createNamed(0, $type, null, array() ) );
                        $i++;
                    }
                }    
        }, 1);    

        
    }        
    
    public function getFormTheme()
    {
        return array_merge(
            parent::getFormTheme(),
            array('PronitComprasBundle:Documentos\OrdenesPago:ordenpago_admin_theme.html.twig')
        );
    }    
    
    protected function configureSideMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null) 
    {        
        if( $action == "show"){
            
            $admin = $this->isChild() ? $this->getParent() : $this;
            $id = $admin->getRequest()->get('id');

            /* @var $ordenPago \Pronit\ComprasBundle\Entity\Documentos\OrdenesPago\OrdenPago  */            
            $ordenPago = $this->getObject($id);
            
            if( $ordenPago->isModificable() ){
                
                $menu->addChild( 'Contabilizar', array('uri' => $admin->generateUrl('contabilizar', array('id' => $id))) )
                        ->setLinkAttribute('class', 'glyphicon glyphicon-ok');                
            }
        }
    }    
    
    public function isGranted($name, $ordenPago = null)
    {
        /* @var $ordenPago \Pronit\ComprasBundle\Entity\Documentos\OrdenesPago\OrdenPago */            
        
        if (( $name == 'EDIT' ) && ( ! is_null($ordenPago)) ){            
            return $ordenPago->isModificable() && parent::isGranted($name, $ordenPago);
        }else{
            return parent::isGranted($name, $ordenPago);
        }        
    }
    
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('contabilizar', $this->getRouterIdParameter() . '/contabilizar');
    }    
}