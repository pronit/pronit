<?php
namespace Pronit\ContabilidadBundle\Entity\Movimientos;

use DateTime;
use Pronit\ContabilidadBundle\Entity\CuentasContables\Cuenta;
use Pronit\EstructuraEmpresaBundle\Entity\SociedadFI;

use Doctrine\ORM\Mapping as ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="conta_movimientos")
 */
class Movimiento 
{
    
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    private $id;
    
    /** 
     * @ORM\Column(type="integer") 
     */
    private $asiento;
    
    /** @var SociedadFI */
    private $sociedadFI;
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\ContabilidadBundle\Entity\CuentasContables\Cuenta")
     */
    private $cuenta;
    
    /** 
     * @ORM\Column(type="float") 
     */
    private $importe;
    
    /** 
     * @ORM\Column(type="datetime") 
     */
    private $fecha;
    
    /** 
     * @ORM\Column(type="text") 
     */
    private $descripcion;
    
    public function __construct($asiento, DateTime $fecha, $descripcion, Cuenta $cuenta, $importe) 
    {
        $this->asiento = $asiento;
        $this->fecha = $fecha;
        $this->descripcion = $descripcion;
        $this->cuenta = $cuenta;
        $this->importe = $importe;
    }
        
    public function getAsiento() 
    {
        return $this->asiento;
    }
    
    public function getSociedadFI() 
    {
        return $this->sociedadFI;
    }
    
    public function getCuenta() 
    {
        return $this->cuenta;
    }
    
    public function getFecha() 
    {
        return $this->fecha;
    }
    
    public function getDescripcion() 
    {
        return $this->descripcion;
    }
    
    public function getImporte() 
    {
        return $this->importe;
    }
}