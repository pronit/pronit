<?php

namespace Pronit\CoreBundle\Entity\Almacenamiento\Repository;

use Doctrine\Common\Persistence\ObjectRepository;
use Pronit\CoreBundle\Entity\Almacenamiento\Existencia;
use Pronit\EstructuraEmpresaBundle\Entity\Almacen;
use Pronit\GestionBienesYServiciosBundle\Entity\Material;

/**
 *
 * @author gcaseres
 */
interface IExistenciaRepository extends ObjectRepository {

    function findOneByAlmacenYMaterial(Almacen $almacen, Material $material);

    function add(Existencia $existencia);
}
