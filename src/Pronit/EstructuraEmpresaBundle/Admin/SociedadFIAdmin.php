<?php
namespace Pronit\EstructuraEmpresaBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
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
            ->with('Datos generales')
                ->add('sociedadGL', 
                        'sonata_type_model_list', 
                        array(
                            'btn_add'       => 'Crear Sociedad GL',
                            'btn_list'      => 'Listar Sociedades GL',
                            'btn_delete'    => false,
                            'btn_catalogue' => 'SonataAdminBundle'
                        ), 
                        array(
                            'placeholder' => 'Ninguna Sociedad GL seleccionada'
                        )
                )
            ->end()
            ->with('Centros Logísticos')
                ->add('centrosLogisticos', 'sonata_type_collection', array('cascade_validation' => true, 'by_reference' => false), array(
                    'edit' => 'inline',
                    'inline' => 'table',                    
                ))
            ->end()
        ;
        
        parent::configureFormFields($formMapper);
    }

}


