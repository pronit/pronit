<?php

namespace Pronit\CoreBundle\Entity\Numeraciones;

use Pronit\EstructuraEmpresaBundle\Entity\SociedadFI;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="core_numeracionsociedadfi")
 */
class NumeracionSociedadFI {

    /** 
     * @ORM\Id    
     * @ORM\OneToOne(targetEntity="Pronit\EstructuraEmpresaBundle\Entity\SociedadFI")
     * @var SociedadFI 
     */
    private $sociedadFI;

    /**
     * 
     * @ORM\Column(type="integer") 
     * @var int 
     */
    private $ultimoNumeroAsiento;

    public function __construct(SociedadFI $sociedadFI) {
        $this->sociedadFI = $sociedadFI;
        $this->ultimoNumeroAsiento = 0;
    }

    /**
     * 
     * @param int $value
     */
    public function setUltimoNumeroAsiento($value) {
        $this->ultimoNumeroAsiento = $value;
    }

    /**
     * 
     * @return int
     */
    public function getUltimoNumeroAsiento() {
        return $this->ultimoNumeroAsiento;
    }

    /**
     * Incrementa el valor del último número de asiento.
     * 
     * @return int Último número de asiento incrementado
     */
    public function incrementarUltimoNumeroAsiento() {
        $this->ultimoNumeroAsiento++;
        return $this->ultimoNumeroAsiento;
    }

    
    public function getId() {
        return $this->id;
    }
}
