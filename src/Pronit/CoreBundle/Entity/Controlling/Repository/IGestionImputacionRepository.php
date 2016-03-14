<?php

namespace Pronit\CoreBundle\Entity\Controlling\Repository;

use Doctrine\Common\Persistence\ObjectRepository;
use Pronit\CoreBundle\Entity\Controlling\GestionImputacion;

/**
 *
 * @author gcaseres
 */
interface IGestionImputacionRepository extends ObjectRepository {

    function add(GestionImputacion $gestionImputacion);
}
