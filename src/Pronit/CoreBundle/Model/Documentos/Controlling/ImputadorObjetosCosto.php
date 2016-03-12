<?php

namespace Pronit\CoreBundle\Model\Documentos\Controlling;

use ArrayObject;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\EntradaMercancias;
use Pronit\CoreBundle\Entity\Controlling\GestionImputacion;
use Pronit\CoreBundle\Entity\Controlling\Imputacion;
use Pronit\CoreBundle\Entity\Documentos\Documento;
use Pronit\CoreBundle\Entity\Documentos\ItemFinanzas;
use Pronit\CoreBundle\Entity\Documentos\ItemFinanzasEntradaMercancias;
use Pronit\CoreBundle\Model\Aspectos\IAspectoManager;
use Pronit\CoreBundle\Model\Documentos\Controlling\IImputadorObjetosCosto;

/**
 * @author ldelia
 */
class ImputadorObjetosCosto implements IImputadorObjetosCosto {

    /**
     *
     * @var ObjectManager
     */
    private $em;

    /**
     *
     * @var IAspectoManager
     */
    private $imputaObjetoCostosManager;

    public function __construct(ObjectManager $em, IAspectoManager $imputaObjetoCostosManager) {
        $this->em = $em;
        $this->imputaObjetoCostosManager = $imputaObjetoCostosManager;
    }

    public function imputar(Documento $documento) {
        foreach ($documento->getItemsFinanzas() as /* @var $item ItemFinanzasEntradaMercancias */ $item) {
            if ($item->getItemDocumento() !== null) {
                $this->imputarItem($item);
            }
        }
    }

    private function imputarItem(ItemFinanzas $item) {
        if ($this->imputaObjetoCostosManager->has($item->getOperacion()) && !is_null($item->getItemDocumento()->getObjetoCosto())) {
            /* @var $imputacion Imputacion */
            $imputacion = $item->getItemDocumento()->getObjetoCosto()->imputar(new DateTime(), $item->getItemDocumento(), $item->getCuenta(), $item->getImporte());
            $this->em->persist($imputacion);
            $gestionImputacion = new GestionImputacion($imputacion);
            $this->em->persist($gestionImputacion);
        }
    }

    function imputar_deprecated(EntradaMercancias $entradaMercancias) {
        $imputaciones = new ArrayObject();

        $hashMap = array();

        foreach ($entradaMercancias->getItemsFinanzas() as /* @var $item ItemFinanzasEntradaMercancias */ $item) {

            if (!is_null($item->getObjetoCosto())) {

                if (!isset($imputaciones[spl_object_hash($item->getObjetoCosto())])) {

                    $cuentas = new ArrayObject();
                    $hashKey = spl_object_hash($item->getObjetoCosto());

                    $hashMap[$hashKey] = $item->getObjetoCosto();
                    $imputaciones[$hashKey] = $cuentas;
                } else {
                    $cuentas = $imputaciones[spl_object_hash($item->getObjetoCosto())];
                }

                if (!isset($cuentas[spl_object_hash($item->getCuenta())])) {
                    $monto = 0;

                    $hashKey = spl_object_hash($item->getCuenta());

                    $hashMap[$hashKey] = $item->getCuenta();
                    $cuentas[$hashKey] = $monto;
                } else {
                    $monto = $cuentas[spl_object_hash($item->getCuenta())];
                }

                $monto += $item->getImporte();

                $cuentas[spl_object_hash($item->getCuenta())] = $monto;
            }
        }

        foreach ($imputaciones as $hashObjetoCosto => $cuentas) {

            foreach ($cuentas as $hashCuenta => $monto) {

                $objetoCosto = $hashMap[$hashObjetoCosto];
                $cuentaContable = $hashMap[$hashCuenta];

                $imputacion = new Imputacion();
                $imputacion->setFecha($entradaMercancias->getFecha());
                $imputacion->setImporte($monto);
                $imputacion->setCuentaContable($cuentaContable);
                $imputacion->setObjetoCosto($objetoCosto);
                $imputacion->setItem($item);

                $this->em->persist($imputacion);
            }
        }
    }

}
