<?php

namespace Pronit\CoreBundle\Model\Transacciones\SalidasMercancias;

use Doctrine\ORM\EntityManager;
use Exception;
use Pronit\CoreBundle\Entity\Documentos\Ventas\SalidasMercancias\SalidaMercancias;

/**
 *
 * @author ldelia
 */
class TransaccionSalidaMercancias {

    /** @var EntityManager */
    protected $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function ejecutar(SalidaMercancias $salidaMercancias) {
        if ($salidaMercancias->isContabilizado()) {
            throw new Exception("La salida de mercancias no puede ser contabilizada");
        }

        $this->em->beginTransaction();
        try {
            $salidaMercancias->contabilizar();

// TODO
//            $this->generadorItemsFinanzas->generar($entradaMercancias);
//            $movimientos = $this->generadorAsientosContables->generarDesdeDocumento($entradaMercancias);
//
//            foreach ($movimientos as $movimiento) {
//                $this->em->persist($movimiento);
//            }

            $this->em->persist($salidaMercancias);
            $this->em->flush();

            $this->em->commit();
        } catch (Exception $e) {
            $this->em->rollback();
            throw $e;
        }
    }
}