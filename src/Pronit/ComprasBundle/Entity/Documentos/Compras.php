<?php

namespace Pronit\ComprasBundle\Entity\Documentos;

use Doctrine\ORM\Mapping as ORM;

use Pronit\CoreBundle\Entity\Documentos\Documento;
use Pronit\ComprasBundle\Entity\Documentos\Estados\EstadoCompras;
use Pronit\ComprasBundle\Entity\Documentos\Estados\Inicial;
use Pronit\ComprasBundle\Entity\Documentos\Estados\Contabilizado;

abstract class Compras extends Documento
{
    /** 
     * @ORM\Column(type="string") 
     */
    protected $textoCabecera;
    
    /**
     * @ORM\OneToOne(targetEntity="Pronit\ComprasBundle\Entity\Documentos\Estados\EstadoCompras", cascade={"persist", "remove"}, orphanRemoval=true)
     **/    
    protected $estadoCompras;    
    
    /** 
     * @ORM\Column(type="boolean") 
     */
    protected $contabilizado;    
    
    public function __construct()
    {
        parent::__construct();
        $this->setEstadoCompras( new Inicial() );
        $this->contabilizado = false;        
    }    
    
    public function getTextoCabecera()
    {
        return $this->textoCabecera;
    }

    public function setTextoCabecera($textoCabecera)
    {
        $this->textoCabecera = $textoCabecera;
    }    
    
    public function getEstadoCompras()
    {
        return $this->estadoCompras;
    }

    protected function setEstadoCompras(EstadoCompras $estadoCompras)
    {
        $this->estadoCompras = $estadoCompras;
    }    
    
    public function contabilizar()
    {
        $this->estadoCompras = new Contabilizado();
        $this->contabilizado = true;        
    }
    
    public function isModificable()
    {
        return $this->getEstadoCompras() instanceof Inicial;
    }
    
    public function isContabilizado()
    {
        return $this->contabilizado;
    }
    
}

