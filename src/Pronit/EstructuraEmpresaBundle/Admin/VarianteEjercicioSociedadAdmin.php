<?php
namespace Pronit\EstructuraEmpresaBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 *
 * @author ldelia
 */
class VarianteEjercicioSociedadAdmin extends Admin
{
     // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('fechaDesde', 'date')
            ->add('fechaHasta', 'date', array('required' => false))
            ->add('numeroEjercicio', 'integer')
            ->add('varianteEjercicio',null, array('required' => true))
        ;
    }

}


