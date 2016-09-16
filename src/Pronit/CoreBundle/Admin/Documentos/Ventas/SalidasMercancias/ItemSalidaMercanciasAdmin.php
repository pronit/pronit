<?php
namespace Pronit\CoreBundle\Admin\Documentos\Ventas\SalidasMercancias;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 *
 * @author ldelia
 */
class ItemSalidaMercanciasAdmin extends Admin
{
    protected $parentAssociationMapping = 'documento';
    
     // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        
        $formMapper
            ->add('clasificador', null, array('query_builder' => function(EntityRepository $er) {
                 $qb = $er->createQueryBuilder('c');
                 $qb->where($qb->expr()->in('c.id', 'SELECT cem.id FROM Pronit\CoreBundle\Entity\Documentos\Ventas\SalidasMercancias\ClasificadorItemSalidaMercancias cem'));
                 return $qb;
            }))
            ->add('bienServicio')
            ->add('escala')                
            ->add('cantidad')
            ->add('precioUnitario')
            ->add('itemPedidoEntregado','sonata_type_model_hidden', array('attr'=> array( 'hidden' => 'true') ))
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


