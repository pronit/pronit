<?php

namespace Pronit\CoreBundle\Model\Controlling\Documentos;

use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
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

    public function __construct(ObjectManager $em, IGestionImputacionRepository $gestionImputacionRepository, IAspectoManager $imputaObjetoCostosManager) {
        $this->em = $em;
        $this->imputaObjetoCostosManager = $imputaObjetoCostosManager;
        $this->gestionImputacionRepository = $gestionImputacionRepository;
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function imputar(Documento $documento) {
        foreach ($documento->getItemsFinanzas() as /* @var $item ItemFinanzas */ $item) {
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
            $this->gestionImputacionRepository->add($gestionImputacion);
        }
    }

}
