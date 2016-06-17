<?php

namespace Pronit\CoreBundle\Controller\PlanificacionProduccion;

use Sonata\AdminBundle\Controller\CRUDController as Controller;

class VersionFabricacionController extends Controller
{
    public function crearOrdenProduccionDesdeVersionFabricacionAction($id)
    {
        return $this->redirect($this->generateUrl('pronit_ordenes_produccion_create', array( 'versionFabricacion_id' => $id ) ));
    }
}
