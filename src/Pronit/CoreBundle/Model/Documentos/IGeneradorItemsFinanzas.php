<?php

namespace Pronit\CoreBundle\Model\Documentos;

use Pronit\CoreBundle\Entity\Documentos\Documento;

/**
 *
 * @author gcaseres
 */
interface IGeneradorItemsFinanzas {
    function generar(Documento $documento);
}
