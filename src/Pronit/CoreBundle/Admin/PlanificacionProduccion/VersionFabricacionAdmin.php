<?php

namespace Pronit\CoreBundle\Admin\PlanificacionProduccion;

use Pronit\CoreBundle\Entity\PlanificacionProduccion\VersionFabricacion;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Admin\AdminInterface;
use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Route\RouteCollection;

/**
 *
 * @author ldelia
 */
class VersionFabricacionAdmin extends Admin
{
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('nombre')
                ->add('listaMateriales')
                ->add('hojaRuta')
                ->add('_action', 'actions', array(
                        'actions' => array(
                            'show' => array(),
                            'edit' => array(),
                            'crearOrdenProduccionDesdeVersionFabricacion' => array(
                               // 'template' => 'PronitCoreBundle:PlanificacionProduccion\VersionFabricacion\CRUD\show:itemsMaterialDirecto.html.twig'
                                'template' => 'PronitCoreBundle:PlanificacionProduccion\VersionFabricacion\CRUD\list:action_crear_orden_produccion.html.twig'
                            )
                        ),
                    )
                )
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('nombre')
        ;
    }

    protected function configureFormFields(FormMapper $formMapper) {

        $formMapper
                ->add('nombre')
                ->add('listaMateriales')
                ->add('hojaRuta')
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('nombre')
                ->add('listaMateriales')
                ->add('hojaRuta')

        ;
    }

    protected function configureSideMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null)
    {
        if( $action == "show"){

            $admin = $this->isChild() ? $this->getParent() : $this;
            $id = $admin->getRequest()->get('id');

            $menu->addChild( 'Crear Orden de Producción', array('uri' => $admin->generateUrl('crearOrdenProduccionDesdeVersionFabricacion', array('id' => $id))) )
                ->setLinkAttribute('class', 'fa fa-rocket');
        }
    }


    protected function configureRoutes(RouteCollection $collection)
    {   $collection->add('crearOrdenProduccionDesdeVersionFabricacion', $this->getRouterIdParameter() . '/crearOrdenProduccion');
    }
}
