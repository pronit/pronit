<?php

namespace Pronit\CoreBundle\Form\Type\PlanificacionProduccion\ListaMateriales;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

class ComponenteInternoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('versionFabricacion');
        $builder->add('cantidad');
        
        $builder->add('_type', 'hidden', array(
            'data'   => $this->getName(),
            'mapped' => false
        ));        
    }
    
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pronit\CoreBundle\Entity\PlanificacionProduccion\ComponenteInterno',
            'model_class' => 'Pronit\CoreBundle\Entity\PlanificacionProduccion\ComponenteInterno',
        ));        
    }
    
    public function getName()
    {
        return 'componenteinternotype';
    }    
    
}