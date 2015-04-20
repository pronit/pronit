<?php

namespace Pronit\ComprasBundle\Model\Transacciones\Facturas;

use Doctrine\ORM\EntityManager;
use Exception;
use Pronit\ComprasBundle\Entity\Documentos\Facturas\Factura;
use Pronit\ComprasBundle\Model\Contabilidad\Movimientos\GestionMovimiento\GestionMovimientoFacturaFactory;
use Pronit\CoreBundle\Entity\Contabilidad\Movimientos\GestionMovimiento\GestionMovimientoAcreedor;
use Pronit\CoreBundle\Entity\Contabilidad\Movimientos\Movimiento;
use Pronit\CoreBundle\Model\Contabilidad\Movimientos\IGeneradorAsientosContables;
use Pronit\CoreBundle\Model\Documentos\IGeneradorItemsFinanzas;

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

    public function __construct(EntityManager $em, IGeneradorItemsFinanzas $generadorItemsFinanzas, IGeneradorAsientosContables $generadorAsientosContables) {
        $this->em = $em;
        $this->generadorItemsFinanzas = $generadorItemsFinanzas;
        $this->generadorAsientosContables = $generadorAsientosContables;
    }

    public function ejecutar(Factura $factura) 
    {
        if ($factura->isContabilizado()) {
            throw new Exception("La factura ya está contabilizada y no puede ser contabilizada nuevamente.");
        }

        $this->em->beginTransaction();
        try {
            $factura->contabilizar();

            $this->generadorItemsFinanzas->generar($factura);
            $movimientos = $this->generadorAsientosContables->generarDesdeDocumento($factura);
            
            $gestionMovimientoFactory = new GestionMovimientoFacturaFactory($factura);

            foreach ($movimientos as /* @var $movimiento Movimiento */ $movimiento) {                
                
                $this->em->persist($movimiento);                
                
                $operacion = $movimiento->getItemFinanzas()->getOperacion();
                
                if ( $operacion->getGestionaPartidasAbiertas() ){
                    
                    //$acreedor = $factura->getProveedorSociedad()->getAcreedor();
                    
                    //  if( $acreedor -> hasPartidasAbiertas ){
                        $gestionMovimiento = $gestionMovimientoFactory->create($movimiento->getItemFinanzas(), $movimiento);// new GestionMovimientoAcreedor($movimiento, $acreedor );                                                
                        $this->em->persist($gestionMovimiento);
                    //  }
                }
            }

            $this->em->persist($factura);
            $this->em->flush();
            $this->em->commit();
        } catch (Exception $e) {
            $this->em->rollback();
            throw $e;
        }
    }

}
