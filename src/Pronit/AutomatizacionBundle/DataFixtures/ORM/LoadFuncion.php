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
class LoadFuncion extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface {

    /**
     * @var ContainerInterface
     */
    private $container;
    private $manager;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    public function getManager() {
        return $this->manager;
    }

    public function setManager(ObjectManager $manager) {
        $this->manager = $manager;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {
        $this->setManager($manager);

        $values = array(
            array(
                "nombre" => "DOC_KR_ITEM_IMPUESTOS",
                "nombreClase" => "Script_DOC_KR_ITEM_IMPUESTOS",
                "script" => '
                        class Script_DOC_KR_ITEM_IMPUESTOS extends Scripting\Script {
                            public function ejecutar(Scripting\Contexto $contexto) {
                                $result = array();
                                $contextoOperacion = $contexto->getContextoOperacion();
                                
                                $itemFactura = $contextoOperacion->getItem();
                                
                                foreach ($itemFactura->getIndicadorImpuestos()->getItems() as $item) {
                                    $contextoCalculoImpuestos = new Core_Operaciones_Contextos\Impuestos\ContextoCalculoImpuesto($item->getOperacionContable(), $itemFactura->getImporteNeto(), $item->getAlicuota());
                                    $cuenta = $contextoOperacion->getFIImputacionesCustomizingManager()->getCuenta($item->getOperacionContable());
                                    $importe = $item->getOperacionContable()->ejecutar($contextoCalculoImpuestos);
                                    $result[] = new Core_Scripting\ItemFinanzasDTO($cuenta, $importe);
                                }

                                return $result;
                            }
                        }
                    '
            ),
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
                "nombre" => "DOC_EM_ITEM_MONTOTOTAL",
                "nombreClase" => "Script_DOC_EM_ITEM_MONTOTOTAL",
                "script" => '
                         class Script_DOC_EM_ITEM_MONTOTOTAL extends Scripting\Script {
                             public function ejecutar(Scripting\Contexto $contexto) {
                                 $contextoOperacion = $contexto->getContextoOperacion();

                                 $item = $contextoOperacion->getItem();
                                 $importe = $item->getImporteNeto();
				 $clasificador = (object)$item->getClasificador();
                                 
                                 $cuenta = $contextoOperacion->getMMImputacionesCustomizingManager()->getCuenta($clasificador, $contextoOperacion->getOperacion(), $item->getBienServicio()->getCategoriaValoracion());
                                 if ($cuenta == null) {
                                     $cuenta = $contextoOperacion->getFIImputacionesCustomizingManager()->getCuenta($contextoOperacion->getOperacion());
                                 }
                                 if ($cuenta == null) {
                                     throw new \Exception("No se especificó una cuenta contable para imputar.");
                                 }
                                 
                                 return new Core_Scripting\ItemFinanzasDTO($cuenta, $importe);
                             }
                         }
                '
            ),
            array(
                "nombre" => "DOC_FC_ITEM_MONTOTOTAL",
                "nombreClase" => "Script_DOC_FC_ITEM_MONTOTOTAL",
                "script" => '
                        class Script_DOC_FC_ITEM_MONTOTOTAL extends Scripting\Script {
                            public function ejecutar(Scripting\Contexto $contexto) {
                                $contextoOperacion = $contexto->getContextoOperacion();
                                
                                $item = $contextoOperacion->getItem();
                                $importe = $item->getImporteNeto();
                                
                                $cuenta = $contextoOperacion->getFIImputacionesCustomizingManager()->getCuenta($contextoOperacion->getOperacion());
                                if ($cuenta == null) {
                                    throw new \Exception("No se especificó una cuenta contable para imputar.");
                                }
                                
                                return new Core_Scripting\ItemFinanzasDTO($cuenta, $importe);
                            }

                        }
                    '
            ),
            array(
                "nombre" => "DOC_KR_PEDIDOIMPUTADO",
                "nombreClase" => "Script_DOC_KR_PEDIDOIMPUTADO",
                "script" => '
                        class Script_DOC_KR_PEDIDOIMPUTADO extends Scripting\Script {
                            public function ejecutar(Scripting\Contexto $contexto) {
                                $contextoOperacion = $contexto->getContextoOperacion();
                                
                                $result = array();

                                $factura = $contextoOperacion->getFactura();                                
                                $cuenta = $factura->getProveedorSociedad()->getAcreedor()->getCuenta();
                                
                                foreach ($factura->getCondicionPagos()->getItems() as $itemCondicionPagos){
                                    $montoCuota = $factura->getImporteTotal() / 100 * $itemCondicionPagos->getPorcentaje();
                                    
                                    if ($montoCuota !== 0){
                                        $result[] =  new Core_Scripting\ItemFinanzasDTO($cuenta, $montoCuota);
                                    }
                                }
                               
                                return $result;
                            }
                        }
                    '
            ),
            array(
                "nombre" => "DOC_EM_ITEM_DIFFPRECIOVALORACION_POSITIVE",
                "nombreClase" => "Script_DOC_EM_ITEM_DIFFPRECIOVALORACION_POSITIVE",
                "script" => '
                         class Script_DOC_EM_ITEM_DIFFPRECIOVALORACION_POSITIVE extends Scripting\Script {
                             public function ejecutar(Scripting\Contexto $contexto) {
                                 $contextoOperacion = $contexto->getContextoOperacion();
                                 
                                 $em = $contextoOperacion->getEntityManager();
                                 $itemDocumentoEntradaMercancias = $contextoOperacion->getItem();
                                
                                 $precioItemML = $itemDocumentoEntradaMercancias->getImporteNeto(); 
                                 $bienServicio = $itemDocumentoEntradaMercancias->getBienServicio();
				 $sociedadFI = $itemDocumentoEntradaMercancias->getDocumento()->getSociedad();
                                 
                                 $bienServicioSociedadFI = $em->getRepository("Pronit\GestionBienesYServiciosBundle\Entity\Customizing\EstructuraEmpresa\BienServicioSociedadFI")->findOneBy(array("sociedadFI" => $sociedadFI->getId(), "bienServicio" => $bienServicio->getId()));
                                 $precioValoracionBienServicio = $bienServicioSociedadFI->getPrecioValoracionEstandar();
                                 
                                 $precioValoracionItem = $itemDocumentoEntradaMercancias->getCantidad() * $precioValoracionBienServicio;
                                 
                                 $importe = $precioValoracionItem - $precioItemML;
                                 
                                 if ($importe > 0) {
                                    $cuenta = $contextoOperacion->getFIImputacionesCustomizingManager()->getCuenta($contextoOperacion->getOperacion());
                                    return new Core_Scripting\ItemFinanzasDTO($cuenta, $importe);
                                 } else {
                                    return null;
                                 }
                             }
                         }                     
                    '
            ),
            array(
                "nombre" => "DOC_EM_ITEM_DIFFPRECIOVALORACION_NEGATIVE",
                "nombreClase" => "Script_DOC_EM_ITEM_DIFFPRECIOVALORACION_NEGATIVE",
                "script" => '
                         class Script_DOC_EM_ITEM_DIFFPRECIOVALORACION_NEGATIVE extends Scripting\Script {
                             public function ejecutar(Scripting\Contexto $contexto) {
                                 $contextoOperacion = $contexto->getContextoOperacion();
                                 
                                 $em = $contextoOperacion->getEntityManager();
                                 $itemDocumentoEntradaMercancias = $contextoOperacion->getItem();
                                
                                 $precioItemML = $itemDocumentoEntradaMercancias->getImporteNeto(); 
                                 $bienServicio = $itemDocumentoEntradaMercancias->getBienServicio();
				 $sociedadFI = $itemDocumentoEntradaMercancias->getDocumento()->getSociedad();
                                 
                                 $bienServicioSociedadFI = $em->getRepository("Pronit\GestionBienesYServiciosBundle\Entity\Customizing\EstructuraEmpresa\BienServicioSociedadFI")->findOneBy(array("sociedadFI" => $sociedadFI->getId(), "bienServicio" => $bienServicio->getId()));
                                 $precioValoracionBienServicio = $bienServicioSociedadFI->getPrecioValoracionEstandar();
                                 
                                 $precioValoracionItem = $itemDocumentoEntradaMercancias->getCantidad() * $precioValoracionBienServicio;
                                 
                                 $importe = $precioValoracionItem - $precioItemML;
                                 
                                 if ($importe < 0) {
                                    $cuenta = $contextoOperacion->getFIImputacionesCustomizingManager()->getCuenta($contextoOperacion->getOperacion());
                                    return new Core_Scripting\ItemFinanzasDTO($cuenta, -$importe);
                                 } else {
                                    return null;
                                 }
                             }
                         }                     
                    '
            ),
            array(
                "nombre" => "DOC_EM_ITEM_REVALUOINVENTARIO_POSITIVE",
                "nombreClase" => "Script_DOC_EM_ITEM_REVALUOINVENTARIO_POSITIVE",
                "script" => '
                         class Script_DOC_EM_ITEM_REVALUOINVENTARIO_POSITIVE extends Scripting\Script {
                             public function ejecutar(Scripting\Contexto $contexto) {
                                 $contextoOperacion = $contexto->getContextoOperacion();
                                 
                                 $em = $contextoOperacion->getEntityManager();
                                 $itemDocumentoEntradaMercancias = $contextoOperacion->getItem();
                                
                                 $precioItemML = $itemDocumentoEntradaMercancias->getImporteNeto();
                                 $bienServicio = $itemDocumentoEntradaMercancias->getBienServicio();
				 $sociedadFI = $itemDocumentoEntradaMercancias->getDocumento()->getSociedad();
                                 
                                 $bienServicioSociedadFI = $em->getRepository("Pronit\GestionBienesYServiciosBundle\Entity\Customizing\EstructuraEmpresa\BienServicioSociedadFI")->findOneBy(array("sociedadFI" => $sociedadFI->getId(), "bienServicio" => $bienServicio->getId()));
                                 $precioValoracionBienServicio = $bienServicioSociedadFI->getPrecioValoracionEstandar();
                                 
                                 $precioValoracionItem = $itemDocumentoEntradaMercancias->getCantidad() * $precioValoracionBienServicio;
                                 
                                 $importe = $precioValoracionItem - $precioItemML;
                                 
                                 if ($importe > 0) {
                                    $cuenta = $contextoOperacion->getFIImputacionesCustomizingManager()->getCuenta($contextoOperacion->getOperacion());
                                    return new Core_Scripting\ItemFinanzasDTO($cuenta, $importe);
                                 } else {
                                    return null;
                                 }
                             }
                         }                     
                    '
            ),
            array(
                "nombre" => "DOC_EM_ITEM_REVALUOINVENTARIO_NEGATIVE",
                "nombreClase" => "Script_DOC_EM_ITEM_REVALUOINVENTARIO_NEGATIVE",
                "script" => '
                         class Script_DOC_EM_ITEM_REVALUOINVENTARIO_NEGATIVE extends Scripting\Script {
                             public function ejecutar(Scripting\Contexto $contexto) {
                                 $contextoOperacion = $contexto->getContextoOperacion();
                                 
                                 $em = $contextoOperacion->getEntityManager();
                                 $itemDocumentoEntradaMercancias = $contextoOperacion->getItem();
                                
                                 $precioItemML = $itemDocumentoEntradaMercancias->getImporteNeto();
                                 $bienServicio = $itemDocumentoEntradaMercancias->getBienServicio();
				 $sociedadFI = $itemDocumentoEntradaMercancias->getDocumento()->getSociedad();
                                 
                                 $bienServicioSociedadFI = $em->getRepository("Pronit\GestionBienesYServiciosBundle\Entity\Customizing\EstructuraEmpresa\BienServicioSociedadFI")->findOneBy(array("sociedadFI" => $sociedadFI->getId(), "bienServicio" => $bienServicio->getId()));
                                 $precioValoracionBienServicio = $bienServicioSociedadFI->getPrecioValoracionEstandar();
                                 
                                 $precioValoracionItem = $itemDocumentoEntradaMercancias->getCantidad() * $precioValoracionBienServicio;
                                 
                                 $importe = $precioValoracionItem - $precioItemML;
                                 
                                 if ($importe < 0) {
                                    $cuenta = $contextoOperacion->getFIImputacionesCustomizingManager()->getCuenta($contextoOperacion->getOperacion());
                                    return new Core_Scripting\ItemFinanzasDTO($cuenta, -$importe);                                 
                                 } else {
                                    return 0;
                                 }
                             }
                         }                     
                    '
            ),
        );

        foreach ($values as $value) {

            $obj = new Funcion();
            $obj->setNombre($value['nombre']);
            $obj->setNombreClase($value['nombreClase']);
            $obj->setScript($value['script']);

            $manager->persist($obj);

            $this->addReference('pronit-automatizacion-funcion-' . $value["nombre"], $obj);
        }

        $manager->flush();
    }

    function getOrder() {
        return 0;
    }

}
