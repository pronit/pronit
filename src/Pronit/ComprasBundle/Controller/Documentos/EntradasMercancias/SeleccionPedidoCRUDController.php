<?php

namespace Pronit\ComprasBundle\Controller\Documentos\EntradasMercancias;

use Sonata\AdminBundle\Controller\CRUDController as Controller;

class SeleccionPedidoCRUDController extends Controller
{
    public function crearEntradaMercanciasDesdePedidoAction($id)
    {
        return $this->redirect($this->generateUrl('pronit_entradas_mercancias_create', array( 'pedido_id' => $id ) ));
    }
}
