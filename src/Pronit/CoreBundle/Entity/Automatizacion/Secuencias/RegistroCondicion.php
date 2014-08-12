<?php
namespace Pronit\CoreBundle\Entity\Automatizacion\Secuencias;

use Doctrine\ORM\Mapping as ORM;
use Pronit\CoreBundle\Entity\Automatizacion\Secuencias\TablaCondicion;

use Pronit\CoreBundle\Entity\Automatizacion\Secuencias\RegistroCondicionMetadataValue;

use Bluegrass\Metadata\Bundle\MetadataBundle\Model\Metadata;
use Bluegrass\Metadata\Bundle\MetadataBundle\Model\IMetadataEntity;

/**
 *
 * @author ldelia
 * @ORM\Entity
 * @ORM\Table(name="core_registrocondicion")
 */
class RegistroCondicion implements IMetadataEntity
{
    
   /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    protected $id;    
    
    /** 
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Automatizacion\Secuencias\TablaCondicion") 
     */
    protected $tablaCondicion;
    
    /**
     * @ORM\OneToMany(targetEntity="Pronit\CoreBundle\Entity\Automatizacion\Secuencias\RegistroCondicionMetadataValue", mappedBy="registroCondicion", cascade={"ALL"}, indexBy="metadataName",  orphanRemoval=true)
     */
    protected $claves;    
            
    public function __construct() 
    {
        $this->claves = new \Doctrine\Common\Collections\ArrayCollection();                
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getTablaCondicion()
    {
        return $this->tablaCondicion;
    }

    public function setTablaCondicion(TablaCondicion $tablaCondicion)
    {
        $this->tablaCondicion = $tablaCondicion;
    }
        
    public function setClave( Metadata $metadata, $value )
    {        
        $this->setMetadata($metadata, $value);
    }
       
    /**
     * Determina si la entidad tiene un metadato asociado
     * @param \Bluegrass\Metadata\Bundle\MetadataBundle\Model\Metadata $metadata
     * @return boolean
     */
    public function hasMetadata( Metadata $metadata )
    {
        /* Nota: El indice está dado por la annotation indexBy del mapping */
        return isset(  $this->claves[ $metadata->getName() ] );
    }
    
    /**
     * Obtiene el valor asociado a un metadato de la entidad
     * @param \Bluegrass\Metadata\Bundle\MetadataBundle\Model\Metadata $metadata
     * @return \Pronit\CoreBundle\Entity\Automatizacion\Secuencias\RegistroCondicionMetadataValue
     * @throws \Exception
     */
    public function getMetadata( Metadata $metadata )
    {
        if ( ! $this->hasMetadata($metadata) ){
            throw new \Exception("La tabla condición '{$this}' no tiene definido el metadato '{$metadata}'");
        }
        
        return $metadata->getValue( $this->claves[ $metadata->getName() ] );        
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
            unset( $this->claves[$metadata->getName()] );
        } 
        
        /* @var $metadataValue  \Pronit\CoreBundle\Entity\Automatizacion\Secuencias\RegistroCondicionMetadataValue */
        $metadataValue = $metadata->createValue($this, $value);
        
        $this->claves[$metadata->getName()] = $metadataValue;
    }        
}

