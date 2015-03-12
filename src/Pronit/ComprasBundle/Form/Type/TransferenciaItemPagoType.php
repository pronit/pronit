<?php

namespace Pronit\ComprasBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

class TransferenciaItemPagoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //die('test');
        $builder->add('importe');
        $builder->add('cuenta');        
        
        $builder->add('cuentaBancaria');
        $builder->add('_type', 'hidden', array(
            'data'   => $this->getName(),
            'mapped' => false
        ));        
    }
    
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pronit\ComprasBundle\Entity\Documentos\OrdenesPago\ItemPagoTransferenciaBancaria',
            'model_class' => 'Pronit\ComprasBundle\Entity\Documentos\OrdenesPago\ItemPagoTransferenciaBancaria',
        ));        
    }
    
    public function getName()
    {
        return 'itempagotransferenciabancariatype';
    }    
    
}