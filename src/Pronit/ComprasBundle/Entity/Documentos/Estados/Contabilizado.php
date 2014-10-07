<?php

namespace Pronit\ComprasBundle\Entity\Documentos\Estados;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Contabilizado extends EstadoCompras
{
    public function __toString()
    {
        return 'Contabilizado';
    }
}
