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


/**
 *
 * @author ldelia
 * @ORM\Entity
 */
class ImputacionSecundaria extends Documento
{
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
    
    public function getItemsReceptores()
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

