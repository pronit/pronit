<?php

namespace Pronit\CoreBundle\Model\Contabilidad\Esquemas;

use Doctrine\Common\Collections\ArrayCollection;
use Pronit\CoreBundle\Entity\Documentos\Documento;

class EsquemaContable
{
    protected $items;
    
    /**
     *
     * @var Documento 
     */
    private $documento;
    
    public function __construct(Documento $documento)
    {
        $this->documento = $documento;
        $this->setItems(new ArrayCollection());
    }
    
    /**
     * 
     * @return Documento
     */
    public function getDocumento() {
        return $this->documento;
    }
    
    public function addItem(ItemEsquemaContable $item)
    {
        $this->items[] = $item;
    }
    
    /**
     * 
     * @return ArrayCollection
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
