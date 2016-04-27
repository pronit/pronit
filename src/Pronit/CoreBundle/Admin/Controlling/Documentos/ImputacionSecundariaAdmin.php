<?php
namespace Pronit\CoreBundle\Admin\Controlling\Documentos;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Admin\AdminInterface;

use Pronit\CoreBundle\Entity\Controlling\Documentos\ImputacionSecundaria;
use Pronit\CoreBundle\Entity\Documentos\ClaseDocumento;

/**
 *
 * @author ldelia
 */
class ImputacionSecundariaAdmin extends Admin
{   
    protected $baseRouteName = 'pronit_controlling_documentos_imputacionsecundaria';
    
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('numero', null, array('route' => array('name' => 'show')))
            ->add('contabilizado')
            ->add('sociedad')
            ->add('fecha', 'date', array( 'format' => 'd/m/Y' ))
        ;
    }
    
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('Cabecera')
                ->add('numero')
                ->add('contabilizado')
                ->add('sociedad')                
                ->add('fecha', 'date', array( 'format' => 'd/m/Y' ))                                                
                ->add('textoCabecera')
            ->end()      
            ->with('Items Emisores')
                ->add('itemsEmisor', null, 
                        array(
                            'template' => 'PronitCoreBundle:Controlling\Documentos\ImputacionSecundaria\CRUD\show:itemsEmisores.html.twig')
                        )
            ->end()  
            ->with('Items Receptores')
                ->add('itemsReceptor', null, 
                        array(
                            'template' => 'PronitCoreBundle:Controlling\Documentos\ImputacionSecundaria\CRUD\show:itemsReceptores.html.twig')
                        )
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
                            'itemreceptortype', 
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
        if( $action == "show" ){
            
            $admin = $this->isChild() ? $this->getParent() : $this;
            $id = $admin->getRequest()->get('id');
            
            /* @var $imputacionSecundaria \Pronit\CoreBundle\Entity\Controlling\Documentos\ImputacionSecundaria */            
            $imputacionSecundaria = $this->getObject($id);
            
            if(! $imputacionSecundaria->isContabilizado()){
                $menu->addChild( 'Contabilizar', array('uri' => $admin->generateUrl('contabilizar', array('id' => $id))) )
                            ->setLinkAttribute('class', 'glyphicon glyphicon-ok');                
            }
        }
    }    
    
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('contabilizar', $this->getRouterIdParameter() . '/contabilizar');
    }    
    
    public function getNewInstance()
    {
        /* @var $clase \Pronit\CoreBundle\Entity\Documentos\ClaseDocumento  */
        $clase = $this->getModelManager()->find('Pronit\CoreBundle\Entity\Documentos\ClaseDocumento', ClaseDocumento::CODIGO_DISTRIBUCIONSECUNDARIA);        
        
        $documento = new ImputacionSecundaria();
        $documento->setClase($clase);
        
        return $documento;
    }        
}