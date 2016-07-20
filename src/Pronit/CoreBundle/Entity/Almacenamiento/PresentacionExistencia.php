<?php

namespace Pronit\CoreBundle\Entity\Almacenamiento;

use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones\PresentacionVenta;
use Pronit\ParametrizacionGeneralBundle\Entity\Escala;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="core_almacenamiento_presentacionesexistencias")
 * @author gcaseres
 */
class PresentacionExistencia {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Almacenamiento\Existencia", inversedBy="presentaciones")
     * @var Existencia
     */
    private $existencia;

    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones\PresentacionVenta")
     * @var PresentacionVenta
     */
    private $presentacionVenta;

    /**
     * @ORM\OneToMany(targetEntity="Pronit\CoreBundle\Entity\Almacenamiento\CantidadPresentacionExistencia", mappedBy="presentacionExistencia", cascade={"persist", "remove"})
     * @var ArrayCollection
     */
    private $cantidades;

    public function __construct(Existencia $existencia, PresentacionVenta $presentacionVenta) {
        $this->existencia = $existencia;
        $this->presentacionVenta = $presentacionVenta;
        $this->cantidades = new ArrayCollection();
    }

    /**
     * 
     * @return PresentacionVenta
     */
    public function getPresentacionVenta() {
        return $this->presentacionVenta;
    }

    public function addCantidad($valor, Escala $escala) {
        $this->cantidades->add(new CantidadPresentacionExistencia($this, $valor, $escala));
    }

    public function setCantidad($valor, Escala $escala) {
        foreach ($this->cantidades as /* @var $cantidad CantidadPresentacionExistencia */ $cantidad) {
            if ($cantidad->getEscala()->equals($escala)) {
                $cantidad->setValor($valor);
                return;
            }
        }

        throw new Exception('La presentación de existencia no tiene definida una cantidad para la escala especificada.');
    }
    
    /**
     * 
     * @param Escala $escala
     * @return float
     * @throws Exception
     */
    public function getCantidad(Escala $escala) {
        foreach ($this->cantidades as /* @var $cantidad CantidadPresentacionExistencia */ $cantidad) {
            if ($cantidad->getEscala() === $escala) {                
                return $cantidad->getValor();
            }
        }

        throw new Exception('La presentación de existencia no tiene definida una cantidad para la escala especificada.');        
    }

}
