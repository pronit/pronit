<?php

namespace Pronit\CoreBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

class RefreshableTypeExtension extends AbstractTypeExtension
{
    public function getExtendedType()
    {
        return ChoiceType::class;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined(array('refresh_route'));
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if (isset($options['refresh_route'])) {

            $view->vars['refresh_route'] = $options['refresh_route'];
        }
    }
}