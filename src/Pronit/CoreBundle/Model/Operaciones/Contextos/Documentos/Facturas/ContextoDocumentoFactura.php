<?php

namespace Pronit\CoreBundle\Model\Operaciones\Contextos\Documentos\Facturas;

use Doctrine\ORM\EntityManager;
use Pronit\AutomatizacionBundle\Model\Funciones\Contexto;
use Pronit\ComprasBundle\Entity\Documentos\Facturas\Factura;
use Pronit\CoreBundle\Entity\Operaciones\Operacion;
use Pronit\CoreBundle\Model\Contabilidad\Customizing\IImputacionesCustomizingManager as FIIImputacionesCustomizingManager;


/**
 *
 * @author ldelia
 */
class ContextoDocumentoFactura extends Contexto {

    protected $factura;
    protected $entityManager;

    /**
     *
     * @var FIIImputacionesCustomizingManager 
     */
    protected $fiImputacionesCustomizingManager;

    const CODIGO = "Compras.DocumentoFactura";

    public function __construct(Operacion $operacion, Factura $factura, FIIImputacionesCustomizingManager $fiImputacionesCustomizingManager, EntityManager $em) {
        parent::__construct(self::CODIGO, $operacion);
        $this->entityManager = $em;
        $this->factura = $factura;
        $this->fiImputacionesCustomizingManager = $fiImputacionesCustomizingManager;
    }

    /**
     * 
     * @return Factura
     */
    public function getFactura() {
        return $this->factura;
    }

    /**
     * 
     * @return EntityManager
     */
    public function getEntityManager() {
        return $this->entityManager;
    }

    /**
     * 
     * @return FIIImputacionesCustomizingManager
     */
    public function getFIImputacionesCustomizingManager() {
        return $this->fiImputacionesCustomizingManager;
    }

}
