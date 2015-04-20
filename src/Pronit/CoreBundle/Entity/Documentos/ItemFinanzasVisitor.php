<?php
namespace Pronit\CoreBundle\Entity\Documentos;

/**
 *
 * @author gcaseres
 */
interface ItemFinanzasVisitor {
    function visitItemFinanzas(ItemFinanzas $itemFinanzas);
    function visitItemFinanzasPago(ItemFinanzasPago $itemFinanzasPago);
}
