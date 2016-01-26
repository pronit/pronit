<?php

namespace Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones;

use Doctrine\ORM\Mapping as ORM;

/**
 * 
 *
 * @ORM\MappedSuperclass
 */
abstract class Presentacion
{
    /**
     * @ORM\Column(type="string", length=50)
     */        
    protected $nombre;    
}
