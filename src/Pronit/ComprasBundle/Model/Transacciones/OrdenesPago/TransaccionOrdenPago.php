<?php

namespace Pronit\ComprasBundle\Model\Transacciones\OrdenesPago;

use Doctrine\ORM\EntityManager;
use Exception;

use Pronit\ComprasBundle\Entity\Documentos\OrdenesPago\OrdenPago;

/**
 *
 * @author ldelia
 */
class TransaccionOrdenPago {

    protected $em;

    public function __construct(EntityManager $em) 
    {
        $this->em = $em;
    }

    public function ejecutar(OrdenPago $ordenPago) 
    {
        if ($ordenPago->isContabilizado()) {
            throw new Exception("La orden de pago ya está contabilizada y no puede ser contabilizada nuevamente.");
        }

        $this->em->beginTransaction();
        try {
            $ordenPago->contabilizar();

            $this->em->flush();
            $this->em->commit();
        } catch (Exception $e) {
            $this->em->rollback();
            throw $e;
        }
    }

}
