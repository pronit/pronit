<?php

namespace Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo;

use ArrayObject;
use Doctrine\Common\Collections\ArrayCollection;
use InvalidArgumentException;
use Pronit\CoreBundle\Model\Automatizacion\EsquemasCalculo\Contextos\ContextoEsquemaCalculo;
use Pronit\CoreBundle\Model\Automatizacion\EsquemasCalculo\Contextos\ContextoItemEsquemaCalculo;
use UnexpectedValueException;

/**
 * Description of EsquemaCalculo
 *
 * @author gcaseres
 */
class EsquemaCalculo {

    /** @var string */
    protected $codigo;

    /** @var string */
    protected $nombre;

    /** @var ArrayCollection */
    protected $items;

    public function __construct() {
        $this->items = new ArrayCollection();
    }

    /**
     * 
     * @param string $value
     */
    public function setCodigo($value) {
        $this->codigo = $value;
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
     * @param string $value
     */
    public function setNombre($value) {
        $this->nombre = $value;
    }

    /**
     * 
     * @return string
     */
    public function getNombre() {
        return $this->nombre;
    }

    public function addItem(ItemEsquemaCalculo $item) {
        $this->insertItem($item, $this->items->count());
        $item->setOwner($this);
    }

    public function removeItem($orden) {
        $item = $this->getItems()->offsetGet($orden);
        $item->setOwner(null);
        $this->items->removeElement($item);

        //Actualizar los ordenes de los items
        foreach ($this->items as $i) {
            if ($i->getOrden() >= $orden) {
                $i->setOrden($i->getOrden() - 1);
            }
        }
    }
    
    public function hasItem($orden) {
        return $this->getItems()->offsetExists($orden);
    }

    public function getItem($orden) {
        return $this->getItems()->offsetGet($orden);
    }

    public function moverItem(ItemEsquemaCalculo $item, $ordenDestino) {
        if (!$this->items->contains($item)) {
            throw new UnexpectedValueException("El item especificado no pertenece a este esquema.");
        }

        if ($item->getOrden() != $ordenDestino) {
            $this->removeItem($item->getOrden());
            $this->insertItem($item, $ordenDestino);
        }
    }

    public function insertItem(ItemEsquemaCalculo $item, $orden) {
        if ($item->getOwner() != null) {
            throw new InvalidArgumentException("El item especificado ya pertenece a un esquema de cálculo.");
        }

        if ($orden < 0 || $orden > $this->items->count()) {
            throw new InvalidArgumentException("El orden debe ser un valor entre 0 y la cantidad de items del esquema.");
        }

        //Actualizar los ordenes de los items        
        foreach ($this->items as $i) {
            if ($i->getOrden() >= $orden) {
                $i->setOrden($i->getOrden() + 1);
            }
        }

        $item->setOrden($orden);
        $this->items->add($item);
    }

    public function getItems() {
        $iterator = $this->items->getIterator();
        $iterator->uasort(function (ItemEsquemaCalculo $a, ItemEsquemaCalculo $b) {
            return $a->getOrden() - $b->getOrden();
        });

        return new ArrayObject(iterator_to_array($iterator, false));
    }

    /**
     * 
     * @param ContextoEsquemaCalculo $contexto
     * @return ResultadoCalculo
     */
    public function calcular(ContextoEsquemaCalculo $contexto) {
        $resultado = new ResultadoCalculo();

        foreach ($this->items as /* @var $item ItemEsquemaCalculo */ $item) {
            $item->calcular(new ContextoItemEsquemaCalculo($contexto, $item, $resultado), $resultado);
        }

        return $resultado;
    }

}
