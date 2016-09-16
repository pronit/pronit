<?php

namespace Pronit\CoreBundle\Admin\Operaciones;

use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 *
 * @author gcaseres
 */
class OperacionContableAdmin extends Admin {

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
                ->add('codigo')
                ->add('nombre')
                ->add('contextosAceptados')
                ->add('gestionaPartidasAbiertas')
                ->add('claveContabilizacion')
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('codigo')
                ->add('nombre')
                ->add('contextosAceptados')
                ->add('gestionaPartidasAbiertas')
                ->add('claveContabilizacion')
        ;
    }

}
