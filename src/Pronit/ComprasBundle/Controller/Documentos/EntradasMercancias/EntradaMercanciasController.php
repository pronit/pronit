<?php

namespace Pronit\ComprasBundle\Controller\Documentos\EntradasMercancias;

use Sonata\AdminBundle\Controller\CRUDController as Controller;

class EntradaMercanciasController extends Controller
{
    public function contabilizarAction($id)
    {
        /* @var $entradaMercancias \Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\EntradaMercancias  */
        $entradaMercancias = $this->admin->getObject($id);
        
        /* @var $transaccionEntradaMercancias \Pronit\ComprasBundle\Model\Transacciones\EntradasMercancias\TransaccionEntradaMercancias  */
        $transaccionEntradaMercancias = $this->get('pronit_compras_transaccion.entradamercancias');
        $transaccionEntradaMercancias->ejecutar($entradaMercancias);                

        return $this->redirect( $this->generateUrl( 'pronit_entradas_mercancias_list' ) );
    }
    
}
