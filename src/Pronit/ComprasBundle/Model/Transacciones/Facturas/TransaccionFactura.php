<?php

namespace Pronit\ComprasBundle\Model\Transacciones\Facturas;

use Doctrine\ORM\EntityManager;

use Pronit\ComprasBundle\Entity\Documentos\Facturas\Factura;

/**
 *
 * @author ldelia
 */
class TransaccionFactura
{
    protected $em;
    
    public function __construct( EntityManager $em )
    {
        $this->em = $em;
    }
    
    public function ejecutar( Factura $factura )
    {
        if( ! $factura->isContabilizado() ){
            
            $factura->contabilizar();

            $this->em->persist($factura);
            $this->em->flush();
        }else{
            throw new \Exception("La factura no puede ser contabilizada");
        }        
        
        
    }       
}
