<?php

namespace Pronit\ComprasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Pronit\CoreBundle\Entity\Documentos\Documento;
use Pronit\ParametrizacionGeneralBundle\Entity\Moneda;
use Pronit\EstructuraEmpresaBundle\Entity\SociedadFI;

/**
 *
 * @author ldelia
 * @ORM\Entity
 */
class Pedido extends Documento
{

    /**
     * @ORM\ManyToOne(targetEntity="Pronit\ParametrizacionGeneralBundle\Entity\Moneda")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $moneda;
    
    public function __construct(SociedadFI $sociedad, $numero, $fecha, Moneda $moneda)
    {
        parent::__construct($sociedad, $numero, $fecha);
        $this->setMoneda($moneda);  
    }   
    
    public function getMoneda()
    {
        return $this->moneda;
    }

    public function setMoneda(Moneda $moneda)
    {
        $this->moneda = $moneda;
    }   
    
    public function addItemPedido(ItemPedido $item)
    {
        parent::addItem($item);
    }
}

