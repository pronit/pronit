<?php

namespace Pronit\CoreBundle\Form\Type\PlanificacionProduccion\ListaMateriales;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

class ComponenteExternoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('material');
        $builder->add('cantidad');
        
        $builder->add('_type', 'hidden', array(
            'data'   => $this->getName(),
            'mapped' => false
        ));        
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pronit\CoreBundle\Entity\PlanificacionProduccion\ComponenteExterno',
            'model_class' => 'Pronit\CoreBundle\Entity\PlanificacionProduccion\ComponenteExterno',
        ));        
    }
    
    public function getName()
    {
        return 'componenteexternotype';
    }    
    
}