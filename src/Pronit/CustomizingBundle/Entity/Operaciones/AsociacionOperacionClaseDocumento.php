<?php

namespace Pronit\CustomizingBundle\Entity\Operaciones;

use Doctrine\ORM\Mapping as ORM;
use Pronit\CoreBundle\Entity\Documentos\ClaseDocumento;
use Pronit\CoreBundle\Entity\Operaciones\Operacion;

/**
 * 
 * @author gcaseres
 * 
 * @ORM\Entity
 * @ORM\Table(name="custom_asociacionoperacionclasedocumento")
 */
class AsociacionOperacionClaseDocumento {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Documentos\ClaseDocumento")
     * @ORM\JoinColumn(nullable=false, referencedColumnName="codigo")
     */
    protected $claseDocumento;

    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Operaciones\Operacion")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $operacion;

    public function __construct() {
        
    }

    public function getId() {
        return $this->id;
    }

    public function getClaseDocumento() {
        return $this->claseDocumento;
    }

    public function getOperacion() {
        return $this->operacion;
    }

    public function setClaseDocumento(ClaseDocumento $value) {
        $this->claseDocumento = $value;
    }

    public function setOperacion(Operacion $value) {
        $this->operacion = $value;
    }

}
