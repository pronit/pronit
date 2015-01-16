<?php

namespace Pronit\ComprasBundle\Model\Transacciones\EntradasMercancias;

use Doctrine\ORM\EntityManager;
use Exception;
use Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\EntradaMercancias;
use Pronit\CoreBundle\Model\Contabilidad\Esquemas\IGeneradorEsquemaContable;
use Pronit\CoreBundle\Model\Contabilidad\Movimientos\IGeneradorAsientosContables;

/**
 *
 * @author ldelia
 */
class TransaccionEntradaMercancias {
    
    /** @var EntityManager */
    protected $em;
    
    /** @var IGeneradorEsquemaContable */
    protected $generadorEsquemaContable;
    
    /** @var IGeneradorAsientosContables */
    protected $generadorAsientosContables;

    public function __construct(EntityManager $em, IGeneradorEsquemaContable $generadorEsquemaContable, IGeneradorAsientosContables $generadorAsientosContables) {
        $this->em = $em;
        $this->generadorEsquemaContable = $generadorEsquemaContable;
        $this->generadorAsientosContables = $generadorAsientosContables;
    }

    public function ejecutar(EntradaMercancias $entradaMercancias) {
        if (!$entradaMercancias->isContabilizado()) {

            $entradaMercancias->contabilizar();
            
            $esquemaContable = $this->generadorEsquemaContable->generar($entradaMercancias);
            $movimientos = $this->generadorAsientosContables->generarDesdeEsquema($esquemaContable);

            foreach ($movimientos as $movimiento) {
                $this->em->persist($movimiento);
            }
            
            $this->em->persist($entradaMercancias);
            $this->em->flush();
        } else {
            throw new Exception("La entrada de mercancias no puede ser contabilizada");
        }
    }

}
