<?php

namespace Pronit\CoreBundle\Model\Numeraciones;

use Pronit\EstructuraEmpresaBundle\Entity\SociedadFI;

/**
 *
 * @author gcaseres
 */
interface INumeracionSociedadFIManager {

    function generarNumeroAsiento(SociedadFI $sociedad);
}
