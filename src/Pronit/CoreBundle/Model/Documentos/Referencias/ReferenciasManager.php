<?php

namespace Pronit\CoreBundle\Model\Documentos\Referencias;

use ArrayObject;
use Pronit\CoreBundle\Entity\Documentos\Documento;
use Pronit\CoreBundle\Entity\Documentos\Item;
use Pronit\CoreBundle\Entity\Documentos\Referencias\ReferenciaDocumento;
use Pronit\CoreBundle\Repositories\IReferenciasDocumentoRepository;
use Pronit\CoreBundle\Repositories\IReferenciasItemDocumentoRepository;

/**
 * Administrador de referencias entre documentos.
 * 
 * Esta clase permite obtener las referencias desde o hacia un documento o
 * un item de documento.
 *
 * @author gcaseres
 */
class ReferenciasManager {

    /** @var IReferenciasDocumentoRepository */
    protected $referenciasDocumentoRepository;

    /** @var IReferenciasItemDocumentoRepository */
    protected $referenciasItemDocumentoRepository;

    public function __construct(IReferenciasDocumentoRepository $referenciasDocumentoRepository, IReferenciasItemDocumentoRepository $referenciasItemDocumentoRepository) {
        $this->referenciasDocumentoRepository = $referenciasDocumentoRepository;
        $this->referenciasItemDocumentoRepository = $referenciasItemDocumentoRepository;
    }

    public function obtenerDocumentosOrigen(Documento $documento) {
        $result = new ArrayObject();
        $referencias = $this->referenciasDocumentoRepository->fetchHacia($documento);

        foreach ($referencias as /* @var $referencia ReferenciaDocumento */ $referencia) {
            $result->append($referencia->getOrigen());
        }

        return $result;
    }

    public function obtenerDocumentosDestino(Documento $documento) {
        $result = new ArrayObject();
        $referencias = $this->referenciasDocumentoRepository->fetchDesde($documento);

        foreach ($referencias as /* @var $referencia ReferenciaDocumento */ $referencia) {
            $result->append($referencia->getDestino());
        }

        return $result;        
    }

    public function obtenerItemsOrigen(Item $item) {
        $result = new ArrayObject();
        $referencias = $this->referenciasItemDocumentoRepository->fetchHacia($item);

        foreach ($referencias as /* @var $referencia ReferenciaItemDocumento */ $referencia) {
            $result->append($referencia->getOrigen());
        }

        return $result;                
    }

    public function obtenerItemsDestino(Item $item) {
        $result = new ArrayObject();
        $referencias = $this->referenciasItemDocumentoRepository->fetchDesde($item);

        foreach ($referencias as /* @var $referencia ReferenciaItemDocumento */ $referencia) {
            $result->append($referencia->getDestino());
        }

        return $result;                        
    }

}
