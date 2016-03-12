<?php

namespace Pronit\CoreBundle\Model\Documentos\Controlling;

use Pronit\CoreBundle\Entity\Documentos\Documento;

/**
 *
 * @author ldelia
 */
interface IImputadorObjetosCosto 
{
    function imputar(Documento $entradaMercancias);
}
