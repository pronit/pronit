<?php

namespace Pronit\ComprasBundle\Controller\Documentos\Facturas;

use Sonata\AdminBundle\Controller\CRUDController as Controller;

class FacturaController extends Controller
{
    public function contabilizarAction($id)
    {
        /* @var $factura \Pronit\ComprasBundle\Entity\Documentos\Facturas\Factura  */
        $factura = $this->admin->getObject($id);
        
        /* @var $transaccionEntradaMercancias \Pronit\ComprasBundle\Model\Transacciones\Facturas\TransaccionFactura  */
        $transaccionFactura = $this->get('pronit_compras_transaccion.factura');
        $transaccionFactura->ejecutar($factura);                

        return $this->redirect( $this->generateUrl( 'pronit_facturas_list' ) );
    }
    
    public function crearFacturaDesdeEntradaMercanciasAction($id)
    {
        return $this->redirect($this->generateUrl('pronit_facturas_create', array( 'entradamercancias_id' => $id ) ));        
    }    
    
}
