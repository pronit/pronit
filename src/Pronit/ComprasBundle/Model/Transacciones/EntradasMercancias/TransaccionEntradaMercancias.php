<?php

namespace Pronit\ComprasBundle\Model\Transacciones\EntradasMercancias;

use Doctrine\ORM\EntityManager;
use Exception;
use Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\EntradaMercancias;
use Pronit\CoreBundle\Model\Contabilidad\Movimientos\IGeneradorAsientosContables;
use Pronit\CoreBundle\Model\Controlling\Documentos\IImputadorObjetosCosto;
use Pronit\CoreBundle\Model\Documentos\IGeneradorItemsFinanzas;

/**
 *
 * @author ldelia
 */
class TransaccionEntradaMercancias {

    /** @var EntityManager */
    protected $em;

    /** @var IGeneradorItemsFinanzas */
    protected $generadorItemsFinanzas;

    /** @var IGeneradorAsientosContables */
    protected $generadorAsientosContables;
    
    /** @var IImputadorObjetosCosto */
    protected $imputadorObjetosCosto;

    public function __construct(EntityManager $em, IGeneradorItemsFinanzas $generadorItemsFinanzas, IGeneradorAsientosContables $generadorAsientosContables, IImputadorObjetosCosto $imputadorObjetosCosto) {
        $this->em = $em;
        $this->generadorItemsFinanzas = $generadorItemsFinanzas;
        $this->generadorAsientosContables = $generadorAsientosContables;
        $this->imputadorObjetosCosto = $imputadorObjetosCosto;
    }

    public function ejecutar(EntradaMercancias $entradaMercancias) {
        if ($entradaMercancias->isContabilizado()) {
            throw new Exception("La entrada de mercancias no puede ser contabilizada");
        }

        $this->em->beginTransaction();
        try {
            $entradaMercancias->contabilizar();

            $this->generadorItemsFinanzas->generar($entradaMercancias);
            $movimientos = $this->generadorAsientosContables->generarDesdeDocumento($entradaMercancias);
            $this->imputadorObjetosCosto->imputar($entradaMercancias);

            foreach ($movimientos as $movimiento) {
                $this->em->persist($movimiento);
            }

            $this->em->persist($entradaMercancias);
            $this->em->flush();

            $this->em->commit();
        } catch (Exception $e) {
            $this->em->rollback();
            throw $e;
        }
    }

}
