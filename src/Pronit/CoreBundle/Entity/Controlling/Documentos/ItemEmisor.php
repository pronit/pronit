<?php

namespace Pronit\CoreBundle\Entity\Controlling\Documentos;

use Doctrine\ORM\Mapping as ORM;
use Pronit\CoreBundle\Entity\Controlling\Imputacion;
use Pronit\CoreBundle\Entity\Controlling\GestionImputacion;
/**
 *
 * @author ldelia
 * @ORM\Entity
 */

class ItemEmisor extends ItemImputacionSecundaria 
{
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Controlling\GestionImputacion") 
     * @ORM\JoinColumns({
     *  @ORM\JoinColumn(name="objetoCosto_id", referencedColumnName="objetoCosto_id"),
     *  @ORM\JoinColumn(name="itemDocumento_id", referencedColumnName="itemDocumento_id")     
     * })
     */
    protected $gestionImputacion;
    /**
     * 
     * @return GestionImputacion
     */
    function getGestionImputacion() 
    {
        return $this->gestionImputacion;
    }

    function setGestionImputacion(GestionImputacion $gestionImputacion) 
    {
        $this->gestionImputacion = $gestionImputacion;
    }    

    /**
     * 
     * @return ObjetoCostro
     */
    public function getObjetoCosto() 
    {
        return $this->gestionImputacion->getImputacionInicial()->getObjetoCosto();
    }

}
