<?php

namespace Pronit\ComprasBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;

class EfectivoItemPagoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('importe');
        $builder->add('cuenta');
        
        $builder->add('_type', 'hidden', array(
            'data'   => $this->getName(),
            'mapped' => false
        ));        
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pronit\ComprasBundle\Entity\Documentos\OrdenesPago\ItemPagoEfectivo',
            'model_class' => 'Pronit\ComprasBundle\Entity\Documentos\OrdenesPago\ItemPagoEfectivo',
        ));        
    }
    
    public function getName() {
        return 'itempagoefectivotype';
    }
}