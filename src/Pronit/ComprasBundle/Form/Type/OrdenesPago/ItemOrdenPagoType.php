<?php

namespace Pronit\ComprasBundle\Form\Type\OrdenesPago;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ItemOrdenPagoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('clasificador', null, array('query_builder' => function(EntityRepository $er) {
                $qb = $er->createQueryBuilder('c');
                $qb->where($qb->expr()->in('c.id', 'SELECT ciop.id FROM Pronit\ComprasBundle\Entity\Documentos\OrdenesPago\ClasificadorItemOrdenPago ciop'));
                return $qb;
            }))
            ->add('importe')
            ->add('gestionMovimientoAcreedor', null, array( 'attr' => array( 'class' => 'gestionMovimientoAcreedor') ) )
            ->add('_type', 'hidden', array(
                'data'   => $this->getName(),
                'mapped' => false
            ))
        ;     
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pronit\ComprasBundle\Entity\Documentos\OrdenesPago\ItemOrdenPago',
        ));        
    }

    public function getName()
    {
        return 'itemordenpagotype';
    }
    

}