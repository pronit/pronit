<?php

namespace Pronit\ParametrizacionGeneralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * 
 *
 * @author ldelia
 */

/**
 * @ORM\Entity
 * @ORM\Table(name="pgener_sistemamedicion")
 */
class SistemaMedicion {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $nombre;

    /**
     * @ORM\Column(type="string", length=10)
     */
    protected $abreviatura;

    /**
     * @ORM\OneToMany(targetEntity="Pronit\ParametrizacionGeneralBundle\Entity\Escala", mappedBy="sistemaMedicion", cascade={"ALL"}, orphanRemoval=true)
     */
    protected $escalas;

    public function __construct($nombre, $abreviatura) {
        $this->nombre = $nombre;
        $this->abreviatura = $abreviatura;
        $this->setEscalas(new \Doctrine\Common\Collections\ArrayCollection());
    }

    public function getId() {
        return $this->id;
    }

    public function setNombre($valor) {
        $this->nombre = $valor;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setAbreviatura($value) {
        $this->abreviatura = $value;
    }

    public function getAbreviatura() {
        return $this->abreviatura;
    }

    public function getEscalas() {
        return $this->escalas;
    }

    protected function setEscalas($escalas) {
        $this->escalas = $escalas;
    }

    public function addEscala(Escala $escala) {
        $escala->setSistemaMedicion($this);
        $this->escalas[] = $escala;
    }

    public function removeEscala(Escala $escala) {
        $this->escalas->removeElement($escala);
    }

    public function __toString() {
        return $this->getNombre();
    }

    /**
     * 
     * @param type $valor
     * @param \Pronit\ParametrizacionGeneralBundle\Entity\Escala $escalaOrigen
     * @param \Pronit\ParametrizacionGeneralBundle\Entity\Escala $escalaDestino
     */
    public function escalar($valor, Escala $escalaOrigen, Escala $escalaDestino) {
        return $escala->escalar($valor, $escalaDestino);
    }

}
