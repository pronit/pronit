<?php

namespace Pronit\CoreBundle\Controller\Documentos\Ventas\SalidasMercancias;

use Sonata\AdminBundle\Controller\CRUDController as Controller;

class SalidaMercanciasController extends Controller
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
    
    public function crearFacturaDesdeSalidaMercanciasAction($id)
    {
        return $this->redirect($this->generateUrl('pronit_facturas_create', array( 'salidamercancias_id' => $id ) ));        
    }    
    
}
