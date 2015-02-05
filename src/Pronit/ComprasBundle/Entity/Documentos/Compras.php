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
     * @ORM\OneToOne(targetEntity="Pronit\ComprasBundle\Entity\Documentos\Estados\EstadoCompras", cascade={"persist", "remove"}, orphanRemoval=true)
     **/    
    protected $estadoCompras;        
    
    public function __construct()
    {
        parent::__construct();
        $this->setEstadoCompras( new Inicial() );     
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
        parent::contabilizar();
        
        $this->estadoCompras = new Contabilizado();
    }
    
    public function isModificable()
    {
        return $this->getEstadoCompras() instanceof Inicial;
    }        
}

