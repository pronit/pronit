<?php

namespace Pronit\CoreBundle\Entity\Controlling\Documentos;

use Doctrine\ORM\Mapping as ORM;

use Pronit\CoreBundle\Entity\Controlling\ObjetoCosto;
use Pronit\CoreBundle\Entity\Documentos\Item;

abstract class ItemImputacionSecundaria extends Item {

    /**
     * @ORM\Column(type="float")
     */
    protected $importe;

    public function getImporte() {
        return $this->importe;
    }

    public function setImporte($importe) {
        $this->importe = $importe;
    }

    /**
     * 
     * @return ObjetoCosto
     */
    abstract public function getObjetoCosto();
}
