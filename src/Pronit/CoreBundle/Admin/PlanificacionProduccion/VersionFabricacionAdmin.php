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
class VersionFabricacionAdmin extends Admin {

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('nombre')
                ->add('listaMateriales')
                ->add('hojaRuta')
                ->add('_action', 'actions', array(
                    'actions' => array(
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

}
