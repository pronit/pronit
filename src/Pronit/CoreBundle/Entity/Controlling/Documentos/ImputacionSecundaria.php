<?php

namespace Pronit\CoreBundle\Entity\Controlling\Documentos;

use Doctrine\ORM\Mapping as ORM;

use Pronit\EstructuraEmpresaBundle\Entity\CentroLogistico;
use Pronit\ParametrizacionGeneralBundle\Entity\Moneda;
use Pronit\CoreBundle\Entity\Customizing\Deudores\DeudorSociedadFI;

use Pronit\CoreBundle\Entity\Documentos\Documento;
use Pronit\CoreBundle\Entity\Documentos\Ventas\Estados\EstadoVentas;
use Pronit\CoreBundle\Entity\Documentos\Ventas\Estados\Inicial;
use Pronit\CoreBundle\Entity\Documentos\Ventas\Estados\Contabilizado;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 *
 * @author ldelia
 * @ORM\Entity
 */
class ImputacionSecundaria extends Documento
{
    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context)
    {
        $importeTotalEmisores = 0;
        $importeTotalReceptores = 0;
        
        foreach($this->getItemsEmisor() as $itemEmisor){
            $importeTotalEmisores += $itemEmisor->getImporte();
        }
        foreach($this->getItemsReceptor() as $itemReceptor){
            $importeTotalReceptores += $itemReceptor->getImporte();
        }
        
        if ( $importeTotalEmisores !== $importeTotalReceptores ){
            $context->buildViolation('La sumatoria de los importes de los items emisor debe coincidir a la sumatoria de los importes de los items receptor')
                ->atPath('items')
                ->addViolation();            
        }
    }
    
    public function getItemsEmisor()
    {
        $itemsEmisores = new \Doctrine\Common\Collections\ArrayCollection();
        
        foreach( $this->getItems() as $item ){
            if ('Pronit\CoreBundle\Entity\Controlling\Documentos\ItemEmisor' === get_class($item)){
                $itemsEmisores->add($item);
            }
        }
        return $itemsEmisores;
    }
    
    public function getItemsReceptor()
    {
        $itemsReceptores = new \Doctrine\Common\Collections\ArrayCollection();
        
        foreach( $this->getItems() as $item ){
            if ('Pronit\CoreBundle\Entity\Controlling\Documentos\ItemReceptor' === get_class($item)){
                $itemsReceptores->add($item);
            }
        }
        return $itemsReceptores;
    }
}

