<?php
namespace Pronit\EstructuraEmpresaBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 *
 * @author ldelia
 */
class SociedadGLAdmin extends SociedadAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Datos generales')
            ->add('sociedadCO', 'sonata_type_model_list', array(
                    'btn_add'       => 'Crear Sociedad CO',
                    'btn_list'      => 'button.list',
                    'btn_delete'    => false,
                    'btn_catalogue' => 'SonataAdminBundle'
                ), array(
                    'placeholder' => 'Ninguna Sociedad CO seleccionada'
                ))
        ;
        
        parent::configureFormFields($formMapper);
    }
    
 }


