<?php
/**
 * Created by PhpStorm.
 * User: ldelia
 * Date: 23/02/17
 * Time: 17:13
 */

namespace Pronit\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HelperController extends Controller
{

    protected function getAdminPool()
    {
        return $this->container->get('sonata.admin.pool');
    }

    public function updateRowItemsFormFieldElementAction(Request $request)
    {
        $elementId = $request->get('elementId');
        $objectId = $request->get('objectId');
        $uniqid = $request->get('uniqid');
        $adminCode = $request->get('adminCode');

        $admin = $this->getAdminPool()->getAdminByAdminCode($adminCode);
        $admin->setRequest($request);

        if ($uniqid) {
            $admin->setUniqid($uniqid);
        }

        $subject = $admin->getModelManager()->find($admin->getClass(), $objectId);
        if ($objectId && !$subject) {
            throw new NotFoundHttpException();
        }

        if (!$subject) {
            $subject = $admin->getNewInstance();
        }

        $admin->setSubject($subject);
        $formBuilder = $admin->getFormBuilder($subject);

        $form = $formBuilder->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $formView = $form->createView();

            $formItemView = $this->get('sonata.admin.helper')->getChildFormView( $formView, $elementId);

            return $this->render( '@PronitCore/Form/edit_orm_row_one_to_many.html.twig',
                array(
                    'id' => $elementId,
                    'form' => $formItemView
                )
            );
        }
    }

}