<?php

namespace Pronit\CoreBundle\Model\Controlling\Documentos\ImputacionSecundaria;

use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Exception;
use Pronit\CoreBundle\Entity\Contabilidad\CuentasContables\Cuenta;
use Pronit\CoreBundle\Entity\Controlling\Documentos\ImputacionSecundaria;
use Pronit\CoreBundle\Entity\Controlling\Documentos\ItemEmisor;
use Pronit\CoreBundle\Entity\Controlling\Documentos\ItemImputacionSecundaria;
use Pronit\CoreBundle\Entity\Controlling\Documentos\ItemReceptor;
use Pronit\CoreBundle\Entity\Controlling\GestionImputacion;
use Pronit\CoreBundle\Entity\Controlling\Imputacion;
use Pronit\CoreBundle\Entity\Controlling\Repository\IGestionImputacionRepository;
use Pronit\CoreBundle\Entity\Documentos\Documento;
use Pronit\CoreBundle\Entity\Documentos\ItemFinanzas;
use Pronit\CoreBundle\Model\Aspectos\IAspectoManager;
use Pronit\CoreBundle\Model\Controlling\Documentos\IImputadorObjetosCosto;

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
    
    /**
     *
     * @var IGestionImputacionRepository
     */
    private $gestionImputacionRepository;    

    public function __construct(ObjectManager $em,  IGestionImputacionRepository $gestionImputacionRepository, IAspectoManager $imputaObjetoCostosManager) {
        $this->em = $em;
        $this->imputaObjetoCostosManager = $imputaObjetoCostosManager;
        $this->gestionImputacionRepository = $gestionImputacionRepository;
    }

    /**
     * 
     * {@inheritdoc}
     */    
    public function imputar(Documento $documento) {
        return $this->imputarImputacionSecundaria($documento);
    }

    private function imputarImputacionSecundaria(ImputacionSecundaria $documento) {
        foreach ($documento->getItemsFinanzas() as /* @var $item ItemFinanzas */ $item) {
            if ($item->getItemDocumento() !== null) {
                $this->imputarItem($item);
            }
        }
    }

    private function imputarItem(ItemFinanzas $item) {
        /* @var $itemDocumento ItemImputacionSecundaria */
        $itemDocumento = $item->getItemDocumento();
        if ($this->imputaObjetoCostosManager->has($item->getOperacion()) && !is_null($itemDocumento->getObjetoCosto())) {

            switch (get_class($itemDocumento)) {
                case 'Pronit\CoreBundle\Entity\Controlling\Documentos\ItemEmisor':
                    $this->imputarItemEmisor($itemDocumento, $item->getCuenta(), $item->getImporte());
                    break;
                case 'Pronit\CoreBundle\Entity\Controlling\Documentos\ItemReceptor':
                    $this->imputarItemReceptor($itemDocumento, $item->getCuenta(), $item->getImporte());
                    break;
                default:
                    throw new Exception('Este imputador no es capaz de imputar a partir del tipo de item contenido en el documento.');
            }
        }
    }

    private function imputarItemEmisor(ItemEmisor $itemDocumento, Cuenta $cuentaContable, $importe) {
        $imputacion = $itemDocumento->getObjetoCosto()->imputar(new DateTime(), $itemDocumento, $cuentaContable, -$importe);
        $this->em->persist($imputacion);
        
        $gestionImputacion = $this->gestionImputacionRepository->find(array(
            'itemDocumento' => $itemDocumento->getGestionImputacion()->getImputacionInicial()->getItemDocumento(),
            'objetoCosto' => $itemDocumento->getGestionImputacion()->getImputacionInicial()->getObjetoCosto()
        ));
        
        if (is_null($gestionImputacion)) {
            throw new Exception('Se esperaba una gestión de imputaciones abiertas para poder generar la compensación de imputación.');
        }

        $gestionImputacion->addCompensacion($imputacion);
    }

    private function imputarItemReceptor(ItemReceptor $itemDocumento, Cuenta $cuentaContable, $importe) {
        /* @var $imputacion Imputacion */
        $imputacion = $itemDocumento->getObjetoCosto()->imputar(new DateTime(), $itemDocumento, $cuentaContable, $importe);
        $this->em->persist($imputacion);

        $gestionImputacion = new GestionImputacion($imputacion);
        $this->gestionImputacionRepository->add($gestionImputacion);

    }

}
