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
class HojaRutaAdmin extends Admin {

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('nombre', null, array('route' => array('name' => 'show')))
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
                ->add('nombre')
        ;
    }

    protected function configureFormFields(FormMapper $formMapper) {

        $formMapper
                ->add('nombre')
                ->add('operaciones', 'sonata_type_collection', array('by_reference' => false), array(
                    'edit' => 'inline',
                    'inline' => 'table'
                ))
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->with('Hoja de Ruta')
                    ->add('nombre')
                ->end()
                ->with('Operaciones')
                    ->add('operaciones', null, array('template' => 'PronitCoreBundle:PlanificacionProduccion:HojaRuta\items.html.twig'))
                ->end()


        ;
    }

}
