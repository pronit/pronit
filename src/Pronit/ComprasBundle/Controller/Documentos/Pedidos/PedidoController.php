<?php

namespace Pronit\ComprasBundle\Controller\Documentos\Pedidos;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;

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


    /**
     * @throws NotFoundHttpException
     *
     * @param Request $request
     *
     * @return Response
     */
    public function updateItemsPedidoFormFieldElementAction(Request $request)
    {
        $elementId = $request->get('elementId');
        $objectId = $request->get('objectId');
        $uniqid = $request->get('uniqid');

        $this->admin->setRequest($request);

        if ($uniqid) {
            $this->admin->setUniqid($uniqid);
        }

        $subject = $this->admin->getModelManager()->find($this->admin->getClass(), $objectId);
        if ($objectId && !$subject) {
            throw new NotFoundHttpException();
        }

        if (!$subject) {
            $subject = $this->admin->getNewInstance();
        }

        $this->admin->setSubject($subject);
        $formBuilder = $this->admin->getFormBuilder($subject);

        $form = $formBuilder->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $subject = $form->getData();

            list(, $form) = $this->get('sonata.admin.helper')->appendFormFieldElement($this->admin, $subject, $elementId);

            $formView = $form->createView();

            $formItemView = $this->get('sonata.admin.helper')->getChildFormView( $formView, $elementId);

            return $this->render( 'PronitComprasBundle:Documentos/Pedido/CRUD:items_pedido_form_field_element.html.twig',
                                array(
                                    'id' => $elementId,
                                    'form' => $formItemView
                                )
            );
        }
    }
}
