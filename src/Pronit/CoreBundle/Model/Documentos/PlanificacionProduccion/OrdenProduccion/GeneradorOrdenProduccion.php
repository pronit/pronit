<?php

namespace Pronit\CoreBundle\Model\Documentos\PlanificacionProduccion\OrdenProduccion;

use Doctrine\Common\Collections\ArrayCollection;
use Pronit\CoreBundle\Entity\PlanificacionProduccion\VersionFabricacion;
use Pronit\CoreBundle\Entity\Documentos\ClaseDocumento;
use Pronit\CoreBundle\Entity\Documentos\PlanificacionProduccion\OrdenProduccion\OrdenProduccion;
use Pronit\CoreBundle\Entity\Documentos\PlanificacionProduccion\OrdenProduccion\ItemMaterialDirecto;
use Pronit\CoreBundle\Entity\PlanificacionProduccion\ComponenteInterno;
use Pronit\CoreBundle\Entity\PlanificacionProduccion\ComponenteExterno;

use Doctrine\ORM\EntityManager;


/**
 * @author ldelia
 */
class GeneradorOrdenProduccion
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function generar(VersionFabricacion $versionFabricacion = null)
    {
        /* @var $clase \Pronit\CoreBundle\Entity\Documentos\ClaseDocumento  */
        $clase = $this->em->find('Pronit\CoreBundle\Entity\Documentos\ClaseDocumento', ClaseDocumento::CODIGO_ORDENPRODUCCION);

        $ordenProduccion = new OrdenProduccion();
        $ordenProduccion->setClase($clase);

        if( ! is_null( $versionFabricacion ) ){

            $ordenProduccion->setVersionFabricacion($versionFabricacion);

            foreach ( $this->generarItemsDesdeVersionFabricacion($versionFabricacion) as $item ){
                $ordenProduccion->addItem( $item );
            }
        }

        return $ordenProduccion;
    }

    private function generarItemsDesdeVersionFabricacion(VersionFabricacion $versionFabricacion)
    {
        $items = new ArrayCollection();

        /* @var $componenteExterno ComponenteExterno */
        foreach ( $this->generarItemsDesdeComponentesExternos($versionFabricacion) as $item ){
            $items->add( $item );
        }

        /* @var $componenteInterno ComponenteInterno */
        foreach ( $this->generarItemsDesdeComponentesInternos($versionFabricacion) as $item ){
            $items->add( $item );
        }

        return $items;
    }

    private function generarItemsDesdeComponentesExternos(VersionFabricacion $versionFabricacion)
    {
        $items = new ArrayCollection();

        /* @var $componenteExterno ComponenteExterno */
        foreach ( $versionFabricacion->getListaMateriales()->getComponentesExternos() as $componenteExterno ){
            $itemMaterialDirecto = new ItemMaterialDirecto();
            $itemMaterialDirecto->setMaterial( $componenteExterno->getMaterial() );
            $itemMaterialDirecto->setCantidad( $componenteExterno->getCantidad() );

            $items->add( $itemMaterialDirecto );
        }

        return $items;
    }


    private function generarItemsDesdeComponentesInternos(VersionFabricacion $versionFabricacion)
    {
        $items = new ArrayCollection();

        /* @var $componenteInterno ComponenteInterno */
        foreach ( $versionFabricacion->getListaMateriales()->getComponentesInternos() as $componenteInterno ){

            /* @var $item ItemMaterialDirecto */
            foreach ( $this->generarItemsDesdeVersionFabricacion( $componenteInterno->getVersionFabricacion() ) as $item){

                $item->setCantidad( $item->getCantidad() * $componenteInterno->getCantidad() );

                $items->add($item);
            }
        }

        return $items;
    }
}
