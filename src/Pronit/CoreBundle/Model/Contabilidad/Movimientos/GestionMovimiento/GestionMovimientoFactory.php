<?php
namespace Pronit\CoreBundle\Model\Contabilidad\Movimientos\GestionMovimiento;

use Pronit\CoreBundle\Entity\Contabilidad\Movimientos\Movimiento;
use Pronit\CoreBundle\Entity\Documentos\ItemFinanzas;
use Pronit\CoreBundle\Entity\Documentos\ItemFinanzasPago;
use Pronit\CoreBundle\Entity\Documentos\ItemFinanzasVisitor;


/**
 * Permite construir una instancia de Gestión de Movimientos.
 * 
 * @author gcaseres
 */
abstract class GestionMovimientoFactory implements ItemFinanzasVisitor {
    private $result;
    private $movimiento;
    
    public function create(ItemFinanzas $itemFinanzas, Movimiento $movimiento) {
        $this->movimiento = $movimiento;
        $itemFinanzas->accept($this);
        
        return $this->result;
    }
    
    protected abstract function doCreateFromItemFinanzas(ItemFinanzas $itemFinanzas, Movimiento $movimiento);
    
    protected abstract function doCreateFromItemFinanzasPago(ItemFinanzasPago $itemFinanzasPago, Movimiento $movimiento);

    public function visitItemFinanzas(ItemFinanzas $itemFinanzas) {
        $this->result = $this->doCreateFromItemFinanzas($itemFinanzas, $this->movimiento);
    }

    public function visitItemFinanzasPago(ItemFinanzasPago $itemFinanzasPago) {
        $this->result = $this->doCreateFromItemFinanzasPago($itemFinanzasPago, $this->movimiento);
    }

}
