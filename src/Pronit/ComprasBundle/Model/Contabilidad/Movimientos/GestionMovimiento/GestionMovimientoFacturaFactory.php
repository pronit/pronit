<?php
namespace Pronit\ComprasBundle\Model\Contabilidad\Movimientos\GestionMovimiento;

use Pronit\ComprasBundle\Entity\Documentos\Facturas\Factura;
use Pronit\CoreBundle\Entity\Contabilidad\Movimientos\GestionMovimiento\GestionMovimientoAcreedor;
use Pronit\CoreBundle\Entity\Contabilidad\Movimientos\Movimiento;
use Pronit\CoreBundle\Entity\Documentos\ItemFinanzas;
use Pronit\CoreBundle\Entity\Documentos\ItemFinanzasPago;
use Pronit\CoreBundle\Model\Contabilidad\Movimientos\GestionMovimiento\GestionMovimientoFactory;

/**
 * Permite construir una instancia de Gestión de Movimientos.
 * 
 * Esta implementación solo puede construir una Gestión de Movimientos a partir
 * de un ItemFinanzas de Pagos. Ya que necesita obtener información de la 
 * condición de pagos asociada a la factura.
 * 
 * @author gcaseres
 */
class GestionMovimientoFacturaFactory extends GestionMovimientoFactory {
    
    /**
     *
     * @var Factura
     */
    private $factura;
    
    public function __construct(Factura $factura) {
        $this->factura = $factura;
    }
    
    protected function doCreateFromItemFinanzas(ItemFinanzas $itemFinanzas, Movimiento $movimiento) {
        throw new \Exception("Error de configuración. No es posible generar una gestión de movimientos para un item finanzas abstracto desde un documento de factura de compras.");
    }

    protected function doCreateFromItemFinanzasPago(ItemFinanzasPago $itemFinanzasPago, Movimiento $movimiento) {
        $fechaVto = $this->factura->getCondicionPagos()->calcularFechaVencimientoPago($itemFinanzasPago->getNumeroPago(), $this->factura->getFecha());
        return new GestionMovimientoAcreedor($movimiento, $this->factura->getProveedorSociedad()->getAcreedor(), $fechaVto);
    }

}
