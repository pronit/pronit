<?php

namespace Pronit\CoreBundle\Controller\Documentos\Ventas\Facturas;

use Sonata\AdminBundle\Controller\CRUDController as Controller;

class FacturaController extends Controller
{
    public function contabilizarAction($id)
    {
        /* @var $factura \Pronit\CoreBundle\Entity\Documentos\Ventas\Facturas\Factura  */
        $factura = $this->admin->getObject($id);
        
        /* @var $transaccionFactura \Pronit\CoreBundle\Model\Transacciones\Facturas\TransaccionFactura */
        $transaccionFactura = $this->get('pronit_ventas_transaccion.factura');
        $transaccionFactura->ejecutar($factura);

        return $this->redirect( $this->generateUrl( 'pronit_ventas_salidas_mercancias_list' ) );
    }    
}
