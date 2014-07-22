<?php
namespace Pronit\CoreBundle\Entity\Automatizacion\Secuencias;

use Doctrine\ORM\Mapping as ORM;
use Bluegrass\Metadata\Bundle\MetadataBundle\Entity\LogicTableMetadata;

/**
 *
 * @author ldelia
 * @ORM\Entity
 * @ORM\Table(name="core_tablascondicion")
 */
class TablaCondicion {
    
   /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    protected $id;
    
    /** 
     * @ORM\Column(type="string", length=8)
     */        
    protected $codigo;

    /** 
     * @ORM\Column(type="string", length=60)
     */
    protected $descripcion;
    
    /** @ORM\ManyToOne(targetEntity="Bluegrass\Metadata\Bundle\MetadataBundle\Entity\LogicTableMetadata") */
    private $tableMetadata;
    
       
    public function __construct() 
    {
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function getCodigo()
    {
        return $this->codigo;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }
    
    public function getTableMetadata()
    {
        return $this->tableMetadata;
    }

    public function setTableMetadata(LogicTableMetadata $tableMetadata)
    {
        $this->tableMetadata = $tableMetadata;
    }
}

