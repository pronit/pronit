<?php
namespace Pronit\ComprasBundle\Admin\Documentos\OrdenesPago;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 *
 * @author ldelia
 */
class ItemOrdenPagoAdmin extends Admin
{
    protected $parentAssociationMapping = 'documento';
    
     // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('clasificador')
            ->add('gestionMovimiento')
        ;
        
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('clasificador')
            ->add('gestionMovimiento')
        ;
    }
}


