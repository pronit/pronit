<?php
namespace Pronit\ComprasBundle\Admin\Documentos\EntradasMercancias;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 *
 * @author ldelia
 */
class ItemEntradaMercanciasAdmin extends Admin
{
    protected $parentAssociationMapping = 'documento';
    
     // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        
        $formMapper
            ->add('clasificador', null, array('query_builder' => function(EntityRepository $er) {
                 $qb = $er->createQueryBuilder('c');
                 $qb->where($qb->expr()->in('c.id', 'SELECT cem.id FROM Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\ClasificadorItemEntradaMercancias cem'));
                 return $qb;
            }))
            ->add('bienServicio')
            ->add('escala')                
            ->add('cantidad')
            ->add('precioUnitario')
            ->add('itemPedidoEntregado','sonata_type_model_hidden', array('attr'=> array( 'hidden' => 'true') ))
            ->add('almacen')
            ->add('objetoCosto')
        ;
        
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('bienServicio')                
            ->add('escala')                
            ->add('cantidad')
            ->add('precioUnitario')                
        ;
    }
}


