<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pronit\ParametrizacionGeneralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Description of ItemCondicionPagos
 *
 * @author gcaseres
 * @ORM\Entity
 * @ORM\Table(name="pgener_itemcondicionpagos")
 */
class ItemCondicionPagos {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * 
     * @ORM\Column(type="float") 
     * @var float
     */
    private $porcentaje;

    /**
     *
     * @ORM\Column(type="float") 
     * @var int
     */
    private $cantidadDias;

    /**
     * @ORM\ManyToOne(targetEntity="Pronit\ParametrizacionGeneralBundle\Entity\CondicionPagos", inversedBy="items") 
     */
    private $condicionPagos;

    public function __construct() {
        
    }

    /**
     * 
     * @param int $value
     */
    public function setPorcentaje($value) {
        $this->porcentaje = $value;
    }

    /**
     * 
     * @return int
     */
    public function getPorcentaje() {
        return $this->porcentaje;
    }

    /**
     * 
     * @param int $value
     */
    public function setCantidadDias($value) {
        $this->cantidadDias = $value;
    }

    /**
     * 
     * @return int
     */
    public function getCantidadDias() {
        return $this->cantidadDias;
    }

    /**
     * 
     * @return \Pronit\ParametrizacionGeneralBundle\Entity\CondicionPagos
     */
    public function getCondicionPagos() {
        return $this->condicionPagos;
    }

    /**
     * 
     * @param \Pronit\ParametrizacionGeneralBundle\Entity\CondicionPagos $value
     */
    public function setCondicionPagos(CondicionPagos $value) {
        $this->condicionPagos = $value;
    }

}
