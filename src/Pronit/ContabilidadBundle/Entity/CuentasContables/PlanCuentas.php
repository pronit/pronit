<?php

namespace Pronit\ContabilidadBundle\Entity\CuentasContables;

use Doctrine\ORM\Mapping as ORM;


/**
 *
 * @author ldelia
 * @ORM\Entity
 * @ORM\Table(name="conta_placuentas")
 */
class PlanCuentas
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    protected $id;

    /**
     * @ORM\Column(type="string")
     */        
    protected $nombre;
    
    /**
     * @ORM\OneToMany(targetEntity="Pronit\ContabilidadBundle\Entity\CuentasContables\ItemPlanCuentas", mappedBy="planCuentas", cascade={"ALL"}, orphanRemoval=true)
     */
    private $items;    
    
    public function __construct()
    {
        $this->setItems( new \Doctrine\Common\Collections\ArrayCollection() );        
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getItems()
    {
        return $this->items;
    }

    protected function setItems($items)
    {
        $this->items = $items;
    }    
    
    public function addItem( $path, ItemPlanCuentas $item )
    {
        $item->setPlanCuentas($this);
        $this->items[] = $item;
    }
}
