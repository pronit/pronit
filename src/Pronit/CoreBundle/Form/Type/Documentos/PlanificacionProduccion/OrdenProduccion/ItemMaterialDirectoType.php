<?php
namespace Pronit\CoreBundle\Form\Type\Documentos\PlanificacionProduccion\OrdenProduccion;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

class ItemMaterialDirectoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('clasificador', 'entity', array(
                'class' => 'Pronit\CoreBundle\Entity\Documentos\PlanificacionProduccion\OrdenProduccion\ClasificadorItemOrdenProduccion'
            ))
            ->add('material')
            ->add('costoUnitarioML')
            ->add('eficiencia')
            ->add('cantidad')
            ->add('_type', 'hidden', array(
            'data'   => $this->getName(),
            'mapped' => false
        ));        
    }
    
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pronit\CoreBundle\Entity\Documentos\PlanificacionProduccion\OrdenProduccion\ItemMaterialDirecto',
            'model_class' => 'Pronit\CoreBundle\Entity\Documentos\PlanificacionProduccion\OrdenProduccion\ItemMaterialDirecto',
        ));        
    }
    
    public function getName()
    {
        return 'itemmaterialdirectotype';
    }    
    
}