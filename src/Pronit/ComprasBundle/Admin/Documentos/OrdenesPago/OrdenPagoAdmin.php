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


use Pronit\ComprasBundle\Form\Type\OrdenesPago\ItemType;

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
            ->with('Items')
                ->add('items', null, array('template' => 'PronitComprasBundle:Documentos\OrdenPago\show:items.html.twig'))
            ->end()  
            // todo mostrar pagos
        ;
    }    
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        if ($this->id($this->getSubject())) {
            $editView = true;
        }
        else {
            $editView = false;
        }        
                
        $formMapper
            ->with('Orden de Pago', array('class' => 'col-md-6'))->end()
            ->with('Cabecera', array('class' => 'col-md-6'))->end()
        ;   
        
        $formMapper
            ->with('Orden de Pago')
                ->add('numero')
                ->add('sociedad')
                ->add('fecha', 'date', array('widget' => 'single_text'))                                                
            ->end()
            ->with('Cabecera')
                ->add('proveedorSociedad', null, array('label'=>'Proveedor', 'disabled' => $editView ) )
                ->add('moneda')
                ->add('textoCabecera')
            ->end()
            ->with('Items')
                ->add(                         
                    $formMapper->create('items', 'infinite_form_polycollection', array(
                        'types' => array(
                            'itemordenpagotype', 
                        ),
                        'allow_add' => true,
                        'allow_delete' => true,
                        'by_reference' => false,
                    ))
                )                
            ->end()                    
            ->with('Pagos')
                ->add(                         
                    $formMapper->create('itemsPago', 'infinite_form_polycollection', array(
                        'types' => array(
                            'itempagoefectivotype', // The first defined Type becomes the default
                            'itempagotransferenciabancariatype',
                        ),
                        'allow_add' => true,
                        'allow_delete' => true,
                        'by_reference' => false,
                    ))
                )
        ; 
        
        if( $editView ){
        $builder = $formMapper->getFormBuilder();
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            
//            $ordenPago = $event->getData();
            $form = $event->getForm();

            //dump( $form->get('items') );
            //die('lycho');
        });                
            
        }
        
    }        
    
    public function getFormTheme()
    {
        return array_merge(
            parent::getFormTheme(),
            array('PronitComprasBundle:Documentos\OrdenPago:ordenpago_admin_theme.html.twig')
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
        $collection->add('renderGestionMovimientoList', $this->getRouterIdParameter() . '/renderGestionMovimientoList');        
    }    
}