<?php
namespace Pronit\CoreBundle\Entity\Contabilidad\Movimientos;

use DateTime;
use Pronit\CoreBundle\Entity\Contabilidad\CuentasContables\Cuenta;
use Pronit\CoreBundle\Entity\Documentos\ItemFinanzas;

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
    
    /**
     * @ORM\OneToOne(targetEntity="Pronit\CoreBundle\Entity\Documentos\ItemFinanzas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $itemFinanzas;
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Contabilidad\CuentasContables\Cuenta")
     * @ORM\JoinColumn(nullable=false)
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
    
    public function __construct($asiento, DateTime $fecha, $descripcion, ItemFinanzas $itemFinanzas, Cuenta $cuenta, $importe) 
    {
        $this->asiento = $asiento;
        $this->fecha = $fecha;
        $this->descripcion = $descripcion;
        $this->itemFinanzas = $itemFinanzas;        
        $this->cuenta = $cuenta;
        $this->importe = $importe;
    }
        
    public function getAsiento() 
    {
        return $this->asiento;
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
    
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * 
     * @return ItemFinanzas
     */
    function getItemFinanzas()
    {
        return $this->itemFinanzas;
    } 
    
    public function __toString()
    {
        return $this->getCuenta() . " " . $this->getImporte();
    }
}