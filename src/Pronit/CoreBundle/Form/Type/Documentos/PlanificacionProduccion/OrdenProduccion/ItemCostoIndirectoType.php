<?php
namespace Pronit\CoreBundle\Form\Type\Documentos\PlanificacionProduccion\OrdenProduccion;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

class ItemCostoIndirectoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('clasificador', 'entity', array(
                'class' => 'Pronit\CoreBundle\Entity\Documentos\PlanificacionProduccion\OrdenProduccion\ClasificadorItemOrdenProduccion'
            ))
            ->add('material')
            ->add('costoImputado')
            ->add('porcentaje')
            ->add('objetoCosto')
            ->add('_type', 'hidden', array(
            'data'   => $this->getName(),
            'mapped' => false
        ));        
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pronit\CoreBundle\Entity\Documentos\PlanificacionProduccion\OrdenProduccion\ItemCostoIndirecto',
            'model_class' => 'Pronit\CoreBundle\Entity\Documentos\PlanificacionProduccion\OrdenProduccion\ItemCostoIndirecto',
        ));        
    }
    
    public function getName()
    {
        return 'itemcostoindirectotype';
    }    
    
}