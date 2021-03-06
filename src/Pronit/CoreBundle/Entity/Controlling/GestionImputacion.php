<?php

namespace Pronit\CoreBundle\Entity\Controlling;

use Doctrine\Common\Collections\ArrayCollection;
use Pronit\CoreBundle\Entity\Documentos\Item;
use Doctrine\ORM\Mapping as ORM;

/**
 * 
 * @ORM\Entity(repositoryClass="Pronit\CoreBundle\Entity\Controlling\Repository\GestionImputacionRepository")
 * @ORM\Table(name="controlling_gestionimputacion")
 * 
 * @author gcaseres
 */
class GestionImputacion 
{
    /**
     * 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="ObjetoCosto")
     * 
     * @var ObjetoCosto
     */
    private $objetoCosto;

    /**
     * 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Documentos\Item")
     * 
     * @var Item
     */
    private $itemDocumento;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="Imputacion")
     * 
     * @var Imputacion
     */
    private $imputacionInicial;

    /**
     * 
     * @ORM\OneToMany(targetEntity="ImputacionCompensatoria", mappedBy="gestionImputacion", cascade={"ALL"})
     * 
     * @var ArrayCollection
     */
    private $imputacionesCompensatorias;

    /**
     * 
     * @ORM\Column(type="float")
     * 
     * @var float
     */
    private $importe;

    public function __construct(Imputacion $imputacionInicial) {
        $this->itemDocumento = $imputacionInicial->getItemDocumento();
        $this->objetoCosto = $imputacionInicial->getObjetoCosto();
        $this->importe = $imputacionInicial->getImporte();
        $this->imputacionInicial = $imputacionInicial;
        $this->imputacionesCompensatorias = new ArrayCollection();
    }

    public function addCompensacion(Imputacion $imputacion) {
        $this->imputacionesCompensatorias->add(new ImputacionCompensatoria($this, $imputacion));
        $this->importe += $imputacion->getImporte();
    }
    
    /**
     * 
     * @return Imputacion
     */
    public function getImputacionInicial() {
        return $this->imputacionInicial;
    }
    
    /**
     * 
     * @return ArrayCollection
     */
    public function getImputacionesCompensatorias() {
        return $this->imputacionesCompensatorias;
    }

    /**
     * 
     * @return float
     */
    public function getImporte() {
        return $this->importe;
    }

    public function __toString() 
    {
        return '$ ' . 
                number_format($this->getImporte(), 2, ',', '.')
                . " - " 
                . $this->getImputacionInicial()->getObjetoCosto() 
                . " - " 
                .  $this->getImputacionInicial()->getItemDocumento()->getPosicion() 
                . " - " 
                . $this->getImputacionInicial()->getItemDocumento()->getDocumento()->getNumero();
    }
}
