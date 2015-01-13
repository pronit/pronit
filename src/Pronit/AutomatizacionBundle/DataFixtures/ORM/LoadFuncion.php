<?php

namespace Pronit\AutomatizacionBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Pronit\AutomatizacionBundle\Entity\Funcion;

/**
 * @author ldelia
 */
class LoadFuncion extends AbstractFixture implements FixtureInterface , OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;    
    private $manager;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
    public function getManager()
    {
        return $this->manager;
    }

    public function setManager(ObjectManager $manager)
    {
        $this->manager = $manager;
    }
    
    /**
     * {@inheritDoc}
     */       
    public function load(ObjectManager $manager)
    {
        $this->setManager($manager);        

        $values =  array(
            array( 
                    "nombre" => "IMP_AXM", 
                    "nombreClase" => "Script_IMP_AXM", 
                    "script" => '
                        class Script_IMP_AXM extends Scripting\Script {
                            public function ejecutar(Scripting\Contexto $contexto) {
                                $contextoOperacion = $contexto->getContextoOperacion();
                                
                                return $contextoOperacion->getMontoImponible() * $contextoOperacion->getAlicuota() / 100;
                            }
                        }
                    ' 
            ),            
            array( 
                    "nombre" => "OP_BSX", 
                    "nombreClase" => "Script_OP_BSX", 
                    "script" => '
                        class Script_OP_BSX extends Scripting\Script {
                            public function ejecutar(Scripting\Contexto $contexto) {
                                $contextoOperacion = $contexto->getContextoOperacion();
                                
                                $itemDocumentoEntradaMercancias = $contextoOperacion->getItem();
                               
                                return $itemDocumentoEntradaMercancias->getCantidad() * $itemDocumentoEntradaMercancias->getPrecioUnitario();
                            }
                        }
                    ' 
            ),
            array( 
                    "nombre" => "OP_WRX", 
                    "nombreClase" => "Script_OP_WRX", 
                    "script" => '
                        class Script_OP_WRX extends Scripting\Script {
                            public function ejecutar(Scripting\Contexto $contexto) {
                                $contextoOperacion = $contexto->getContextoOperacion();
                                
                                $itemDocumentoEntradaMercancias = $contextoOperacion->getItem();
                               
                                return $itemDocumentoEntradaMercancias->getCantidad() * $itemDocumentoEntradaMercancias->getPrecioUnitario();
                            }
                        }
                    ' 
            ),
            array( 
                    "nombre" => "OP_WRZ", 
                    "nombreClase" => "Script_OP_WRZ", 
                    "script" => '
                        class Script_OP_WRZ extends Scripting\Script {
                            public function ejecutar(Scripting\Contexto $contexto) {
                                $contextoOperacion = $contexto->getContextoOperacion();
                                
                                $itemDocumentoFactura = $contextoOperacion->getItem();
                               
                                return $itemDocumentoFactura->getPrecioTotal();
                            }
                        }
                    ' 
            ),            
            array( 
                    "nombre" => "OP_PRD_Positive", 
                    "nombreClase" => "Script_OP_PRD_Positive", 
                    "script" => '
                         class Script_OP_PRD_Positive extends Scripting\Script {
                             public function ejecutar(Scripting\Contexto $contexto) {
                                 $contextoOperacion = $contexto->getContextoOperacion();
                                 
                                 $em = $contextoOperacion->getEntityManager();
                                 $itemDocumentoEntradaMercancias = $contextoOperacion->getItem();
                                
                                 $precioItemML = $itemDocumentoEntradaMercancias->getCantidad() * $itemDocumentoEntradaMercancias->getPrecioUnitario();
                                 $bienServicio = $itemDocumentoEntradaMercancias->getBienServicio();
				 $sociedadFI = $itemDocumentoEntradaMercancias->getDocumento()->getSociedad();
                                 
                                 $bienServicioSociedadFI = $em->getRepository("Pronit\GestionBienesYServiciosBundle\Entity\Customizing\EstructuraEmpresa\BienServicioSociedadFI")->findOneBy(array("sociedadFI" => $sociedadFI->getId(), "bienServicio" => $bienServicio->getId()));
                                 $precioValoracionBienServicio = $bienServicioSociedadFI->getPrecioValoracionEstandar();
                                 
                                 $precioValoracionItem = $itemDocumentoEntradaMercancias->getCantidad() * $precioValoracionBienServicio;
                                 
                                 $result = $precioValoracionItem - $precioItemML;
                                 
                                 if ($result > 0) {
                                    return $result;
                                 } else {
                                    return 0;
                                 }
                             }
                         }                     
                    ' 
            ),
            array( 
                    "nombre" => "OP_PRD_Negative", 
                    "nombreClase" => "Script_OP_PRD_Negative", 
                    "script" => '
                         class Script_OP_PRD_Negative extends Scripting\Script {
                             public function ejecutar(Scripting\Contexto $contexto) {
                                 $contextoOperacion = $contexto->getContextoOperacion();
                                 
                                 $em = $contextoOperacion->getEntityManager();
                                 $itemDocumentoEntradaMercancias = $contextoOperacion->getItem();
                                
                                 $precioItemML = $itemDocumentoEntradaMercancias->getCantidad() * $itemDocumentoEntradaMercancias->getPrecioUnitario();
                                 $bienServicio = $itemDocumentoEntradaMercancias->getBienServicio();
				 $sociedadFI = $itemDocumentoEntradaMercancias->getDocumento()->getSociedad();
                                 
                                 $bienServicioSociedadFI = $em->getRepository("Pronit\GestionBienesYServiciosBundle\Entity\Customizing\EstructuraEmpresa\BienServicioSociedadFI")->findOneBy(array("sociedadFI" => $sociedadFI->getId(), "bienServicio" => $bienServicio->getId()));
                                 $precioValoracionBienServicio = $bienServicioSociedadFI->getPrecioValoracionEstandar();
                                 
                                 $precioValoracionItem = $itemDocumentoEntradaMercancias->getCantidad() * $precioValoracionBienServicio;
                                 
                                 $result = $precioValoracionItem - $precioItemML;
                                 
                                 if ($result < 0) {
                                    return -$result;
                                 } else {
                                    return 0;
                                 }
                             }
                         }                     
                    ' 
            ),
            array( 
                    "nombre" => "OP_BSD_Positive", 
                    "nombreClase" => "Script_OP_BSD_Positive", 
                    "script" => '
                         class Script_OP_BSD_Positive extends Scripting\Script {
                             public function ejecutar(Scripting\Contexto $contexto) {
                                 $contextoOperacion = $contexto->getContextoOperacion();
                                 
                                 $em = $contextoOperacion->getEntityManager();
                                 $itemDocumentoEntradaMercancias = $contextoOperacion->getItem();
                                
                                 $precioItemML = $itemDocumentoEntradaMercancias->getCantidad() * $itemDocumentoEntradaMercancias->getPrecioUnitario();
                                 $bienServicio = $itemDocumentoEntradaMercancias->getBienServicio();
				 $sociedadFI = $itemDocumentoEntradaMercancias->getDocumento()->getSociedad();
                                 
                                 $bienServicioSociedadFI = $em->getRepository("Pronit\GestionBienesYServiciosBundle\Entity\Customizing\EstructuraEmpresa\BienServicioSociedadFI")->findOneBy(array("sociedadFI" => $sociedadFI->getId(), "bienServicio" => $bienServicio->getId()));
                                 $precioValoracionBienServicio = $bienServicioSociedadFI->getPrecioValoracionEstandar();
                                 
                                 $precioValoracionItem = $itemDocumentoEntradaMercancias->getCantidad() * $precioValoracionBienServicio;
                                 
                                 $result = $precioValoracionItem - $precioItemML;
                                 
                                 if ($result > 0) {
                                    return $result;
                                 } else {
                                    return 0;
                                 }
                             }
                         }                     
                    ' 
            ),
            array( 
                    "nombre" => "OP_BSD_Negative", 
                    "nombreClase" => "Script_OP_BSD_Negative", 
                    "script" => '
                         class Script_OP_BSD_Negative extends Scripting\Script {
                             public function ejecutar(Scripting\Contexto $contexto) {
                                 $contextoOperacion = $contexto->getContextoOperacion();
                                 
                                 $em = $contextoOperacion->getEntityManager();
                                 $itemDocumentoEntradaMercancias = $contextoOperacion->getItem();
                                
                                 $precioItemML = $itemDocumentoEntradaMercancias->getCantidad() * $itemDocumentoEntradaMercancias->getPrecioUnitario();
                                 $bienServicio = $itemDocumentoEntradaMercancias->getBienServicio();
				 $sociedadFI = $itemDocumentoEntradaMercancias->getDocumento()->getSociedad();
                                 
                                 $bienServicioSociedadFI = $em->getRepository("Pronit\GestionBienesYServiciosBundle\Entity\Customizing\EstructuraEmpresa\BienServicioSociedadFI")->findOneBy(array("sociedadFI" => $sociedadFI->getId(), "bienServicio" => $bienServicio->getId()));
                                 $precioValoracionBienServicio = $bienServicioSociedadFI->getPrecioValoracionEstandar();
                                 
                                 $precioValoracionItem = $itemDocumentoEntradaMercancias->getCantidad() * $precioValoracionBienServicio;
                                 
                                 $result = $precioValoracionItem - $precioItemML;
                                 
                                 if ($result < 0) {
                                    return -$result;
                                 } else {
                                    return 0;
                                 }
                             }
                         }                     
                    ' 
            ),                        
        );
                
        foreach( $values as $value ){
            
            $obj = new Funcion();
            $obj->setNombre($value['nombre']);
            $obj->setNombreClase($value['nombreClase']);
            $obj->setScript($value['script']);
        
            $manager->persist($obj);
            
            $this->addReference('pronit-automatizacion-funcion-' . $value["nombre"], $obj);        
        }
        
        $manager->flush();
    }
    
    function getOrder()
    {
        return 0; 
    }
}
