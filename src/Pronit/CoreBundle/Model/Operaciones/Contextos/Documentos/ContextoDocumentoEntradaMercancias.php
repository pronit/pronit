<?php

namespace Pronit\CoreBundle\Model\Operaciones\Contextos\Documentos;

use Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\EntradaMercancias;
use Pronit\CoreBundle\Entity\Operaciones\Operacion;
use Pronit\AutomatizacionBundle\Model\Funciones\Contexto;

/**
 *
 * @author ldelia
 */
class ContextoDocumentoEntradaMercancias extends Contexto {

    protected $documento;

    public function __construct(Operacion $operacion, EntradaMercancias $documento) {
        parent::__construct("Compras.DocumentoEntradaMercancias", $operacion);

        $this->documento = $documento;
    }

    /**
     * 
     * @return EntradaMercancias
     */
    public function getDocumento() {
        return $this->documento;
    }

}
