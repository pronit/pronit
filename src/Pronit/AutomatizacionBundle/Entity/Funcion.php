<?php
namespace Pronit\AutomatizacionBundle\Entity;

use Pronit\AutomatizacionBundle\Model\Funciones\Contexto;
use Pronit\AutomatizacionBundle\Model\Funciones\EvaluadorFuncion;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Funcion
 *
 * @author gcaseres
 * @ORM\Entity
 * @ORM\Table(name="autom_funcion")
 */
class Funcion {
    
   /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    protected $id;
    
    /** 
     * @ORM\Column(type="text")
     */        
    protected $script;

    /** 
     * @ORM\Column(type="string", length=100)
     */
    protected $nombre;
    
    /** 
     * @ORM\Column(type="string", length=100)
     */
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
    
    public function __toString() {
        return $this->nombre;
    }
}

