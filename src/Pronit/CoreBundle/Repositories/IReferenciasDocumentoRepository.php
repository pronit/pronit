<?php

namespace Pronit\CoreBundle\Repositories;

use Doctrine\Common\Persistence\ObjectRepository;
use Pronit\CoreBundle\Entity\Documentos\Documento;

/**
 *
 * @author gcaseres
 */
interface IReferenciasDocumentoRepository extends ObjectRepository {

    public function fetchHacia(Documento $documento);

    public function fetchDesde(Documento $documento);
}
