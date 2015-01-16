<?php

namespace Pronit\CoreBundle\Model\Contabilidad\Esquemas;

use Pronit\CoreBundle\Entity\Documentos\Documento;
use Pronit\CoreBundle\Model\Contabilidad\Esquemas\EsquemaContable;

/**
 *
 * @author ldelia
 */
interface IGeneradorEsquemaContable
{
    /**
     * 
     * @param \Pronit\CoreBundle\Entity\Documentos\Documento $documento
     * @return \Pronit\CoreBundle\Model\Contabilidad\Esquemas\EsquemaContable
     */
    public function generar(Documento $documento);
            
}
