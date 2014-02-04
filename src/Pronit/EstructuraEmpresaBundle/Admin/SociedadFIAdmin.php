<?php
namespace Pronit\EstructuraEmpresaBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Description of SociedadFIAdmin
 *
 * @author gcaseres
 */
class SociedadFIAdmin extends SociedadAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('sociedadGL', 'sonata_type_model_list', array(
                    'btn_add'       => 'Crear Sociedad GL',
                    'btn_list'      => 'button.list',
                    'btn_delete'    => false,
                    'btn_catalogue' => 'SonataAdminBundle'
                ), array(
                    'placeholder' => 'Ninguna Sociedad GL seleccionada'
                ))
        ;
        
        parent::configureFormFields($formMapper);
    }

}


