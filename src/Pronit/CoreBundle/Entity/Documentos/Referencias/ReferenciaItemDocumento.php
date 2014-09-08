<?php

namespace Pronit\CoreBundle\Entity\Documentos\Referencias;

use Pronit\CoreBundle\Entity\Documentos\Item;

/**
 * Define una referencia desde un item de documento a otro.
 *
 * @author gcaseres
 */
class ReferenciaItemDocumento {

    /** @var Item */
    protected $origen;

    /** @var Item */
    protected $destino;

    public function __construct(Item $origen, Item $destino) {
        $this->origen = $origen;
        $this->destino = $destino;
    }

    /**
     * 
     * @return Item
     */
    public function getOrigen() {
        return $this->origen;
    }

    /**
     * 
     * @return Item
     */
    public function getDestino() {
        return $this->destino;
    }

}
