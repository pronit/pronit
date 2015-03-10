<?php

namespace Pronit\ComprasBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;

class ItemPagoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pronit\ComprasBundle\Entity\Documentos\OrdenesPago\ItemPago',
        ));        
    }

    public function getName()
    {
        return 'itempago';
    }
    

}