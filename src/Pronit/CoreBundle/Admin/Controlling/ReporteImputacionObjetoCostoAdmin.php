<?php
namespace Pronit\CoreBundle\Admin\Controlling;

use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

/**
 *
 * @author ldelia
 */
class ReporteImputacionObjetoCostoAdmin extends Admin
{

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('fecha', 'date', array( 'format' => 'd/m/Y' ))
            ->add('objetoCosto')                
            ->add('itemDocumento.documento.clase', null, array('label' => 'Clase de Documento'))                                
            ->add('itemDocumento.documento.numero', null, array('label' => 'Número de Documento'))                
            ->add('itemDocumento.posicion', null, array('label' => 'Posición'))                            
            ->add('cuentaContable')                
            ->add('importe', 'currency', array(
                'template' => 'PronitCoreBundle:Controlling/ObjetoCosto:list_importe.html.twig'
            ))

        ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('fecha', 'doctrine_orm_datetime_range', array('field_type'=>'sonata_type_datetime_range_picker'))
            ->add('objetoCosto')                
            ->add('itemDocumento.documento.numero', null, array('label' => 'Número de Documento'))                
            ->add('itemDocumento.documento.clase', null, array('label' => 'Clase de Documento'))                
            ->add('cuentaContable')                

        ;
    }
    
    
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('list', 'export'));
    }    
}


