<?php

namespace Pronit\CoreBundle\Entity\Almacenamiento;

use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones\PresentacionVenta;
use Pronit\EstructuraEmpresaBundle\Entity\Almacen;
use Pronit\GestionBienesYServiciosBundle\Entity\Material;
use Pronit\ParametrizacionGeneralBundle\Entity\Escala;

/**
 * Description of Existencia
 *
 * @author gcaseres
 */
class Existencia {

    /**
     *
     * @var Almacen
     */
    private $almacen;

    /**
     *
     * @var Material
     */
    private $material;

    /**
     *
     * @var ArrayCollection
     */
    private $presentaciones;

    public function __construct(Almacen $almacen, Material $material) {
        $this->material = $material;
        $this->almacen = $almacen;
        $this->presentaciones = new ArrayCollection();
    }

    public function addPresentacion(PresentacionVenta $presentacionVenta, array $escalas) {
        $presentacionExistencia = new PresentacionExistencia($this, $presentacionVenta);
        foreach ($escalas as $escala) {
            $presentacionExistencia->addCantidad(0, $escala);
        }

        $this->presentaciones->add($presentacionExistencia);
    }

    public function setCantidad(PresentacionVenta $presentacionVenta, $valor, Escala $escala) {
        foreach ($this->presentaciones as /* @var $presentacion PresentacionExistencia */ $presentacion) {
            if ($presentacion->getPresentacionVenta() === $presentacionVenta) {
                $presentacion->setCantidad($valor, $escala);
                return;
            }
        }

        throw new Exception('La presentación especificada no está configurada en esta existencia.');
    }

    /**
     * 
     * @param PresentacionVenta $presentacionVenta
     * @param Escala $escala
     * @return float
     * @throws Exception
     */
    public function getCantidad(PresentacionVenta $presentacionVenta, Escala $escala) {
        foreach ($this->presentaciones as /* @var $presentacion PresentacionExistencia */ $presentacion) {
            if ($presentacion->getPresentacionVenta() === $presentacionVenta) {
                return $presentacion->getCantidad($escala);                
            }
        }

        throw new Exception('La presentación especificada no está configurada en esta existencia.');
    }    
}
