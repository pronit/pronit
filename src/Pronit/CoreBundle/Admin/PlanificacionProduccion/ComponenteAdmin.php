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
class ComponenteAdmin extends Admin {

    protected $parentAssociationMapping = 'listaMateriales';

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('material')
            ->add('cantidad')
        ;
    }
}
