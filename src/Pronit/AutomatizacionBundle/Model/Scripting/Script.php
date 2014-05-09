<?php
namespace pronit\automatizacionbundle\model\scripting;


/**
 * Description of Script
 *
 * @author gcaseres
 */
abstract class Script {
    public abstract function ejecutar(Contexto $contexto);
}
