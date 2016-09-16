<?php
namespace Pronit\ComprasBundle\Admin\Documentos\Pedidos;

use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 *
 * @author ldelia
 */
class ItemPedidoAdmin extends Admin
{
    protected $parentAssociationMapping = 'documento';
    
     // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('clasificador', null, array('query_builder' => function(EntityRepository $er) {
                $qb = $er->createQueryBuilder('c');
                $qb->where($qb->expr()->in('c.id', 'SELECT cip.id FROM Pronit\ComprasBundle\Entity\Documentos\Pedidos\ClasificadorItemPedido cip'));
                return $qb;
            }))
            ->add('presentacionCompra')
            ->add('escala')                
            ->add('cantidad')
            ->add('precioUnitario')
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
    
    protected function configureShowFields(ShowMapper $showMapper)
    {
        // Here we set the fields of the ShowMapper variable, $showMapper (but this can be called anything)
        $showMapper
            ->add('bienServicio')                
            ->add('escala')                
            ->add('cantidad')
            ->add('precioUnitario')
        ;
    }    
    
}


