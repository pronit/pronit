<?php

namespace Pronit\ComprasBundle\Entity\Documentos;

use Doctrine\ORM\Mapping as ORM;

use Pronit\CoreBundle\Entity\Documentos\Documento;

abstract class Compras extends Documento
{
    /** 
     * @ORM\Column(type="string") 
     */
    protected $textoCabecera;
    
    public function getTextoCabecera()
    {
        return $this->textoCabecera;
    }

    public function setTextoCabecera($textoCabecera)
    {
        $this->textoCabecera = $textoCabecera;
    }    
}

