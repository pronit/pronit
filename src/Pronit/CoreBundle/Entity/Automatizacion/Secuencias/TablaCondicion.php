<?php
namespace Pronit\CoreBundle\Entity\Automatizacion\Secuencias;

use Doctrine\ORM\Mapping as ORM;
use Bluegrass\Metadata\Bundle\MetadataBundle\Entity\LogicTableMetadata;
use Pronit\CoreBundle\Entity\Automatizacion\Secuencias\RegistroCondicion;

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
    protected $tableMetadata;
    
    /**
     * @ORM\OneToMany(targetEntity="Pronit\CoreBundle\Entity\Automatizacion\Secuencias\RegistroCondicion", mappedBy="tablaCondicion", cascade={"ALL"}, orphanRemoval=true)
     */
    protected $registrosCondicion;    
       
    public function __construct() 
    {
        $this->registrosCondicion = new \Doctrine\Common\Collections\ArrayCollection();        
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
    
    public function getRegistrosCondicion()
    {
        return $this->registrosCondicion;
    }

    public function addRegistroCondicion( RegistroCondicion $registroCondicion )
    {
        $registroCondicion->setTablaCondicion($this);
        $this->registrosCondicion[] = $registroCondicion;
    }
}

