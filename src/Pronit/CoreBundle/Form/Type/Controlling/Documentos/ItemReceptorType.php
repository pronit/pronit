<?php

namespace Pronit\CoreBundle\Form\Type\Controlling\Documentos;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;

class ItemReceptorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('clasificador', 'entity', array(
            'class' => 'PronitCoreBundle:Controlling\Documentos\ClasificadorItemImputacionSecundaria',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('c')
                    ->where("c.nombre = 'Item receptor'");
            }
        ));                
        $builder->add('objetoCosto', 'entity', array(
            'class' => 'Pronit\CoreBundle\Entity\Controlling\ObjetoCosto'
        ));
        $builder->add('importe');
        
        $builder->add('_type', 'hidden', array(
            'data'   => $this->getName(),
            'mapped' => false
        ));        
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pronit\CoreBundle\Entity\Controlling\Documentos\ItemReceptor',
        ));        
    }
    
    public function getName() {
        return 'itemreceptortype';
    }
}