<?php

namespace Pronit\CoreBundle\Model\Almacenamiento;

use Exception;
use Pronit\CoreBundle\Entity\Almacenamiento\Existencia;
use Pronit\CoreBundle\Entity\Almacenamiento\Repository\IExistenciaRepository;
use Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones\PresentacionVenta;
use Pronit\EstructuraEmpresaBundle\Entity\Almacen;
use Pronit\GestionBienesYServiciosBundle\Entity\Material;
use Pronit\ParametrizacionGeneralBundle\Entity\Escala;

/**
 *
 * @author gcaseres
 */
class ServicioAlmacenamiento implements IServicioAlmacenamiento {

    /**
     *
     * @var IExistenciaRepository
     */
    private $existenciaRepository;

    public function __construct(IExistenciaRepository $existenciaRepository) {
        $this->existenciaRepository = $existenciaRepository;
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function modificarExistencias(PresentacionVenta $presentacion, Cantidades $cantidades) {
        $unidades = $presentacion->getUnidades();

        foreach ($unidades as /* @var $unidad Escala */ $unidad) {
            if (!$cantidades->has($unidad->getSistemaMedicion())) {
                throw new Exception(sprintf(
                        'No se puede modificar las existencias de la presentacion %s con las cantidades especificadas: \'%s\'. Verifique que los sistemas de medición se corresponden.', (string) $presentacion, (string) $cantidades
                ));
            }
        }

        if ($cantidades->count() !== $unidades->count()) {
            throw new Exception(sprintf(
                    'No se puede modificar las existencias de la presentacion %s con las cantidades especificadas: \'%s\'. Verifique que los sistemas de medición se corresponden.', (string) $presentacion, (string) $cantidades
            ));
        }
        
        /* @var $existencia Existencia */
        $existencia = $this->existenciaRepository->findByMaterial($presentacion->getMaterial());
        foreach ($unidades as /* @var $unidad Escala */ $unidad) {
            $actual = $existencia->getCantidad($presentacion, $unidad);
            
            /* @var $cantidad Cantidad */
            $cantidad = $cantidades->get($unidad->getSistemaMedicion())->escalar($unidad);
            
            $existencia->setCantidad($presentacion, $actual + $cantidad->getValor(), $unidad);
        }
        
        
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function configurar(Material $material, Almacen $almacen) {
        $existencia = $this->existenciaRepository->findByMaterial($material);

        if ($existencia === null) {
            $existencia = new Existencia($almacen, $material);
        }

        foreach ($material->getPresentacionesVenta() as /* @var $presentacionVenta PresentacionVenta */ $presentacionVenta) {
            $escalas = array();
            foreach ($presentacionVenta->getUnidades() as $escala) {
                $escalas[] = $escala;
            }

            $existencia->addPresentacion($presentacionVenta, $escalas);
        }


        $this->existenciaRepository->add($existencia);
    }

}
