<?php

namespace Pronit\CoreBundle\Entity\Controlling\Documentos;

use Doctrine\ORM\Mapping as ORM;
use Pronit\CoreBundle\Entity\Controlling\Imputacion;

class ItemEmisor extends ItemImputacionSecundaria {

    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Controlling\Imputacion") 
     */
    private $imputacion;

    public function __construct(Imputacion $imputacion) {
        parent::__construct();
        $this->imputacion = $imputacion;
    }

    /**
     * 
     * @return Imputacion
     */
    public function getImputacion() {
        return $this->imputacion;
    }

    /**
     * 
     * @return ObjetoCostro
     */
    public function getObjetoCosto() {
        return $this->imputacion->getObjetoCosto();
    }

}
