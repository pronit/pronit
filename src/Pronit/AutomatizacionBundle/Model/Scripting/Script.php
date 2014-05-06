<?php
namespace Pronit\AutomatizacionBundle\Model\Scripting;


/**
 * Description of Script
 *
 * @author gcaseres
 */
abstract class Script {
    public abstract function ejecutar(Contexto $contexto);
}
