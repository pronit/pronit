<?php

namespace Pronit\CoreBundle\Entity\Contabilidad\CuentasContables;

use Doctrine\ORM\Mapping as ORM;


/**
 *
 * @author ldelia
 * @ORM\Entity
 * @ORM\Table(name="conta_cuenta")
 */
class Cuenta
{
   
    /**
     * 
     * @ORM\Id
     * @ORM\Column(name="id", type="string")     
     * 
     * @var string
     */
    private $codigo;

    /**
     * @ORM\Column(type="string")
     */        
    private $nombre;    
    
    public function __construct($codigo, $nombre) {
        $this->codigo = $codigo;
        $this->nombre = $nombre;
    }
    
    /**
     * Especifica si la instancia de cuenta actual es equivalente a la especificada.
     * 
     * La igualdad entre cuentas está definida a partir del código de cuenta.
     * TODO: No está correctamente especificado por el momento el modelo de 
     * cuentas y planes de cuentas. Por ahora la cuenta y el item de plan de cuenta
     * están compartiendo la misma semántica.
     * 
     * @param \Pronit\CoreBundle\Entity\Contabilidad\CuentasContables\Cuenta $cuenta
     * @return boolean
     */
    public function equals(Cuenta $cuenta) {
        return $this->codigo === $cuenta->getCodigo();
    }
    
    public function setCodigo($value) {
        $this->codigo = $value;
    }
    
    public function getCodigo() {
        return $this->codigo;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }    
    
    public function __toString()
    {
        return sptrintf('%s', $this->nombre);
    }
}
