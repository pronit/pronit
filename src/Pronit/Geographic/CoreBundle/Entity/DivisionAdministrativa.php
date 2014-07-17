<?php

namespace Pronit\Geographic\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Bluegrass\Metadata\Bundle\MetadataBundle\Model\Metadata;
use Bluegrass\Metadata\Bundle\MetadataBundle\Model\IMetadataEntity;

/**
 * Representa una división geográfica.
 * Actua como un aggregate root con sus metadata
 *
 * @author ldelia
 */
/** 
 * @ORM\Entity
  * @ORM\Table(name="geo_divisionadministrativa")
 */
class DivisionAdministrativa implements IMetadataEntity
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
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\Geographic\CoreBundle\Entity\TipoDivisionAdministrativa")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $tipo;

    /**
     * @ORM\ManyToOne(targetEntity="Pronit\Geographic\CoreBundle\Entity\DivisionAdministrativa")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $parent;
    
    /**
     * @ORM\OneToMany(targetEntity="Pronit\Geographic\CoreBundle\Entity\DivisionAdministrativaMetadataValue", mappedBy="divisionAdministrativa", cascade={"ALL"}, indexBy="metadataName",  orphanRemoval=true)
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

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    
    public function getTipo()
    {
        return $this->tipo;
    }

    public function setTipo(TipoDivisionAdministrativa $tipo)
    {
        $this->tipo = $tipo;
    }    
    
    public function getParent()
    {
        return $this->parent;
    }

    public function setParent(DivisionAdministrativa $parent)
    {
        $this->parent = $parent;
    }    

    /**
     * Determina si la División Administrativa tiene un metadato asociado
     * @param Bluegrass\Metadata\Bundle\MetadataBundle\Model\Metadata $metadata
     * @return boolean
     */
    public function hasMetadata( Metadata $metadata )
    {
        /* Nota: El indice está dado por la annotation indexBy del mapping */
        return isset(  $this->metadataValues[ $metadata->getName() ] );
    }
    
    /**
     * Obtiene el valor asociado a un metadato de una división administrativa
     * @param \Bluegrass\Metadata\Bundle\MetadataBundle\Model\Metadata $metadata
     * @return \Pronit\Geographic\CoreBundle\Entity\DivisionAdministrativaMetadataValue
     * @throws \Exception
     */
    public function getMetadata( Metadata $metadata )
    {
        if ( ! $this->hasMetadata($metadata) ){
            throw new \Exception("La división administrativa '{$this}' no tiene definido el metadato '{$metadata}'");
        }
        
        return $metadata->getValue( $this->metadataValues[ $metadata->getName() ] );        
    }

    /**
     * Agrega el valor asociado a un metadato de una división administrativa
     * @param Bluegrass\Metadata\Bundle\MetadataBundle\Model\Metadata $metadata
     * @param type $value
     */
    public function setMetadata( Metadata $metadata, $value )
    {
        if ( $this->hasMetadata($metadata) ){
            // Como se va a generar un nuevo MetadataValue, al antiguo lo descarto ( orphanremoval )
            // Todo analizar esto...
            unset( $this->metadataValues[$metadata->getName()] );
        } 
        
        /* @var $metadataValue  \Pronit\Geographic\CoreBundle\Entity\DivisionAdministrativaMetadataValue */
        $metadataValue = $metadata->createValue($this, $value);
        
        $this->metadataValues[$metadata->getName()] = $metadataValue;
    }    
        
    public function __toString()
    {
        $nombre = "";
        if( !is_null( $this->getParent()) ){
            $nombre = $this->getParent()->__toString()  . ", ";
        }
        
        $nombre = $nombre . $this->getNombre();
        
        return $nombre;
    }
}

