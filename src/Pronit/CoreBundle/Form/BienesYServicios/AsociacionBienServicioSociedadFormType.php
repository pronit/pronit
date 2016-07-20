<?php

namespace Pronit\CoreBundle\Form\BienesYServicios;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of AsociacionBienServicioSociedadFormType
 *
 * @author gcaseres
 */
class AsociacionBienServicioSociedadFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('sociedadFI', 'entity', array('class' => 'Pronit\EstructuraEmpresaBundle\Entity\SociedadFI'))
                ->add('bienServicio', 'entity', array('class' => 'Pronit\GestionBienesYServiciosBundle\Entity\BienServicio'))
                ->add('codigo')
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {

        $resolver->setDefaults(array(
            'data_class' => '\ArrayObject'
            //'data_class' => 'Pronit\CoreBundle\Model\BienesYServicios\AsociacionBienServicioSociedad'
        ));

    }

    public function getName() {
        return 'asociacionbienserviciosociedadform';
    }

}
