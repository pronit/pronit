<?php
namespace Pronit\CoreBundle\Entity\Automatizacion\Secuencias;

use Doctrine\ORM\Mapping as ORM;

use Bluegrass\Metadata\Bundle\MetadataBundle\Model\Metadata;
use Bluegrass\Metadata\Bundle\MetadataBundle\Model\IMetadataEntity;


/**
 *
 * @author ldelia
 * @ORM\Entity
 * @ORM\Table(name="core_tablascondicion")
 */
class TablaCondicion implements IMetadataEntity{
    
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
    
    /**
     * @ORM\OneToMany(targetEntity="Pronit\CoreBundle\Entity\Automatizacion\Secuencias\TablaCondicionMetadataValue", mappedBy="tablaCondicion", cascade={"ALL"}, indexBy="metadataName",  orphanRemoval=true)
     */
    private $metadataValues;
    
       
    public function __construct() 
    {
        $this->metadataValues = new \Doctrine\Common\Collections\ArrayCollection();        
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

    /**
     * Determina si la entidad tiene un metadato asociado
     * @param \Bluegrass\Metadata\Bundle\MetadataBundle\Model\Metadata $metadata
     * @return boolean
     */
    public function hasMetadata( Metadata $metadata )
    {
        /* Nota: El indice está dado por la annotation indexBy del mapping */
        return isset(  $this->metadataValues[ $metadata->getName() ] );
    }
    
    /**
     * Obtiene el valor asociado a un metadato de la entidad
     * @param \Bluegrass\Metadata\Bundle\MetadataBundle\Model\Metadata $metadata
     * @return \Pronit\CoreBundle\Entity\Automatizacion\Secuencias\TablaCondicionMetadataValue
     * @throws \Exception
     */
    public function getMetadata( Metadata $metadata )
    {
        if ( ! $this->hasMetadata($metadata) ){
            throw new \Exception("La tabla condición '{$this}' no tiene definido el metadato '{$metadata}'");
        }
        
        return $metadata->getValue( $this->metadataValues[ $metadata->getName() ] );        
    }

    /**
     * Agrega el valor asociado a un metadato de la entidad
     * @param \Bluegrass\Metadata\Bundle\MetadataBundle\Model\Metadata $metadata
     * @param type $value
     */
    public function setMetadata( Metadata $metadata, $value )
    {
        if ( $this->hasMetadata($metadata) ){
            // Como se va a generar un nuevo MetadataValue, al antiguo lo descarto ( orphanremoval )
            // Todo analizar esto...
            unset( $this->metadataValues[$metadata->getName()] );
        } 
        
        /* @var $metadataValue  \Pronit\CoreBundle\Entity\Automatizacion\Secuencias\TablaCondicionMetadataValue */
        $metadataValue = $metadata->createValue($this, $value);
        
        $this->metadataValues[$metadata->getName()] = $metadataValue;
    }    
    
}

