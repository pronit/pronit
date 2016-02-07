<?php

namespace Pronit\CoreBundle\Model\Documentos\Controlling;

use Doctrine\ORM\EntityManager;
use Exception;

use Pronit\CoreBundle\Model\Documentos\Controlling\IImputadorObjetosCosto;
use Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\EntradaMercancias;
use Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\ItemEntradaMercancias;
use Pronit\CoreBundle\Entity\Documentos\ItemFinanzasEntradaMercancias;

use Pronit\CoreBundle\Entity\Controlling\Imputacion;

/**
 * @author ldelia
 */
class ImputadorObjetosCosto implements IImputadorObjetosCosto 
{
    protected $em;
    
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    function imputar(EntradaMercancias $entradaMercancias)
    {
        $imputaciones = new \ArrayObject();
        
        $hashMap = array();
        
        foreach($entradaMercancias->getItemsFinanzas() as /* @var $item ItemFinanzasEntradaMercancias */ $item){
            
            if (! is_null($item->getObjetoCosto())){                
                
                if( ! isset( $imputaciones[ spl_object_hash( $item->getObjetoCosto() ) ] )){
                    
                    $cuentas = new \ArrayObject();
                    $hashKey = spl_object_hash( $item->getObjetoCosto() );
                    
                    $hashMap[ $hashKey ] = $item->getObjetoCosto();
                    $imputaciones[ $hashKey ] = $cuentas;
                }else{
                    $cuentas = $imputaciones[ spl_object_hash( $item->getObjetoCosto() ) ];
                }                
                
                if( ! isset( $cuentas[ spl_object_hash( $item->getCuenta() ) ] )){
                    $monto = 0;
                    
                    $hashKey = spl_object_hash( $item->getCuenta() );
                    
                    $hashMap[ $hashKey ] = $item->getCuenta();
                    $cuentas[ $hashKey ] = $monto;                    
                }else{
                    $monto = $cuentas[ spl_object_hash( $item->getCuenta() ) ];
                }
                
                $monto += $item->getImporte();
                
                $cuentas[ spl_object_hash( $item->getCuenta() ) ] = $monto;                                                                
            }
        }
        
        foreach( $imputaciones as $hashObjetoCosto => $cuentas ){
            
            foreach ($cuentas as $hashCuenta => $monto){
                
                $objetoCosto = $hashMap[ $hashObjetoCosto ];
                $cuentaContable = $hashMap[ $hashCuenta ];                
                
                $imputacion = new Imputacion();
                $imputacion->setFecha($entradaMercancias->getFecha());
                $imputacion->setImporte($monto);
                $imputacion->setCuentaContable($cuentaContable);        
                $imputacion->setObjetoCosto($objetoCosto);
                
                $this->em->persist($imputacion);
            }
        }
    }
}
