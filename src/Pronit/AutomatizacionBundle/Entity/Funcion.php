<?php
namespace Pronit\AutomatizacionBundle\Entity;



/**
 * Description of Funcion
 *
 * @author gcaseres
 */
class Funcion {
    protected $script;
    protected $nombre;
    protected $nombreClase;
    
    
    public function __construct($nombre, $nombreClase, $script) {
        $this->nombre = $nombre;
        $this->nombreClase = $nombreClase;
        $this->script = $script;
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
    
    public function setScript($value) {
        $this->script = $value;
    }
    
    public function getScript() {
        return $this->script;
    }
    
}
