<?php

namespace Pronit\ComprasBundle\Entity\Documentos\Pedidos\Estados;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Finalizado extends EstadoPedido
{
    public function __toString()
    {
        return 'Finalizado';
    }
}
