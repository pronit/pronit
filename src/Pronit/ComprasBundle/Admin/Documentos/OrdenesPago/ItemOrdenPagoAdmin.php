<?php
namespace Pronit\ComprasBundle\Admin\Documentos\OrdenesPago;

use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Form\FormMapper;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

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
            ->add('importe')
            ->add('gestionMovimientoAcreedor')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('clasificador')
            ->add('importe')
            ->add('gestionMovimientoAcreedor')
        ;
    }
    
    public function getFormTheme()
    {
        return array_merge(
            parent::getFormTheme(),
            array('PronitComprasBundle:Documentos\ItemOrdenPago:itemordenpago_admin_theme.html.twig')
        );
    }    
    
}


