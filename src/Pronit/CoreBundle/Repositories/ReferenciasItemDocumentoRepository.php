<?php

namespace Pronit\CoreBundle\Repositories;

use Doctrine\ORM\EntityRepository;
use Pronit\CoreBundle\Entity\Documentos\Item;

/**
 * 
 *
 * @author gcaseres
 */
class ReferenciasItemDocumentoRepository extends EntityRepository implements IReferenciasItemDocumentoRepository {

    public function fetchDesde(Item $item) {
        return $this->createQueryBuilder('r')->join('origen', 'o')->where('o.id = ?', $item->getId())->getQuery()->getResult();
    }

    public function fetchHacia(Item $item) {
        return $this->createQueryBuilder('r')->join('destino', 'o')->where('o.id = ?', $item->getId())->getQuery()->getResult();
    }

}
