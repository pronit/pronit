<?php

namespace Pronit\CoreBundle\Tests\Entity\Automatizacion\Secuencias;

use Pronit\CoreBundle\Entity\Automatizacion\Secuencias\Secuencia;
use Pronit\CoreBundle\Entity\Automatizacion\Secuencias\Acceso;

/**
 *
 * @author ldelia
 */
class SecuenciaTest extends \PHPUnit_Framework_TestCase 
{    
    public function testCompare() 
    {
        $accesosValues = array(
            array( 
                'orden' => 30
            ),
            array( 
                'orden' => 10
            ),                    
            array( 
                'orden' => 20
            ),                    
        );
                
        $secuencia = new Secuencia();
        $secuencia->setDescripcion('Precio');
        $secuencia->setCodigo('PR-01');

        foreach( $accesosValues as $accesoValue ){

            $acceso = new Acceso();
            $acceso->setOrden($accesoValue['orden']);
            $acceso->setTablaCondicion( $this->getMock('\Pronit\CoreBundle\Entity\Automatizacion\Secuencias\TablaCondicion') );

            $secuencia->addAcceso($acceso);
        }

        $anterior = null;
        foreach( $secuencia as $acceso )
        {
            if(! is_null($anterior))
            {
                $this->assertTrue( $anterior->getOrden() < $acceso->getOrden() );
            }            
            $anterior = $acceso;
        }        
    }        
}
