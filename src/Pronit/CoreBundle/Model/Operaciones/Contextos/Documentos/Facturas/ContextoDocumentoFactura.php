<?php

namespace Pronit\CoreBundle\Model\Operaciones\Contextos\Documentos\Facturas;

use Doctrine\ORM\EntityManager;
use Pronit\ComprasBundle\Entity\Documentos\Facturas\Factura;
use Pronit\CoreBundle\Model\Operaciones\Contextos\Contexto;

/**
 *
 * @author ldelia
 */
class ContextoDocumentoFactura extends Contexto 
{    
    protected $factura;
    protected $entityManager;
    
    const CODIGO = "Compras.DocumentoFactura";
    
    public function __construct( Factura $factura, EntityManager $em) 
    {
        parent::__construct( self::CODIGO );
        $this->entityManager = $em;
        $this->factura = $factura;        
    }
    
    /**
     * 
     * @return Factura
     */
    public function getFactura()
    {
        return $this->factura;
    }
    
    /**
     * 
     * @return EntityManager
     */
    public function getEntityManager() 
    {
        return $this->entityManager;
    }
}
