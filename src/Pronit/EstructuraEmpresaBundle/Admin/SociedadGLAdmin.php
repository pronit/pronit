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
            ->add('sociedadCO', 'sonata_type_model_list', array(
                    'btn_add'       => 'Crear Sociedad CO',      //Specify a custom label
                    'btn_list'      => 'button.list',     //which will be translated
                    'btn_delete'    => false,             //or hide the button.
                    //'btn_catalogue' => 'SonataNewsBundle' //Custom translation domain for buttons
                ), array(
                    'placeholder' => 'Ninguna Sociedad CO seleccionada'
                ))
        ;
        
        parent::configureFormFields($formMapper);
    }
    
 }


