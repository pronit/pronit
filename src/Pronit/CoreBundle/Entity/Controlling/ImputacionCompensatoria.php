<?php

namespace Pronit\CoreBundle\Entity\Controlling;

use Doctrine\ORM\Mapping as ORM;


/**
 *
 * @ORM\Entity
 * @ORM\Table(
 *  name="controlling_imputacioncompensatoria",
 *  uniqueConstraints={@ORM\UniqueConstraint(name="imputacioncompensatoria_unique",columns={"objetoCosto_id", "itemDocumento_id"})},
 * )
 * 
 * @author gcaseres
 */
class ImputacionCompensatoria {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Imputacion")
     * @ORM\JoinColumns({
     *  @ORM\JoinColumn(name="objetoCosto_id", referencedColumnName="objetoCosto_id"),
     *  @ORM\JoinColumn(name="itemDocumento_id", referencedColumnName="itemDocumento_id")
     * })
     * 
     * @var Imputacion
     */
    private $imputacion;

    /**
     *
     * @ORM\ManyToOne(targetEntity="GestionImputacion", inversedBy="imputacionesCompensatorias")
     * @ORM\JoinColumns({
     *  @ORM\JoinColumn(name="objetoCosto_id", referencedColumnName="objetoCosto_id"),
     *  @ORM\JoinColumn(name="itemDocumento_id", referencedColumnName="itemDocumento_id")
     * })
     * 
     * @var GestionImputacion
     */
    private $gestionImputacion;

    public function __construct(GestionImputacion $gestionImputacion, Imputacion $imputacion) {
        $this->imputacion = $imputacion;
        $this->gestionImputacion = $gestionImputacion;
    }

    /**
     * 
     * @return Imputacion
     */
    public function getImputacion() {
        return $this->imputacion;
    }

}
