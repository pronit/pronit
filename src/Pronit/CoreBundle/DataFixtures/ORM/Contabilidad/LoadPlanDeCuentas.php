<?php

namespace Pronit\CoreBundle\DataFixtures\ORM\Contabilidad;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Pronit\CoreBundle\Entity\Contabilidad\CuentasContables\Cuenta;
use Pronit\CoreBundle\Entity\Contabilidad\CuentasContables\PlanCuentas;
use Pronit\CoreBundle\Entity\Contabilidad\CuentasContables\ItemCuentaPlanCuentas;

/**
 * @author ldelia
 */
class LoadPlanDeCuentas extends AbstractFixture implements FixtureInterface , OrderedFixtureInterface, ContainerAwareInterface
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
            array( "numero" => "1110101", "nombre" => "Caja moneda local" ),
            array( "numero" => "1110102", "nombre" => "Caja moneda extranjera" ),
            array( "numero" => "1110500", "nombre" => "Banco Francés Cta Cte" ),
            array( "numero" => "1102001", "nombre" => "Banco Patagonia Sudamericano" ),
            array( "numero" => "1110103", "nombre" => "Recaudaciones a depositar" ),
            array( "numero" => "130101", "nombre" => "Deudores por Ventas" ),
            array( "numero" => "140108", "nombre" => "IVA Crédito Fiscal" ),
            array( "numero" => "150101", "nombre" => "Mercaderías de reventa" ),
            array( "numero" => "150102", "nombre" => "Materias Primas" ),
            array( "numero" => "150103", "nombre" => "Materiales Indirectos" ),
            array( "numero" => "150104", "nombre" => "Productos semielaborados" ),
            array( "numero" => "150105", "nombre" => "Productos terminados" ),
            array( "numero" => "150106", "nombre" => "Activos Fijos" ),
            array( "numero" => "190101", "nombre" => "Diferencia de cambio pérdida" ),
            array( "numero" => "190102", "nombre" => "Diferencia de precio pérdida" ),
            array( "numero" => "210101", "nombre" => "Proveedores locales" ),
            array( "numero" => "210103", "nombre" => "Proveedores del exterior" ),
            array( "numero" => "140111", "nombre" => "Percepciones sufridas IIBB BS AS" ),
            array( "numero" => "210102", "nombre" => "EM/RF: Entrega/prestaciones aún no facturadas" ),
            array( "numero" => "510192", "nombre" => "Diferencia de cambio ganancia" ),
            array( "numero" => "510193", "nombre" => "Diferencia de precio ganancia" ),
        );
                
        $planCuentas = new PlanCuentas();
        $planCuentas->setNombre('PRT');
        
        $i = 1;
        
        foreach( $values as $value ){
            
            $cuenta = new Cuenta();
            $cuenta->setNombre($value['nombre']);

            $manager->persist($cuenta);
            
            $item = new ItemCuentaPlanCuentas();
            $item->setCodigo($value['numero']);
            $item->setCuenta($cuenta);
            
            $planCuentas->addItem("1.".$i, $item);
            
            $this->addReference('pronit-contabilidad-cuenta-' . $value["numero"], $cuenta);        
            
            $i++;
        }
        
        $manager->persist($planCuentas);        
        
        $manager->flush();
    }   
    
    function getOrder()
    {
        return 14; 
    }
}
