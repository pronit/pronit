<?php

namespace Pronit\CustomizingBundle\Admin\Operaciones;

use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 *
 * @author gcaseres
 */
class MappingClasificadorItemOperacionAdmin extends Admin {

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('clasificador')
                ->add('operacion')
                ->add('funcion')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('clasificador')
                ->add('operacion')
                ->add('funcion')
        ;
    }

    protected function configureFormFields(FormMapper $formMapper) {

        $formMapper
                ->add('clasificador')
                ->add('operacion')
                ->add('funcion')
        ;
    }

}
