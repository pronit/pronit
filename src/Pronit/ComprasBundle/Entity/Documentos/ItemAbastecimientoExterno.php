<?php

namespace Pronit\ComprasBundle\Entity\Documentos;

use Doctrine\ORM\Mapping as ORM;

abstract class ItemAbastecimientoExterno extends ItemCompras
{
    /**
     * @ORM\Column(type="float")
     */    
    protected $precioUnitario;    

    public function getPrecioUnitario()
    {
        return $this->precioUnitario;
    }

    public function setPrecioUnitario($precioUnitario)
    {
        $this->precioUnitario = $precioUnitario;
    }    
    
    public function getImporteNeto()
    {
        return $this->getPrecioUnitario() * $this->getCantidad();
    }
}

