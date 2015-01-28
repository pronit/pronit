<?php

namespace Pronit\ComprasBundle\Model\Transacciones\Facturas;

use Doctrine\ORM\EntityManager;
use Exception;
use Pronit\ComprasBundle\Entity\Documentos\Facturas\Factura;
use Pronit\CoreBundle\Model\Contabilidad\Movimientos\IGeneradorAsientosContables;
use Pronit\CoreBundle\Model\Documentos\IGeneradorItemsFinanzas;

/**
 *
 * @author ldelia
 */
class TransaccionFactura {

    protected $em;

    /** @var IGeneradorItemsFinanzas */
    protected $generadorItemsFinanzas;

    /** @var IGeneradorAsientosContables */
    protected $generadorAsientosContables;

    public function __construct(EntityManager $em, IGeneradorItemsFinanzas $generadorItemsFinanzas, IGeneradorAsientosContables $generadorAsientosContables) {
        $this->em = $em;
        $this->generadorItemsFinanzas = $generadorItemsFinanzas;
        $this->generadorAsientosContables = $generadorAsientosContables;
    }

    public function ejecutar(Factura $factura) {
        if (!$factura->isContabilizado()) {
            throw new Exception("La factura ya está contabilizada y no puede ser contabilizada nuevamente.");
        }

        $this->em->beginTransaction();
        try {
            $factura->contabilizar();

            $this->generadorItemsFinanzas->generar($factura);
            $movimientos = $this->generadorAsientosContables->generarDesdeDocumento($factura);

            foreach ($movimientos as $movimiento) {
                $this->em->persist($movimiento);
            }

            $this->em->persist($factura);
            $this->em->flush();
            $this->em->commit();
        } catch (Exception $e) {
            $this->em->rollback();
            throw $e;
        }
    }

}
