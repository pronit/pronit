<?php

namespace Pronit\CoreBundle\Admin\Impuestos;

use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 *
 * @author gcaseres
 */
class IndicadorImpuestosAdmin extends Admin {

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('codigo', null, array('route' => array('name' => 'show')))
                ->add('nombre')
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
                ->add('codigo')
                ->add('nombre')
        ;
    }

    protected function configureFormFields(FormMapper $formMapper) {

        $formMapper
                ->with('Indicador de impuestos', array('class' => 'col-md-6'))->end()
                ->with('Items', array('class' => 'col-md-12'))->end()
        ;

        $formMapper
                ->with('Indicador de impuestos')
                ->add('codigo')
                ->add('nombre')
                ->end()
                ->with('Items')
                ->add('items', 'sonata_type_collection', array(
                    'cascade_validation' => true,
                    'by_reference' => false,
                        ), array(
                    'edit' => 'inline',
                    'inline' => 'table',
                    'admin_code' => 'pronit.admin.core.impuestos.itemindicadorimpuestos'
                        )
                )
                ->end()
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->with('Indicador de impuestos')
                ->add('codigo')
                ->add('nombre')
                ->end()
                ->with('Items')
                ->add('items', null, array('template' => 'PronitCoreBundle:Impuestos:items.html.twig'))
                ->end()

        ;
    }

}
