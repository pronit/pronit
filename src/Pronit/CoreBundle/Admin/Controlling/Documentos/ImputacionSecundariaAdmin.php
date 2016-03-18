<?php
namespace Pronit\CoreBundle\Admin\Controlling\Documentos;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Admin\AdminInterface;


use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

/**
 *
 * @author ldelia
 */
class ImputacionSecundariaAdmin extends Admin
{   
    protected $baseRouteName = 'pronit_controlling_imputacionsecundaria';
    
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('numero', null, array('route' => array('name' => 'show')))
            ->add('sociedad')
            ->add('fecha', 'date', array( 'format' => 'd/m/Y' ))
        ;
    }
    
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('Cabecera')
                ->add('numero')
                ->add('sociedad')                
                ->add('fecha', 'date', array( 'format' => 'd/m/Y' ))                                                
                ->add('textoCabecera')
            ->end()      
            ->with('Items')
                ->add('items', null, array('template' => 'PronitCoreBundle:Controlling\Documentos\ImputacionSecundaria\CRUD\show:items.html.twig'))
            ->end()  

        ;
    }        
    
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Imputación Secundaria', array('class' => 'col-md-6'))->end()
            ->with('Cabecera', array('class' => 'col-md-6'))->end()
        ;   
        
        $formMapper
            ->with('Imputación Secundaria')
                ->add('numero')
                ->add('sociedad')                                    
            ->end()
            ->with('Cabecera')
                ->add('fecha', 'date', array('widget' => 'single_text'))                                            
                ->add('textoCabecera')
            ->end()
            ->with('Items')
                ->add(                         
                    $formMapper->create('items', 'infinite_form_polycollection', array(
                        'types' => array(
                            'itememisortype', 
                        ),
                        'allow_add' => true,
                        'allow_delete' => true,
                        'by_reference' => false,
                    ))
                )                
            ->end()                    
        ; 
    }        
    
    public function getFormTheme()
    {
        return array_merge(
            parent::getFormTheme(),
            array('PronitCoreBundle:Controlling\Documentos\ImputacionSecundaria:imputacionsecundaria_admin_theme.html.twig')
        );
    }    
    
    protected function configureSideMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null) 
    {        
        if( $action == "show"){
            
            $admin = $this->isChild() ? $this->getParent() : $this;
            $id = $admin->getRequest()->get('id');

            $menu->addChild( 'Contabilizar', array('uri' => $admin->generateUrl('contabilizar', array('id' => $id))) )
                        ->setLinkAttribute('class', 'glyphicon glyphicon-ok');                
        }
    }    
    
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('contabilizar', $this->getRouterIdParameter() . '/contabilizar');
    }    
}