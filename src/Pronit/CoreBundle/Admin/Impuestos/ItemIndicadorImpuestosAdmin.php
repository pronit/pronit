<?php
namespace Pronit\CoreBundle\Admin\Impuestos;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 *
 * @author ldelia
 */
class ItemIndicadorImpuestosAdmin extends Admin
{
    protected $parentAssociationMapping = 'indicadorImpuestos';
    
     // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        
        $formMapper
            ->add('operacionContable')
            ->add('alicuota')            
        ;
        
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('operacionContable')
            ->add('alicuota')                  
        ;
    }
    
    
}


