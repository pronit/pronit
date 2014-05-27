<?php

namespace Pronit\CoreBundle\Entity\Operaciones;

use Exception;
use Pronit\AutomatizacionBundle\Entity\Funcion;
use Pronit\CoreBundle\Model\Automatizacion\Scripting\Contexto as ContextoScript;
use Pronit\CoreBundle\Model\Operaciones\Contexto;

use Doctrine\ORM\Mapping as ORM;

/**
 * 
 *
 * @author gcaseres
 * @ORM\Entity
 * @ORM\Table(name="core_operacion")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"OperacionContableValue" = "Pronit\CoreBundle\Entity\Contabilidad\OperacionContable"})
 */
abstract class Operacion {

   /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    protected $id;
    
    /** 
     * @ORM\Column(type="string", length=5)
     */    
    protected $codigo;
    
    /** 
     * @ORM\Column(type="string") 
     */    
    protected $nombre;

    /** @todo */
    protected $funcion;
    
    /** @todo */
    protected $contextosAceptados;
    
    
    public function setContextosAceptados(array $value) {
        $this->contextosAceptados = $value;
    }
    
    public function getContextosAceptados() {
        return $this->contextosAceptados;
    }

    public function setCodigo($value) {
        $this->codigo = $value;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function setNombre($value) {
        $this->nombre = $value;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setFuncion(Funcion $value) {
        $this->funcion = $value;
    }

    public function getFuncion() {
        return $this->funcion;
    }

    public function ejecutar(Contexto $contexto) {

        if ($contexto == null) {
            throw new Exception("El contexto no puede ser nulo.");
        }

        if ($this->funcion == null) {
            throw new Exception("No se ha especificado una función para esta operación.");
        }
        
        if (!$this->aceptaContexto($contexto)) {
            throw new Exception("Esta operación no acepta el contexto establecido.");
        }

        $contextoScript = new ContextoScript($contexto);

        try {
            $returnValue = $this->funcion->ejecutar($contextoScript);
        } catch (Exception $e) {
            return $this->procesarException($e);
        }

        return $this->procesar($returnValue);
    }

    protected abstract function procesar($returnValue);
    
    protected function procesarException(Exception $e) {
        return null;
    }
    
    public function aceptaContexto(Contexto $contexto) {
        return in_array($contexto->getCodigo(), $this->contextosAceptados);
    }
}
