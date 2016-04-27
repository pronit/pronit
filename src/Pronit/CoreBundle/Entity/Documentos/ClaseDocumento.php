<?php

namespace Pronit\CoreBundle\Entity\Documentos;


use Doctrine\ORM\Mapping as ORM;

/**
 * Description of TipoDocumento
 * 
 * @ORM\Entity
 * @ORM\Table(name="core_clasedocumento")
 * @author gcaseres
 */
class ClaseDocumento {

    const CODIGO_PEDIDO = "PD";
    const CODIGO_FACTURAACREEDOR = "KR";
    const CODIGO_ENTRADAMERCANCIAS = "EM";
    const CODIGO_ORDENPAGO = "OP";
    
    const CODIGO_PEDIDOVENTA = "PV";
    const CODIGO_FACTURADEUDOR = "DR";
    const CODIGO_SALIDAMERCANCIAS = "SM";
    
    const CODIGO_DISTRIBUCIONSECUNDARIA = "DS";
    
    /**
     * @ORM\Column(type="string")
     * @ORM\Id
     * @var string
     */
    private $codigo;
    
    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $nombre;
    
    public function __construct($codigo, $nombre) {
        $this->codigo = $codigo;
        $this->nombre = $nombre;
    }
    
    /**
     * 
     * @return int
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * 
     * @return string
     */
    public function getCodigo() {
        return $this->codigo;
    }
    
    /**
     * 
     * @return string
     */
    public function getNombre() {
        return $this->nombre;
    }
    
    
    /**
     * 
     * @return string
     */
    public function __toString() {
        return '(' . $this->codigo . ') ' . $this->nombre;
    }
    
}
