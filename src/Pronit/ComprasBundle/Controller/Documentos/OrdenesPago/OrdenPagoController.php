<?php

namespace Pronit\ComprasBundle\Controller\Documentos\OrdenesPago;

use Sonata\AdminBundle\Controller\CRUDController as Controller;

class OrdenPagoController extends Controller
{
    public function contabilizarAction($id)
    {
        /* @var $ordenPago \Pronit\ComprasBundle\Entity\Documentos\OrdenesPago\OrdenPago  */
        $ordenPago = $this->admin->getObject($id);
        
        /* @var $transaccion \Pronit\ComprasBundle\Model\Transacciones\OrdenesPago\TransaccionOrdenPago  */
        $transaccion = $this->get('pronit_compras_transaccion.ordenpago');
        $transaccion->ejecutar($ordenPago);

        return $this->redirect( $this->generateUrl( 'pronit_ordenespago_list' ) );
    }    
}
