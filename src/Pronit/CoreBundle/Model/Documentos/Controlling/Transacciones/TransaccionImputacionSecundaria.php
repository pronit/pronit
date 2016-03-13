<?php

namespace Pronit\CoreBundle\Model\Documentos\Controlling\Transacciones;

use Doctrine\Common\Persistence\ObjectManager;
use Exception;
use Pronit\CoreBundle\Entity\Controlling\Documentos\ImputacionSecundaria;
use Pronit\CoreBundle\Model\Documentos\Controlling\IImputadorObjetosCosto;
use Pronit\CoreBundle\Model\Documentos\IGeneradorItemsFinanzas;

/**
 *
 * @author gcaseres
 */
class TransaccionImputacionSecundaria {

    /**
     *
     * @var ObjectManager
     */
    private $em;
    
    /**
     *
     * @var IGeneradorItemsFinanzas
     */
    private $generadorItemsFinanzas;
    
    /**
     *
     * @var IImputadorObjetosCosto 
     */
    private $imputadorObjetosCosto;

    public function __construct(ObjectManager $em, IImputadorObjetosCosto $imputadorObjetosCosto) {
        $this->em = $em;
        $this->imputadorObjetosCosto = $imputadorObjetosCosto;        
    }

    public function ejecutar(ImputacionSecundaria $documento) {
        if ($documento->isContabilizado()) {
            throw new Exception("El documento especificado ya ha sido contabilizado.");
        }

        $this->em->beginTransaction();
        try {
            $documento->contabilizar();

            $this->generadorItemsFinanzas->generar($documento);
            $this->imputadorObjetosCosto->imputar($documento);
            $movimientos = $this->generadorAsientosContables->generarDesdeDocumento($documento);

            foreach ($movimientos as $movimiento) {
                $this->em->persist($movimiento);
            }

            $this->em->persist($documento);
            $this->em->flush();

            $this->em->commit();
        } catch (Exception $e) {
            $this->em->rollback();
            throw $e;
        }
    }

}
