<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pronit\ParametrizacionGeneralBundle\Entity;

use DateInterval;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Description of CondicionPagos
 *
 * @author gcaseres
 * @ORM\Entity
 * @ORM\Table(name="pgener_condicionpagos")
 */
class CondicionPagos {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string") 
     * @var string 
     */
    private $codigo;

    /**
     * @ORM\Column(type="string") 
     * @var string 
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="ItemCondicionPagos", mappedBy="condicionPagos", cascade={"ALL"}, orphanRemoval=true)
     * @var ArrayCollection
     */
    private $items;

    public function __construct() {
        $this->items = new ArrayCollection();
    }

    /**
     * 
     * @param string $value
     */
    public function setCodigo($value) {
        $this->codigo = $value;
    }

    /**
     * 
     * @return string
     */
    public function getCodigo() {
        return $this->codigo;
    }

    /**
     * 
     * @param string $value
     */
    public function setNombre($value) {
        $this->nombre = $value;
    }

    /**
     * 
     * @return string
     */
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * 
     * @param ArrayCollection $value
     */
    protected function setItems(ArrayCollection $value) {
        $this->items = $value;
    }

    /**
     * 
     * @return ArrayCollection
     */
    public function getItems() {
        return $this->items;
    }

    /**
     * 
     * @param ItemCondicionPagos $item
     */
    public function addItem(ItemCondicionPagos $item) {
        $item->setCondicionPagos($this);
        $this->items->add($item);
    }

    /**
     * 
     * @param ItemCondicionPagos $item
     */
    public function removeItem(ItemCondicionPagos $item) {
        $item->setCondicionPagos(null);
        $this->items->removeElement($item);
    }

    /**
     * 
     * @return int
     */
    public function getCantidadPagos() {
        return $this->items->count();
    }
    
    public function getItem($numeroPago) {
        return $this->items->get($numeroPago - 1);
    }

    /**
     * Obtiene la fecha en la que vencería un pago tomando como base la fecha
     * provista.
     * 
     * @param int $numeroPago Número de pago (entre 1 y cantidad de pagos)
     * @param DateTime $fechaBase Fecha desde la cual se realiza el cálculo.
     */
    public function calcularFechaVencimientoPago($numeroPago, DateTime $fechaBase) {
        $result = clone $fechaBase;
        
        for ($i=1; $i <= $numeroPago; $i++) {
            
            /* @var $item ItemCondicionPagos */
            $item = $this->items->get($i - 1);
            
            $interval = new DateInterval("P" . $item->getCantidadDias() . "D");
            $result->add($interval);
        }
        
        return $result;
    }
    
    public function __toString()
    {
        return (string) $this->getNombre();
    }
}
