<?php

namespace Pronit\CoreBundle\Admin\PlanificacionProduccion;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 *
 * @author ldelia
 */
class ListaMaterialesAdmin extends Admin {

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('material')
                ->add('_action', 'actions', array(
                    'actions' => array(
                        'show' => array(),
                        'edit' => array(),
                    ),
                )
                )
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('material')
        ;
    }

    protected function configureFormFields(FormMapper $formMapper) {

        $formMapper
                ->add('material')
                ->add(
                    $formMapper->create('componentes', 'infinite_form_polycollection', array(
                        'types' => array(
                            'componenteexternotype', // The first defined Type becomes the default
                            'componenteinternotype',
                        ),
                        'allow_add' => true,
                        'allow_delete' => true,
                        'by_reference' => false,
                    ))
                )
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
            ->with('Lista de Materiales')
            ->add('material')
            ->end()
            ->with('Componentes Internos')
            ->add('componentesInternos', null, array('template' => 'PronitCoreBundle:PlanificacionProduccion:ListaMateriales\CRUD\show\componentesInternos.html.twig'))
            ->end()
            ->with('Componentes Externos')
            ->add('componentesExternos', null, array('template' => 'PronitCoreBundle:PlanificacionProduccion:ListaMateriales\CRUD\show\componentesExternos.html.twig'))
            ->end()
        ;
    }

    public function getFormTheme()
    {
        return array_merge(
            parent::getFormTheme(),
            array('PronitCoreBundle:PlanificacionProduccion\ListaMateriales:listamateriales_admin_theme.html.twig')
        );
    }
}
