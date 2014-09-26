<?php

namespace Pronit\ComprasBundle\Entity\Customizing\Acreedores;

use Exception;

use Doctrine\ORM\Mapping as ORM;

use Pronit\CoreBundle\Entity\Personas\Acreedor;
use Pronit\CoreBundle\Entity\Personas\Proveedor;
use Pronit\CustomizingBundle\Entity\Acreedores\AcreedorSociedadFI;
use Pronit\ParametrizacionGeneralBundle\Entity\Moneda;
/**
 *
 * @author ldelia
 * @ORM\Entity
 */
class ProveedorSociedadFI extends AcreedorSociedadFI
{    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\ParametrizacionGeneralBundle\Entity\Moneda")
     */    
    protected $monedaPedido;    

    public function setMonedaPedido(Moneda $monedaPedido)
    {
        $this->monedaPedido = $monedaPedido;
    }
    
    public function getMonedaPedido()
    {
        return $this->monedaPedido;
    }
    
    public function setAcreedor(Acreedor $acreedor)
    {
        if (! $acreedor instanceof Proveedor )
        {
            throw new Exception;
        }
        
        parent::setAcreedor($acreedor);
        
    }    
}
