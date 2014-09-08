<?php

namespace Pronit\CoreBundle\Repositories;

use Doctrine\Common\Persistence\ObjectRepository;
use Pronit\CoreBundle\Entity\Documentos\Item;

/**
 *
 * @author gcaseres
 */
interface IReferenciasItemDocumentoRepository extends ObjectRepository {

    public function fetchHacia(Item $item);

    public function fetchDesde(Item $item);
}
