<?php

namespace Pronit\ComprasBundle\Model\Transacciones\EntradasMercancias;

use Doctrine\ORM\EntityManager;

use \Pronit\ComprasBundle\Entity\Documentos\Pedidos\Pedido;
use \Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\EntradaMercancias;

/**
 *
 * @author ldelia
 */
class TransaccionEntradaMercancias
{
    protected $em;
    
    public function __construct( EntityManager $em )
    {
        $this->em = $em;
    }
    
    public function ejecutar( EntradaMercancias $entradaMercancias)
    {
        if( ! $entradaMercancias->isContabilizado() ){
            
            $entradaMercancias->contabilizar();

            $this->em->persist($entradaMercancias);
            $this->em->flush();
        }else{
            throw new \Exception("La entrada de mercancias no puede ser contabilizada");
        }        
        
        
    }       
}
