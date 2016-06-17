<?php
namespace Pronit\CoreBundle\Admin\Documentos\PlanificacionProduccion\OrdenProduccion;

use Pronit\CoreBundle\Entity\Documentos\PlanificacionProduccion\OrdenProduccion\ItemMaterialDirecto;
use Pronit\CoreBundle\Entity\Documentos\PlanificacionProduccion\OrdenProduccion\OrdenProduccion;
use Pronit\CoreBundle\Entity\PlanificacionProduccion\Componente;
use Pronit\CoreBundle\Entity\PlanificacionProduccion\ComponenteExterno;
use Pronit\CoreBundle\Entity\PlanificacionProduccion\VersionFabricacion;
use Pronit\GestionBienesYServiciosBundle\Entity\Material;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Admin\AdminInterface;

use Pronit\CoreBundle\Entity\Documentos\ClaseDocumento;

/**
 *
 * @author ldelia
 */
class OrdenProduccionAdmin extends Admin
{
    protected $baseRouteName = 'pronit_ordenes_produccion';

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('numero', null, array('route' => array('name' => 'show')))
            ->add('fecha', 'date', array( 'format' => 'd/m/Y' ))
            ->add('versionFabricacion')
            ->add('cantidadBase')
            ->add('escala')
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
                            'itemmaterialdirectotype'
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
        /* @var $clase \Pronit\CoreBundle\Entity\Documentos\ClaseDocumento  */
        $clase = $this->getModelManager()->find('Pronit\CoreBundle\Entity\Documentos\ClaseDocumento', ClaseDocumento::CODIGO_ORDENPRODUCCION);

        $ordenProduccion = new OrdenProduccion();
        $ordenProduccion->setClase($clase);

        $versionFabricacion_id = $this->request->query->get('versionFabricacion_id');
        /* @var $versionFabricacion VersionFabricacion */
        $versionFabricacion = $this->getModelManager()->find('Pronit\CoreBundle\Entity\PlanificacionProduccion\VersionFabricacion', $versionFabricacion_id);
        if($versionFabricacion){

            $ordenProduccion->setVersionFabricacion($versionFabricacion);

            /* @var $componenteExterno ComponenteExterno */
            foreach ( $versionFabricacion->getListaMateriales()->getComponentesExternos() as $componenteExterno ){
                $itemMaterialDirecto = new ItemMaterialDirecto();
                $itemMaterialDirecto->setMaterial( $componenteExterno->getMaterial() );

                $ordenProduccion->addItem( $itemMaterialDirecto );
            }
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