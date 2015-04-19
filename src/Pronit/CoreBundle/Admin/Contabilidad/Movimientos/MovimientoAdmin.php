<?php
namespace Pronit\CoreBundle\Admin\Contabilidad\Movimientos;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

/**
 *
 * @author ldelia
 */
class MovimientoAdmin extends Admin
{

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('fecha', 'date', array( 'format' => 'd/m/Y' ))
            ->add('asiento')                
            ->add('descripcion')                
            ->add('cuenta')                
            ->add('debe', 'float', array('template' => 'PronitCoreBundle:Movimientos:partial_debe.html.twig'))
            ->add('haber', 'float', array('template' => 'PronitCoreBundle:Movimientos:partial_haber.html.twig'))
        ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('asiento')                             
            ->add('cuenta')                             
        ;
    }
    
    
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('list', 'export'));
    }    
}


