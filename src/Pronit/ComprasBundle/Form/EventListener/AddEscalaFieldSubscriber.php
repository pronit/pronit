<?php

namespace Pronit\ComprasBundle\Form\EventListener;

use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones\PresentacionCompra;

class AddEscalaFieldSubscriber implements EventSubscriberInterface
{
    private $formMapper;

    public function __construct(FormMapper $formMapper)
    {
        $this->formMapper = $formMapper;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'onPreSetData',
            FormEvents::PRE_SUBMIT   => 'onPreSubmit',
        );
    }

    public function onPreSetData(FormEvent $event)
    {
        $data = $event->getData();

        if( ! is_null($data) ){

            $item = $data;

            if( $item->getPresentacionCompra()){
                $this->addEscalaFormField( $item->getPresentacionCompra(), $event);
            }
        }
    }

    public function onPreSubmit(FormEvent $event)
    {
        $item = $event->getData();

        $modelManager = $this->formMapper->getAdmin()->getModelManager();

        $qbPC = $modelManager
            ->getEntityManager('Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones\PresentacionCompra')
            ->createQueryBuilder();
        $queryPC = $qbPC
            ->select('pc')
            ->from('Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones\PresentacionCompra', 'pc')
            ->where( 'pc.id = :idPresentacionCompra')
            ->setParameter('idPresentacionCompra', $item['presentacionCompra'] )
            ->getQuery();
        $presentacionCompra = $queryPC->getSingleResult();

        $this->addEscalaFormField($presentacionCompra, $event);
    }

    protected function addEscalaFormField(PresentacionCompra $presentacionCompra, FormEvent $event)
    {
        $formMapper = $this->formMapper;

        /** @var QueryBuilder $qb */
        $qb = $formMapper->getAdmin()->getModelManager()
            ->getEntityManager('Pronit\ParametrizacionGeneralBundle\Entity\Escala')
            ->createQueryBuilder();
        $query = $qb
            ->select('e')
            ->from('Pronit\ParametrizacionGeneralBundle\Entity\Escala', 'e')
            ->join('e.sistemaMedicion', 'sm')
            ->where( 'sm.id = :idSistemaMedicion')
            ->setParameter('idSistemaMedicion', $presentacionCompra->getMaterial()->getSistemaMedicion()->getId() )
            ->getQuery();

        $formOptions = array(
            'auto_initialize'       => false,
            'class'                 => 'Pronit\ParametrizacionGeneralBundle\Entity\Escala',
            'query'                 => $query,
            'label'                 => 'Escala',
            'model_manager'         => $formMapper->getAdmin()->getModelManager()

        );

        $event->getForm()->add( $formMapper->create('escala', 'sonata_type_model', $formOptions)->getForm() );
    }

}