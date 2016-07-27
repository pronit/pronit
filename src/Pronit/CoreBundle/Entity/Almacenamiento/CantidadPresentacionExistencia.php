<?php

namespace Pronit\CoreBundle\Entity\Almacenamiento;

use Pronit\ParametrizacionGeneralBundle\Entity\Escala;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="core_almacenamiento_cantidadespresentacionexistencia")
 * @author gcaseres
 */
class CantidadPresentacionExistencia {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Almacenamiento\PresentacionExistencia", inversedBy="cantidades")
     * @var PresentacionExistencia
     */
    private $presentacionExistencia;

    /**
     * @ORM\Column(type="float")
     * @var float
     */
    private $valor;

    /**
     * @ORM\ManyToOne(targetEntity="Pronit\ParametrizacionGeneralBundle\Entity\Escala")
     * @var Escala
     */
    private $escala;

    public function __construct(PresentacionExistencia $presentacionExistencia, $valor, Escala $escala) {
        $this->presentacionExistencia = $presentacionExistencia;
        $this->valor = $valor;
        $this->escala = $escala;
    }

    /**
     * 
     * @param float $valor
     */
    public function setValor($valor) {
        $this->valor = $valor;
    }

    /**
     * 
     * @return float
     */
    public function getValor() {
        return $this->valor;
    }

    /**
     * 
     * @return Escala
     */
    public function getEscala() {
        return $this->escala;
    }

}
