<?php

namespace Pronit\ComprasBundle\Controller\Documentos\Pedidos;

use Sonata\AdminBundle\Controller\CRUDController as Controller;

class PedidoController extends Controller
{
    public function contabilizarAction($id)
    {
        /* @var $pedido \Pronit\ComprasBundle\Entity\Documentos\Pedidos\Pedido  */
        $pedido = $this->admin->getObject($id);

        if( ! $pedido->isContabilizado() ){
            
            $pedido->contabilizar();

            $this->getDoctrine()->getManager()->flush();            
            
            return $this->redirect( $this->generateUrl( 'pronit_pedidos_list' ) );
        }else{
            throw new \Exception("El pedido no puede ser contabilizado");
        }
        
    }
    
    public function crearEntradaMercanciasDesdePedidoAction($id)
    {
        return $this->redirect($this->generateUrl('pronit_entradas_mercancias_create', array( 'pedido_id' => $id ) ));
    }
    
}
