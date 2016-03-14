<?php

namespace Pronit\CoreBundle\Model\Controlling\Documentos;

use ArrayObject;
use Pronit\CoreBundle\Entity\Documentos\Documento;

/**
 *
 * @author ldelia
 */
interface IImputadorObjetosCosto 
{
    /**
     * 
     * @param Documento $documento
     * @return ArrayObject
     */
    function imputar(Documento $documento);
}
