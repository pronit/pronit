<?php
namespace Pronit\CoreBundle\Admin\Documentos\PlanificacionProduccion\OrdenProduccion;

use Pronit\CoreBundle\Entity\Documentos\PlanificacionProduccion\OrdenProduccion\ItemMaterialDirecto;
use Pronit\CoreBundle\Entity\Documentos\PlanificacionProduccion\OrdenProduccion\OrdenProduccion;
use Pronit\CoreBundle\Entity\PlanificacionProduccion\Componente;
use Pronit\CoreBundle\Entity\PlanificacionProduccion\ComponenteExterno;
use Pronit\CoreBundle\Entity\PlanificacionProduccion\ComponenteInterno;
use Pronit\CoreBundle\Entity\PlanificacionProduccion\VersionFabricacion;
use Pronit\GestionBienesYServiciosBundle\Entity\Material;
use Pronit\CoreBundle\Entity\Documentos\ClaseDocumento;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Admin\AdminInterface;


/**
 *
 * @author ldelia
 */
class OrdenProduccionAdmin extends Admin
{
    protected $baseRouteName = 'pronit_ordenes_produccion';

    /*
     * TODO realizar el show de la Orden de Producción
     */

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('numero', null, array('route' => array('name' => 'show')))
            ->add('fecha', 'date', array( 'format' => 'd/m/Y' ))
            ->add('versionFabricacion')
            ->add('cantidadBase')
            ->add('escala')
            ->add('_action', 'actions', array(
                    'actions' => array(
                        'show' => array(),
                        'edit' => array(),
                    ),
                )
            )
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('Orden de Producción')
                ->add('numero')
                ->add('sociedad')
                ->add('fecha', 'date', array( 'format' => 'd/m/Y' ))
            ->end()
            ->with('Cabecera')
                ->add('versionFabricacion')
                ->add('cantidadBase')
                ->add('escala')
                ->add('textoCabecera')
            ->end()
            ->with('Items Material Directo')
               ->add('itemsMaterialDirecto', null, array('template' => 'PronitCoreBundle:Documentos\PlanificacionProduccion\OrdenProduccion\CRUD\show:itemsMaterialDirecto.html.twig'))
            ->end()
            ->with('Items Costo Indirecto')
                ->add('itemsCostoIndirecto', null, array('template' => 'PronitCoreBundle:Documentos\PlanificacionProduccion\OrdenProduccion\CRUD\show:itemsCostoIndirecto.html.twig'))
            ->end()
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Orden de Producción', array('class' => 'col-md-6'))->end()
            ->with('Cabecera', array('class' => 'col-md-6'))->end()
            ->with('Items', array('class' => 'col-md-12') )->end()
        ;

        $formMapper
            ->with('Orden de Producción')
                ->add('numero')
                ->add('sociedad')
                ->add('fecha', 'date', array('widget' => 'single_text'))
            ->end()
            ->with('Cabecera')
                ->add('versionFabricacion')
                ->add('cantidadBase')
                ->add('escala')
                ->add('textoCabecera')
            ->end()
            ->with('Items')
                ->add(
                    $formMapper->create('items', 'infinite_form_polycollection', array(
                        'types' => array(
                            'itemmaterialdirectotype',
                            'itemcostoindirectotype'
                        ),
                        'allow_add' => true,
                        'allow_delete' => true,
                        'by_reference' => false,
                    ))
                )
            ->end()
        ;
    }

    public function getNewInstance()
    {
        $generadorOrdenProduccion = $this->getConfigurationPool()->getContainer()
                                    ->get('pronit_documentos_planificacionproduccion.ordenproduccion.generador_orden_produccion');

        $versionFabricacion_id = $this->request->query->get('versionFabricacion_id');

        if( ! is_null($versionFabricacion_id)){

            /* @var $versionFabricacion VersionFabricacion */
            $versionFabricacion = $this->getModelManager()->find('Pronit\CoreBundle\Entity\PlanificacionProduccion\VersionFabricacion', $versionFabricacion_id);
            $ordenProduccion = $generadorOrdenProduccion->generar( $versionFabricacion );
        }else{
            $ordenProduccion = $generadorOrdenProduccion->generar();
        }
        return $ordenProduccion;
    }


    public function getFormTheme()
    {
        return array_merge(
            parent::getFormTheme(),
            array('PronitCoreBundle:Documentos\PlanificacionProduccion\OrdenProduccion:ordenproduccion_admin_theme.html.twig')
        );
    }
}