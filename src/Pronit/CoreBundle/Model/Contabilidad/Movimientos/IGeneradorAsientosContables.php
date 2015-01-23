<?php
namespace Pronit\CoreBundle\Model\Contabilidad\Movimientos;

use ArrayObject;
use Pronit\CoreBundle\Entity\Documentos\Documento;
use Pronit\CoreBundle\Model\Contabilidad\Esquemas\EsquemaContable;

/**
 *
 * @author gcaseres
 */
interface IGeneradorAsientosContables {
    
    /**
     * 
     * @param Documento $documento
     * @return ArrayObject
     */
    public function generarDesdeDocumento(Documento $documento);
    
    /**
     * 
     * @param EsquemaContable
     * @return ArrayObject
     */    
    public function generarDesdeEsquema(EsquemaContable $esquema);
}
