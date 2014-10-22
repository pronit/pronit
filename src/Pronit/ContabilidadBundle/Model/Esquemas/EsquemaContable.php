<?php

namespace Pronit\ContabilidadBundle\Model\Esquemas;

class EsquemaContable
{
    protected $items;
    
    public function __construct()
    {
        $this->setItems(new \Doctrine\Common\Collections\ArrayCollection());
    }
    
    public function addItem(ItemEsquemaContable $item)
    {
        $this->items[] = $item;
    }
    
    /**
     * 
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getItems()
    {
        return $this->items;
    }

    protected function setItems($items)
    {
        $this->items = $items;
    }
}
