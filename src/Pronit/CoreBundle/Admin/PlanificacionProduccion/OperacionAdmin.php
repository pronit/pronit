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
class OperacionAdmin extends Admin {

    protected $parentAssociationMapping = 'hojaRuta';

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('orden','number')
            ->add('descripcion', 'text')
            ->add('cantidad','number')
            ->add('tiempo','number')
        ;
    }
}
