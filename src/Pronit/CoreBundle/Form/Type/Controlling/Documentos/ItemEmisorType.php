<?php

namespace Pronit\CoreBundle\Form\Type\Controlling\Documentos;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;

class ItemEmisorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('clasificador', 'entity', array(
                'class' => 'PronitCoreBundle:Controlling\Documentos\ClasificadorItemImputacionSecundaria',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->where("c.nombre = 'Item emisor'");
                }            
            ))
            ->add('gestionImputacion', 'entity', array(
                'class' => 'PronitCoreBundle:Controlling\GestionImputacion',
            ))
            ->add('importe')
            ->add('_type', 'hidden', array(
                'data'   => $this->getName(),
                'mapped' => false
            ));        
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pronit\CoreBundle\Entity\Controlling\Documentos\ItemEmisor',
        ));        
    }
    
    public function getName() {
        return 'itememisortype';
    }
}