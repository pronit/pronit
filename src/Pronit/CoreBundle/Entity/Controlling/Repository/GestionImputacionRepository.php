<?php

namespace Pronit\CoreBundle\Entity\Controlling\Repository;

use Doctrine\ORM\EntityRepository;
use Pronit\CoreBundle\Entity\Controlling\GestionImputacion;

/**
 * Description of GestionImputacionRepository
 *
 * @author gcaseres
 */
class GestionImputacionRepository extends EntityRepository implements IGestionImputacionRepository {

    public function add(GestionImputacion $gestionImputacion) {
        $this->getEntityManager()->persist($gestionImputacion);
    }

}
