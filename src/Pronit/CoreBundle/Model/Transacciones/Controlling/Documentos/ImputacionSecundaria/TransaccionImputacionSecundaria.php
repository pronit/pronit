<?php

namespace Pronit\CoreBundle\Model\Transacciones\Controlling\Documentos\ImputacionSecundaria;

use Doctrine\ORM\EntityManager;
use Exception;
use Pronit\CoreBundle\Entity\Controlling\Documentos\ImputacionSecundaria;
use Pronit\CoreBundle\Model\Contabilidad\Movimientos\IGeneradorAsientosContables;
use Pronit\CoreBundle\Model\Controlling\Documentos\IImputadorObjetosCosto;
use Pronit\CoreBundle\Model\Documentos\IGeneradorItemsFinanzas;

/**
 *
 * @author ldelia
 */
class TransaccionImputacionSecundaria
{
    /** @var EntityManager */
    protected $em;

    /** @var IGeneradorItemsFinanzas */
    protected $generadorItemsFinanzas;

    /** @var IGeneradorAsientosContables */
    protected $generadorAsientosContables;
    
    /** @var IImputadorObjetosCosto */
    protected $imputadorObjetosCosto;

    public function __construct(EntityManager $em, IGeneradorItemsFinanzas $generadorItemsFinanzas, IGeneradorAsientosContables $generadorAsientosContables, IImputadorObjetosCosto $imputadorObjetosCosto) 
    {
        $this->em = $em;
        $this->generadorItemsFinanzas = $generadorItemsFinanzas;
        $this->generadorAsientosContables = $generadorAsientosContables;
        $this->imputadorObjetosCosto = $imputadorObjetosCosto;
    }

    public function ejecutar(ImputacionSecundaria $imputacionSecundaria) 
    {
        if ($imputacionSecundaria->isContabilizado()) {
            throw new Exception("La imputación secundaria no puede ser contabilizada");
        }

        $this->em->beginTransaction();
        try {
            $imputacionSecundaria->contabilizar();

            $this->generadorItemsFinanzas->generar($imputacionSecundaria);
            $movimientos = $this->generadorAsientosContables->generarDesdeDocumento($imputacionSecundaria);
            $this->imputadorObjetosCosto->imputar($imputacionSecundaria);

            foreach ($movimientos as $movimiento) {
                $this->em->persist($movimiento);
            }

            $this->em->persist($imputacionSecundaria);
            $this->em->flush();

            $this->em->commit();
        } catch (Exception $e) {
            $this->em->rollback();
            throw $e;
        }
    }
}