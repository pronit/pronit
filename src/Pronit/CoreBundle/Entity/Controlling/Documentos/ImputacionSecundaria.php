<?php

namespace Pronit\CoreBundle\Entity\Controlling\Documentos;

use Doctrine\ORM\Mapping as ORM;

use Pronit\EstructuraEmpresaBundle\Entity\CentroLogistico;
use Pronit\ParametrizacionGeneralBundle\Entity\Moneda;
use Pronit\CoreBundle\Entity\Customizing\Deudores\DeudorSociedadFI;

use Pronit\CoreBundle\Entity\Documentos\Documento;
use Pronit\CoreBundle\Entity\Documentos\Ventas\Estados\EstadoVentas;
use Pronit\CoreBundle\Entity\Documentos\Ventas\Estados\Inicial;
use Pronit\CoreBundle\Entity\Documentos\Ventas\Estados\Contabilizado;


/**
 *
 * @author ldelia
 * @ORM\Entity
 */
class ImputacionSecundaria extends Documento
{
    public function getItemsEmisor()
    {
        throw new \Exception("No implementado aún");
    }
    
    public function getItemsReceptores()
    {
        throw new \Exception("No implementado aún");
    }
}

