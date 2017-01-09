<?php
namespace Pronit\ComprasBundle\Admin\Documentos\Pedidos;

use Doctrine\ORM\QueryBuilder;
use Pronit\ComprasBundle\Entity\Documentos\Pedidos\ItemPedido;
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
    
     // Fields to be shown on create/edit forms
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

        $eventListener = function (FormEvent $event) use ($formMapper) {
            /** @var ItemPedido $item */
            $item = $event->getData();

            // Este evento es invocado 4 veces. Estudiar ciclos.

            if(( ! is_null($item) ) && ( ! is_null($item->getPresentacionCompra())) )
            {
                $modelManager = $formMapper->getAdmin()->getModelManager();

                /** @var QueryBuilder $qb */
                $qb = $modelManager
                    ->getEntityManager('Pronit\ParametrizacionGeneralBundle\Entity\Escala')
                    ->createQueryBuilder();
                $query = $qb
                    ->select('e')
                    ->from('Pronit\ParametrizacionGeneralBundle\Entity\Escala', 'e')
                    ->join('e.sistemaMedicion', 'sm')
                    ->where( 'sm.id = :idSistemaMedicion')
                    ->setParameter('idSistemaMedicion', $item->getPresentacionCompra()->getMaterial()->getSistemaMedicion()->getId() )
                    ->getQuery();

                $formOptions = array(
                    'auto_initialize'       => false,
                    'class'                 => 'Pronit\ParametrizacionGeneralBundle\Entity\Escala',
                    'query'                 => $query,
                    'label'                 => 'Escala',
                    'model_manager'         => $modelManager

                );

                $event->getForm()->add( $formMapper->create('escala', 'sonata_type_model', $formOptions)->getForm() );
            }
        };
        $formMapper->getFormBuilder()->addEventListener(FormEvents::PRE_SET_DATA, $eventListener);

        // TODO continuar leyendo:
        //http://symfony.com/doc/2.8/form/events.html
        //http://symfony.com/doc/current/form/dynamic_form_modification.html#form-events-submitted-data
        //http://stackoverflow.com/questions/26246192/correct-way-to-use-formevents-to-customise-fields-in-sonataadmin#26255708
        //http://stackoverflow.com/questions/16526547/sonata-user-admin-custom-field-dependency#19303524
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


