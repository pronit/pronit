<?php
namespace Pronit\EstructuraEmpresaBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 *
 * @author gcaseres
 */
class MonedaFuerteAdmin extends Admin
{
     // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $today = new \DateTime();
        $years = range(1950, $today->format('Y') + 50);
        
        $formMapper
            ->add('moneda', 'sonata_type_model', array('label' => 'Moneda', 'property' => 'descripcion'))
            ->add('fechaDesde', 'date', array('widget' => 'single_text', 'label' => 'Fecha desde', 'years' => $years))
            ->add('fechaHasta', 'date', array('widget' => 'single_text', 'required' => false, 'label' => 'Fecha hasta', 'years' => $years))
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('moneda')
            ->add('sociedad')
            ->add('fechaDesde')
            ->add('fechaHasta')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('moneda')
            ->add('fechaDesde')
            ->add('fechaHasta')
        ;
    }
}


