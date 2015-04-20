<?php

namespace Pronit\ComprasBundle\Controller\Documentos\OrdenesPago;

use Sonata\AdminBundle\Controller\CRUDController as Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

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
    
    public function renderGestionMovimientoListAction($id)
    {
        $proveedorSociedadFI = $this->getDoctrine()->getRepository('Pronit\ComprasBundle\Entity\Customizing\Acreedores\ProveedorSociedadFI')->find( $id );
        $acreedor = $proveedorSociedadFI ->getAcreedor();
        
        $gestionesMovimientoAcreedor = $this->getDoctrine()->getRepository('Pronit\CoreBundle\Entity\Contabilidad\Movimientos\GestionMovimiento\GestionMovimientoAcreedor')->findByAcreedor( $acreedor );

        $options = array();
                
        foreach( $gestionesMovimientoAcreedor as $gestionMovimientoAcreedor ){
            $numeroDocumento = $gestionMovimientoAcreedor->getMovimientoGestionado()->getItemFinanzas()->getDocumento()->getNumero();
            $fechaDocumento = $gestionMovimientoAcreedor->getMovimientoGestionado()->getItemFinanzas()->getDocumento()->getFecha();
            $fechaVto = $gestionMovimientoAcreedor->getFechaVencimiento();
            $importe = $gestionMovimientoAcreedor->getImporteSinCompensar();
            //$options[ $gestionMovimientoAcreedor->getId() ] = '[' . $numeroDocumento . '] - ' . $importe;
            $options[$gestionMovimientoAcreedor->getId()]['fecha_documento'] = array('d' => $fechaDocumento->format('d'), 'm' => $fechaDocumento->format('m'), 'y' => $fechaDocumento->format('Y'));
            $options[$gestionMovimientoAcreedor->getId()]['fecha_vencimiento'] = array('d' => $fechaVto->format('d'), 'm' => $fechaVto->format('m'), 'y' => $fechaVto->format('Y'));
            $options[$gestionMovimientoAcreedor->getId()]['numero_documento'] = $numeroDocumento;
            $options[$gestionMovimientoAcreedor->getId()]['importe'] = $importe;
        }
        
        return new JsonResponse( array('options' => $options ));
    }    
    
}
