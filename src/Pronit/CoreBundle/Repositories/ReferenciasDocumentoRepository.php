<?php

namespace Pronit\CoreBundle\Repositories;

use Doctrine\ORM\EntityRepository;
use Pronit\CoreBundle\Entity\Documentos\Documento;

/**
 * 
 *
 * @author gcaseres
 */
class ReferenciasDocumentoRepository extends EntityRepository implements IReferenciasDocumentoRepository {

    public function fetchDesde(Documento $documento) {
        return $this->createQueryBuilder('r')->join('origen', 'o')->where('o.id = ?', $documento->getId())->getQuery()->getResult();
    }

    public function fetchHacia(Documento $documento) {
        return $this->createQueryBuilder('r')->join('destino', 'o')->where('o.id = ?', $documento->getId())->getQuery()->getResult();
    }

}
