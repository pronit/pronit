<?php

namespace Pronit\CoreBundle\Entity\Documentos;

use Pronit\CoreBundle\Entity\Contabilidad\CuentasContables\Cuenta;
use Pronit\CoreBundle\Entity\Operaciones\OperacionContable;
use Doctrine\ORM\Mapping as ORM;

use Pronit\CoreBundle\Entity\Controlling\ObjetoCosto;

/** 
 * @ORM\Entity
 */
class ItemFinanzasEntradaMercancias extends ItemFinanzas {
    
    /** 
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Controlling\ObjetoCosto") 
     * @ORM\JoinColumn(nullable=true)
     */
    protected $objetoCosto;    
    
    public function __construct(OperacionContable $operacion = null, Cuenta $cuenta = null, ObjetoCosto $objetoCosto = null) {
        parent::__construct($operacion, $cuenta);
        $this->setObjetoCosto($objetoCosto);
    }
    
    public function accept(ItemFinanzasVisitor $visitor) {
        $visitor->visitItemFinanzasPago($this);
    }
    
    /**
     * 
     * @return ObjetoCosto
     */
    function getObjetoCosto() {
        return $this->objetoCosto;
    }

    function setObjetoCosto($objetoCosto) {
        $this->objetoCosto = $objetoCosto;
    }    

}
