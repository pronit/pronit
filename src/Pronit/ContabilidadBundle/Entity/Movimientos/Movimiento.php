<?php
namespace Pronit\ContabilidadBundle\Entity\Movimientos;

use DateTime;
use Pronit\ContabilidadBundle\Entity\CuentasContables\Cuenta;
use Pronit\EstructuraEmpresaBundle\Entity\SociedadFI;

/**
 * Description of Movimiento
 *
 * @author gcaseres
 */
class Movimiento {
    
    /** @var int */
    private $asiento;
    
    /** @var SociedadFI */
    private $sociedadFI;
    
    /** @var Cuenta */
    private $cuenta;
    
    /** @var float */
    private $importe;
    
    /** @var DateTime */
    private $fecha;
    
    /** @var string */
    private $descripcion;
    
    public function __construct($asiento, DateTime $fecha, $descripcion, Cuenta $cuenta, $importe) {
        $this->asiento = $asiento;
        $this->fecha = $fecha;
        $this->descripcion = $descripcion;
        $this->cuenta = $cuenta;
        $this->importe = $importe;
    }
        
    public function getAsiento() {
        return $this->asiento;
    }
    
    public function getSociedadFI() {
        return $this->sociedadFI;
    }
    
    public function getCuenta() {
        return $this->cuenta;
    }
    
    public function getFecha() {
        return $this->fecha;
    }
    
    public function getDescripcion() {
        return $this->descripcion;
    }
    
    public function getImporte() {
        return $this->importe;
    }
}
