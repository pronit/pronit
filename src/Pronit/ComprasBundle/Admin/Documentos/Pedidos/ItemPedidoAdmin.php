<?php
namespace Pronit\ComprasBundle\Admin\Documentos\Pedidos;

use Doctrine\ORM\QueryBuilder;
use Pronit\ComprasBundle\Entity\Documentos\Pedidos\ItemPedido;
use Pronit\ComprasBundle\Form\EventListener\AddEscalaFieldSubscriber;
use Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones\PresentacionCompra;
use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


/**
 *
 * @author ldelia
 */
class ItemPedidoAdmin extends Admin
{
    protected $parentAssociationMapping = 'documento';

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('clasificador', null, array('query_builder' => function(EntityRepository $er) {
                $qb = $er->createQueryBuilder('c');
                $qb->where($qb->expr()->in('c.id', 'SELECT cip.id FROM Pronit\ComprasBundle\Entity\Documentos\Pedidos\ClasificadorItemPedido cip'));
                return $qb;
            }))
            ->add('presentacionCompra',
                null,
                array(
                    'label' => 'Presentación',
                    'attr' => array(
                        'class' => 'presentacionCompraField'
                    )
                ))
            ->add('escala') // lo dejo acá solo para ubicarlo en la posición correspondiente. Se sobreescribe en el evento
            ->add('cantidad')
            ->add('precioUnitario')
            ->add('almacen')
            ->add('objetoCosto')    
        ;
        $formMapper->getFormBuilder()->addEventSubscriber( new AddEscalaFieldSubscriber($formMapper));
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

    public function getFormTheme()
    {
        return array_merge(
            parent::getFormTheme(), array(
                'PronitComprasBundle:Documentos\Pedido\CRUD:formtheme.html.twig')
        );
    }

}


