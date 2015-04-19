<?php

namespace Pronit\CoreBundle\Controller\Documentos\Ventas\Pedidos;

use Sonata\AdminBundle\Controller\CRUDController as Controller;

class PedidoController extends Controller
{
    public function contabilizarAction($id)
    {
        /* @var $pedido \Pronit\CoreBundle\Entity\Documentos\Ventas\Pedidos\Pedido  */
        $pedido = $this->admin->getObject($id);

        if( ! $pedido->isContabilizado() ){
            
            $pedido->contabilizar();

            $this->getDoctrine()->getManager()->flush();            
            
            return $this->redirect( $this->generateUrl( 'pronit_ventas_pedidos_list' ) );
        }else{
            throw new \Exception("El pedido no puede ser contabilizado");
        }
        
    }
    
    public function crearSalidaMercanciasDesdePedidoAction($id)
    {
        return $this->redirect($this->generateUrl('pronit_ventas_salidas_mercancias_create', array( 'pedido_id' => $id ) ));
    }
    
}
