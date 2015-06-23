<?php

namespace Pronit\CoreBundle\Controller\Documentos\Ventas\Facturas;

use Sonata\AdminBundle\Controller\CRUDController as Controller;

class FacturaController extends Controller
{
    public function contabilizarAction($id)
    {
        /* @var $salidaMercancias \Pronit\CoreBundle\Entity\Documentos\Ventas\SalidasMercancias\SalidaMercancias  */
        $salidaMercancias = $this->admin->getObject($id);
        
        /* @var $transaccionSalidaMercancias \Pronit\CoreBundle\Model\Transacciones\SalidasMercancias\TransaccionSalidaMercancias  */
        $transaccionSalidaMercancias = $this->get('pronit_ventas_transaccion.salidamercancias');
        $transaccionSalidaMercancias->ejecutar($salidaMercancias);                

        return $this->redirect( $this->generateUrl( 'pronit_ventas_salidas_mercancias_list' ) );
    }    
}
