<?php

namespace Pronit\GestionBienesYServiciosBundle\Entity\Customizing\Contabilidad;

use Doctrine\ORM\Mapping as ORM;

use Pronit\CustomizingBundle\Entity\Operaciones\MappingClasificadorItemOperacion;
use Pronit\GestionBienesYServiciosBundle\Entity\CategoriaValoracion;
use Pronit\CoreBundle\Entity\Contabilidad\CuentasContables\Cuenta;

/**
 * 
 *
 * @author ldelia
 * @ORM\Entity
 * @ORM\Table(name="gestionbienesyservicios_imputacioncontable")
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
     * @ORM\ManyToOne(targetEntity="Pronit\CustomizingBundle\Entity\Operaciones\MappingClasificadorItemOperacion")
     * @ORM\JoinColumn(nullable=false)
     */    
    protected $mappingClasificadorItemOperacion;    
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\GestionBienesYServiciosBundle\Entity\CategoriaValoracion")
     * @ORM\JoinColumn(nullable=false)
     */    
    protected $categoriaValoracion;    
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Contabilidad\CuentasContables\Cuenta")
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

    public function getMappingClasificadorItemOperacion()
    {
        return $this->mappingClasificadorItemOperacion;
    }

    public function getCategoriaValoracion()
    {
        return $this->categoriaValoracion;
    }

    public function getCuenta()
    {
        return $this->cuenta;
    }

    public function setMappingClasificadorItemOperacion(MappingClasificadorItemOperacion $value)
    {
        $this->mappingClasificadorItemOperacion = $value;
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

