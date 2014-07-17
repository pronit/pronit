<?php
namespace Pronit\CoreBundle\Entity\Automatizacion\Secuencias;

use Doctrine\ORM\Mapping as ORM;

use Pronit\CoreBundle\Entity\Automatizacion\Secuencias\Acceso;

/**
 *
 * @author ldelia
 * @ORM\Entity
 * @ORM\Table(name="core_secuencias")
 */
class Secuencia {
    
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
        $this->setAccesos(new \Doctrine\Common\Collections\ArrayCollection() );        
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
    
    public function getAccesos()
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
}

