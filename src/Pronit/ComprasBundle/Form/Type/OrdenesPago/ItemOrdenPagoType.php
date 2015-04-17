<?php

namespace Pronit\ComprasBundle\Form\Type\OrdenesPago;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ItemOrdenPagoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('clasificador')
            ->add('importe')
            ->add('gestionMovimientoAcreedor', null, array( 'attr' => array( 'class' => 'gestionMovimientoAcreedor') ) )
            ->add('_type', 'hidden', array(
                'data'   => $this->getName(),
                'mapped' => false
            ))
        ;     
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
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