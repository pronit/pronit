<?php

namespace Pronit\ContabilidadBundle\Model\Esquemas;

use Pronit\CoreBundle\Entity\Documentos\Documento;
use Pronit\ContabilidadBundle\Model\Esquemas\EsquemaContable;

/**
 *
 * @author ldelia
 */
interface IGeneradorEsquemaContable
{
    /**
     * 
     * @param \Pronit\CoreBundle\Entity\Documentos\Documento $documento
     * @return \Pronit\ContabilidadBundle\Model\Esquemas\EsquemaContable
     */
    public function generar(Documento $documento);
            
}
