<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pronit\CoreBundle\Entity\Contabilidad\Movimientos;

use Doctrine\ORM\Mapping as ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="conta_numeracionmovimientos")
 */
class NumeracionMovimientosSociedadFI {
    
    
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    private $id;
    
    /**
     * 
     * @ORM\Column(type="integer") 
     * @var int 
     */
    private $ultimoNumeroAsiento;
    
    public function __construct() {
        
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
}
