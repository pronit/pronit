<?php

namespace Pronit\CoreBundle\Controller\Controlling\Documentos\ImputacionSecundaria;

use Sonata\AdminBundle\Controller\CRUDController as Controller;

class ImputacionSecundariaController extends Controller
{
    public function contabilizarAction($id)
    {
        /* @var $imputacionSecundaria \Pronit\CoreBundle\Entity\Controlling\Documentos\ImputacionSecundaria\ImputacionSecundaria */
        $imputacionSecundaria = $this->admin->getObject($id);
        
        /* @var $transaccionImputacionSecundaria Pronit\CoreBundle\Model\Controlling\Documentos\ImputacionSecundaria\TransaccionImputacionSecundaria */
        $transaccionImputacionSecundaria = $this->get('pronit_controlling.documentos.transaccion.imputacionsecundaria');
        $transaccionImputacionSecundaria->ejecutar($imputacionSecundaria);

        return $this->redirect( $this->generateUrl( 'pronit_controlling_documentos_imputacionsecundaria_list' ) );
    }
}
