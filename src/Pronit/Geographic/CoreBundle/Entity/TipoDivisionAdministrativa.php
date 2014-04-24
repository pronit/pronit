<?php

namespace Pronit\Geographic\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Description of TipoDivisionAdministrativa
 *
 * @author ldelia
 * @ORM\Entity
 * @ORM\Table(name="geo_tipodivisionadministrativa")
 */
class TipoDivisionAdministrativa
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;    
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $nombre;

    public function __construct( $nombre )
    {
        $this->setNombre($nombre);
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    protected function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    
    public function getId()
    {
        return $this->id;
    }    
    
}

