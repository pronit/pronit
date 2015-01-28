<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pronit\CustomizingBundle\Entity\Operaciones;

use Pronit\CoreBundle\Entity\Documentos\ClaseDocumento;
use Pronit\CoreBundle\Entity\Operaciones\OperacionContable;
use Doctrine\ORM\Mapping as ORM;

/**
 * 
 *
 * @author gcaseres
 * @ORM\Entity
 * @ORM\Table(name="custom_mappingclasedocumentooperacion")
 */
class MappingClaseDocumentoOperacion {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Operaciones\OperacionContable")
     * @ORM\JoinColumn(nullable=false)
     * @var OperacionContable
     */
    private $operacion;

    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Documentos\ClaseDocumento")
     * @ORM\JoinColumn(nullable=false, referencedColumnName="codigo")
     * @var ClaseDocumento
     */
    private $claseDocumento;

    public function __construct(ClaseDocumento $claseDocumento, OperacionContable $operacion) {
        $this->claseDocumento = $claseDocumento;
        $this->operacion = $operacion;
    }

    /**
     * 
     * @return OperacionContable
     */
    public function getOperacion() {
        return $this->operacion;
    }

    /**
     * 
     * @return ClaseDocumento
     */
    public function getClaseDocumento() {
        return $this->claseDocumento;
    }

}
