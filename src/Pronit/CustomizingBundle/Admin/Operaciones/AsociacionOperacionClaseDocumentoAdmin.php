<?php

namespace Pronit\CustomizingBundle\Admin\Operaciones;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 *
 * @author gcaseres
 */
class AsociacionOperacionClaseDocumentoAdmin extends Admin {
  
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('claseDocumento')
                ->add('operacion')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('claseDocumento')
                ->add('operacion')
        ;
    }

    protected function configureFormFields(FormMapper $formMapper) {

        $formMapper
                ->add('claseDocumento')
                ->add('operacion')
        ;
    }

}
