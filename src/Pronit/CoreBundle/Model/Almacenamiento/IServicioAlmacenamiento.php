<?php

namespace Pronit\CoreBundle\Model\Almacenamiento;

use Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones\PresentacionVenta;
use Pronit\EstructuraEmpresaBundle\Entity\Almacen;
use Pronit\GestionBienesYServiciosBundle\Entity\Material;

/**
 *
 * @author gcaseres
 */
interface IServicioAlmacenamiento {

    /**
     * Mecanismo estándar para la modificación de stock.
     * 
     * Modifica las existencias de una presentación.
     * 
     * @param PresentacionVenta $presentacion
     * @param Cantidades $cantidades
     */
    function modificarExistencias(PresentacionVenta $presentacion, Cantidades $cantidades);
    
    /**
     * Configura la estructura de control de stock para un material.
     * 
     * @param Material $material
     * @param Almacen $almacen
     */
    function configurar(Material $material, Almacen $almacen);
}
