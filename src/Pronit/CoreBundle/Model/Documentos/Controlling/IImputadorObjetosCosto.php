<?php

namespace Pronit\CoreBundle\Model\Documentos\Controlling;

use Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\EntradaMercancias;

/**
 *
 * @author ldelia
 */
interface IImputadorObjetosCosto 
{
    function imputar(EntradaMercancias $entradaMercancias);
}
