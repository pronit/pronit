<?php

namespace Pronit\ComprasBundle\Model\Transacciones\Facturas;

use Doctrine\ORM\EntityManager;

use Pronit\ComprasBundle\Entity\Documentos\Facturas\Factura;
use Pronit\ContabilidadBundle\Model\Esquemas\IGeneradorEsquemaContable;
use Pronit\ContabilidadBundle\Model\Movimientos\IGeneradorAsientosContables;

/**
 *
 * @author ldelia
 */
class TransaccionFactura
{
    protected $em;
    
    /** @var IGeneradorEsquemaContable */
    protected $generadorEsquemaContable;
    
    /** @var IGeneradorAsientosContables */
    protected $generadorAsientosContables;
    
    
    public function __construct( EntityManager $em, IGeneradorEsquemaContable $generadorEsquemaContable, IGeneradorAsientosContables $generadorAsientosContables )
    {
        $this->em = $em;
        $this->generadorEsquemaContable = $generadorEsquemaContable;
        $this->generadorAsientosContables = $generadorAsientosContables;        
    }
    
    public function ejecutar( Factura $factura )
    {
        if( ! $factura->isContabilizado() ){
            
            $factura->contabilizar();

            $esquemaContable = $this->generadorEsquemaContable->generar($factura);
            $movimientos = $this->generadorAsientosContables->generarDesdeEsquema($esquemaContable);

            foreach ($movimientos as $movimiento) {
                $this->em->persist($movimiento);
            }
            
            $this->em->persist($factura);
            $this->em->flush();
        }else{
            throw new \Exception("La factura no puede ser contabilizada");
        }        
        
        
    }       
}
