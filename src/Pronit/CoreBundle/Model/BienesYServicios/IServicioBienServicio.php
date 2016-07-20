<?php

namespace Pronit\CoreBundle\Model\BienesYServicios;

use Pronit\EstructuraEmpresaBundle\Entity\SociedadFI;
use Pronit\GestionBienesYServiciosBundle\Entity\BienServicio;

/**
 *
 * @author gcaseres
 */
interface IServicioBienServicio {

    function asociarSociedad(BienServicio $bienServicio, SociedadFI $sociedad, $codigo);

    function desasociarSociedad(BienServicio $bienServicio, SociedadFI $sociedad);
}
