<?php
namespace Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo;

/**
 * Description of Condicion
 *
 * @author gcaseres
 */
class Condicion {
    /** @var string */
    protected $descripcion;
    
    /** @var int */
    protected $orden;
    
    /** @var float */
    protected $valor;
    
    public function __construct($orden, $descripcion, $valor) {
        $this->orden = $orden;
        $this->descripcion = $descripcion;
        $this->valor = $valor;        
    }
        
    public function getOrden() {
        return $this->orden;
    }    
    
    public function getDescripcion() {
        return $this->descripcion;
    }
    
    public function getValor() {
        return $this->valor;
    }
}
