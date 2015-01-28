<?php

namespace Pronit\ComprasBundle\Model\Transacciones\Facturas;

use Doctrine\ORM\EntityManager;
use Exception;
use Pronit\ComprasBundle\Entity\Documentos\Facturas\Factura;
use Pronit\CoreBundle\Model\Contabilidad\Movimientos\IGeneradorAsientosContables;
use Pronit\CoreBundle\Model\Documentos\IGeneradorItemsFinanzas;

use Pronit\CoreBundle\Entity\Contabilidad\Movimientos\GestionMovimiento\GestionMovimientoDeudor;

/**
 *
 * @author ldelia
 */
class TransaccionFactura {

    protected $em;

    /** @var IGeneradorItemsFinanzas */
    protected $generadorItemsFinanzas;

    /** @var IGeneradorAsientosContables */
    protected $generadorAsientosContables;

    public function __construct(EntityManager $em, IGeneradorItemsFinanzas $generadorItemsFinanzas, IGeneradorAsientosContables $generadorAsientosContables) 
    {
        $this->em = $em;
        $this->generadorItemsFinanzas = $generadorItemsFinanzas;
        $this->generadorAsientosContables = $generadorAsientosContables;
    }

    public function ejecutar(Factura $factura) 
    {
        if (!$factura->isContabilizado()) {

            $factura->contabilizar();

            // Se generan ItemsFinanzas y se asocian a la Factura
            $this->generadorItemsFinanzas->generar($factura);
            
            // Se generan los Movimientos contables según la Factura
            $movimientos = $this->generadorAsientosContables->generarDesdeDocumento($factura);

            foreach ($movimientos as $movimiento) {
                
                // pedir su itemfi, itemfi get operacion. 
                // if operación hasPartidasAbiertas then 
                //      if acreedor de factura hasPartidadsAbiertas 
                //          crear GestionPartidasAbiertas
                
                $this->em->persist($movimiento);
                
                $gestionMovimiento = new GestionMovimientoDeudor( $movimiento );
                
                $this->em->persist($gestionMovimiento);
                
            }

            $this->em->persist($factura);
            $this->em->flush();
        } else {
            throw new Exception("La factura no puede ser contabilizada");
        }
    }
}
