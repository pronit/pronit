<?php
namespace Pronit\CoreBundle\Entity\Automatizacion\Secuencias;

use Doctrine\ORM\Mapping as ORM;

use Pronit\CoreBundle\Entity\Automatizacion\Secuencias\Acceso;
use Pronit\CoreBundle\Model\Automatizacion\Secuencias\IBuscadorRegistroCondicion;
use Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\ClaseCondicion;
use Doctrine\Common\Collections\ArrayCollection;

use ArrayIterator;
use IteratorAggregate;
/**
 *
 * @author ldelia
 * @ORM\Entity
 * @ORM\Table(name="core_secuencias")
 */
class Secuencia implements IteratorAggregate{
    
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
     * @ORM\OneToMany(targetEntity="Pronit\CoreBundle\Entity\Automatizacion\Secuencias\Acceso", mappedBy="secuencia", cascade={"ALL"}, orphanRemoval=true)
     */
    private $accesos;    
    
       
    public function __construct() 
    {
        $this->setAccesos(new ArrayCollection() );        
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

    public function getIterator()
    {
        $iterator = $this->getAccesos()->getIterator();
        $iterator->uasort(function (Acceso $a, Acceso $b) {
            return $a->compare($b);
        });
        return new ArrayIterator(iterator_to_array($iterator));
    }
    
    protected function getAccesos()
    {
        return $this->accesos;
    }
    
    protected function setAccesos($accesos)
    {
        $this->accesos = $accesos;
    }    
    
    public function addAcceso(Acceso $acceso)
    {
        $acceso->setSecuencia($this);
        $this->accesos[] = $acceso;
    }    
    
    /**
     * 
     * @param type $keyValues
     * @param \Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\ClaseCondicion $claseCondicion
     * @return \Pronit\CoreBundle\Entity\Automatizacion\Secuencias\RegistroCondicion | null
     */    
    public function buscar( $keyValues, ClaseCondicion $claseCondicion, IBuscadorRegistroCondicion $buscadorRegistroCondicion)
    {    
        $iterator = $this->getIterator();
        $iterator->rewind();

        $registroCondicion = null;
        while ( $iterator->valid() && is_null($registroCondicion) )
        {
            $key = $iterator->key();
            
            /* @var $acceso  \Pronit\CoreBundle\Entity\Automatizacion\Secuencias\Acceso  */
            $acceso = $iterator->current();

            $registroCondicion = $acceso->buscar($keyValues, $claseCondicion, $buscadorRegistroCondicion);            

            $iterator->next();
        }        

        return $registroCondicion;                
    }
}
