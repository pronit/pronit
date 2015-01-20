<?php

namespace Pronit\CoreBundle\Model\Numeraciones;

use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityManager;
use Exception;
use Pronit\CoreBundle\Entity\Numeraciones\NumeracionSociedadFI;
use Pronit\EstructuraEmpresaBundle\Entity\SociedadFI;

/**
 * Description of NumeracionSociedadFIManager
 *
 * @author gcaseres
 */
class NumeracionSociedadFIManager implements INumeracionSociedadFIManager {

    /**
     *
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function generarNumeroAsiento(SociedadFI $sociedad) {
        $this->em->getConnection()->beginTransaction();

        try {
            $numeracion = $this->em->find('Pronit\CoreBundle\Entity\Numeraciones\NumeracionSociedadFI', $sociedad->getId(), LockMode::PESSIMISTIC_WRITE);
            if ($numeracion == null) {
                $numeracion = new NumeracionSociedadFI($sociedad);
                $this->em->persist($numeracion);
            }
            /* @var $numeracion NumeracionSociedadFI */
            $result = $numeracion->incrementarUltimoNumeroAsiento();
            $this->em->flush();
            $this->em->getConnection()->commit();
            return $result;
        } catch (Exception $e) {
            $this->em->getConnection()->rollback();
        }

        throw new \Exception("No se pudo generar el número de asiento.");
    }

}
