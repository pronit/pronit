<?php

namespace Pronit\GestionMaterialesBundle\Entity\Customizing\Contabilidad;

use Doctrine\ORM\Mapping as ORM;

use Pronit\CustomizingBundle\Entity\Operaciones\AsociacionOperacionClasificadorItem;
use Pronit\GestionMaterialesBundle\Entity\CategoriaValoracion;
use Pronit\ContabilidadBundle\Entity\CuentasContables\Cuenta;

/**
 * 
 *
 * @author ldelia
 * @ORM\Entity
 * @ORM\Table(name="gmateriales_imputacioncontable")
 */
class ImputacionContable
{  
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CustomizingBundle\Entity\Operaciones\AsociacionOperacionClasificadorItem")
     * @ORM\JoinColumn(nullable=false)
     */    
    protected $asociacionOperacionClasificadorItem;    
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\GestionMaterialesBundle\Entity\CategoriaValoracion")
     * @ORM\JoinColumn(nullable=false)
     */    
    protected $categoriaValoracion;    
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\ContabilidadBundle\Entity\CuentasContables\Cuenta")
     * @ORM\JoinColumn(nullable=false)
     */    
    protected $cuenta;    
    
    public function __construct()
    {
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function getAsociacionOperacionClasificadorItem()
    {
        return $this->asociacionOperacionClasificadorItem;
    }

    public function getCategoriaValoracion()
    {
        return $this->categoriaValoracion;
    }

    public function getCuenta()
    {
        return $this->cuenta;
    }

    public function setAsociacionOperacionClasificadorItem(AsociacionOperacionClasificadorItem $asociacionOperacionClasificadorItem)
    {
        $this->asociacionOperacionClasificadorItem = $asociacionOperacionClasificadorItem;
    }

    public function setCategoriaValoracion(CategoriaValoracion $categoriaValoracion)
    {
        $this->categoriaValoracion = $categoriaValoracion;
    }

    public function setCuenta(Cuenta $cuenta)
    {
        $this->cuenta = $cuenta;
    }    
}

