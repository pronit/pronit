<?php

namespace Pronit\CoreBundle\Entity\Controlling\Documentos;

use Doctrine\ORM\Mapping as ORM;
use Pronit\CoreBundle\Entity\Controlling\ObjetoCosto;

/**
 * @ORM\Entity
 * 
 */
class ItemReceptor extends ItemImputacionSecundaria 
{

    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Controlling\ObjetoCosto") 
     */
    protected $objetoCosto;

    /**
     * 
     * @return ObjetoCosto
     */
    function getObjetoCosto() {
        return $this->objetoCosto;
    }

    function setObjetoCosto(ObjetoCosto $objetoCosto) {
        $this->objetoCosto = $objetoCosto;
    }

}
