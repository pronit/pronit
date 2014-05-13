<?php
namespace Pronit\AutomatizacionBundle\Entity;

use Pronit\AutomatizacionBundle\Model\Funciones\Contexto;
use Pronit\AutomatizacionBundle\Model\Funciones\EvaluadorFuncion;



/**
 * Description of Funcion
 *
 * @author gcaseres
 */
class Funcion {
    protected $script;
    protected $nombre;
    protected $nombreClase;
       
    public function __construct() {
    }
    
    public function setScript($value) {
        $this->script = $value;
    }
    
    public function getScript() {
        return $this->script;
    }
    
    public function setNombre($value) {
        $this->nombre = $value;
    }
    
    public function getNombre() {
        return $this->nombre;
    }
    
    public function setNombreClase($value) {
        $this->nombreClase = $value;
    }
    
    public function getNombreClase() {
        return $this->nombreClase;
    }
       
    public function ejecutar(Contexto $contexto) {
        return EvaluadorFuncion::getInstance()->ejecutar($this, $contexto);
    }
}

