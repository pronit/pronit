<?php

namespace Pronit\CoreBundle\Tests\Model\Controlling\Documentos;

use Doctrine\Common\Persistence\ObjectManager;
use Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\EntradaMercancias;
use Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\ItemEntradaMercancias;
use Pronit\CoreBundle\Entity\Contabilidad\CuentasContables\Cuenta;
use Pronit\CoreBundle\Entity\Controlling\Aspectos\ImputaObjetoCostos;
use Pronit\CoreBundle\Entity\Controlling\CentroBeneficio;
use Pronit\CoreBundle\Entity\Controlling\CentroCosto;
use Pronit\CoreBundle\Entity\Controlling\Imputacion;
use Pronit\CoreBundle\Entity\Controlling\ObjetoCosto;
use Pronit\CoreBundle\Entity\Documentos\ItemFinanzas;
use Pronit\CoreBundle\Entity\Operaciones\OperacionContable;
use Pronit\CoreBundle\Model\Aspectos\IAspectoManager;
use Pronit\CoreBundle\Model\Controlling\Documentos\ImputadorObjetosCosto;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of GeneradorAsientosContablesTest
 *
 * @author gcaseres
 */
class ImputadorObjetosCostoTest extends KernelTestCase {

    /**
     * 
     * @return array
     */
    private function createOperaciones() {
        $result = array(
            'COR' => new OperacionContable(),
            'COE' => new OperacionContable(),
            'BSX' => new OperacionContable()
        );

        $result['COR']->setCodigo('COR');
        $result['COE']->setCodigo('COE');
        $result['BSX']->setCodigo('BSX');

        return $result;
    }

    private function createObjetosCosto() {
        return array(
            'C1' => new CentroCosto(),
            'B1' => new CentroBeneficio()
        );
    }

    /**
     * 
     * @param array $operaciones
     * @return IAspectoManager
     */
    private function createImputaObjetoCostosAspectoManagerMock(array $operaciones) {
        $imputaObjetoCostosAspectoManagerMock = $this->getMock('Pronit\CoreBundle\Model\Aspectos\IAspectoManager');

        $imputaObjetoCostosAspectoManagerMock
                ->method('has')
                ->will($this->returnValue(true));

        $imputaObjetoCostosAspectoManagerMock->method('get')
                ->will($this->returnCallback(function ($operacion) {
                            switch ($operacion->getCodigo()) {
                                case 'COR':
                                    return new ImputaObjetoCostos($operacion, 1);
                                case 'COE':
                                    return new ImputaObjetoCostos($operacion, -1);
                                case 'BSX':
                                    return new ImputaObjetoCostos($operacion, 1);
                            }
                        }));

        return $imputaObjetoCostosAspectoManagerMock;
    }

    /**
     * 
     * @param ObjectManager $em
     * @param IAspectoManager $imputaObjetoCostosAspectoManagerMock
     * @return ImputadorObjetosCosto
     */
    private function createImputadorObjetoCostosMock(ObjectManager $em, IAspectoManager $imputaObjetoCostosAspectoManagerMock) {
        return new ImputadorObjetosCosto($em, $imputaObjetoCostosAspectoManagerMock);
    }

    private function createEntradaMercancias(array $operaciones, Cuenta $cuentaContable, ObjetoCosto $objetoCosto, $importeItem) {
        $doc = new EntradaMercancias();
        $item = new ItemEntradaMercancias();
        $item->setObjetoCosto($objetoCosto);
        $doc->addItem($item);
        $doc->addItemFinanzas(new ItemFinanzas($operaciones['BSX'], $cuentaContable, $item, $importeItem));

        return $doc;
    }
    
    private function createGestionImputacionRepositoryMock(&$data) {
        $repository = $this->getMock('Pronit\CoreBundle\Entity\Controlling\Repository\IGestionImputacionRepository');
        $repository->method('find')->will($this->returnValue(null));
        $repository->method('add')->will($this->returnCallback(function ($obj) use (&$data) {
            $data['Pronit\CoreBundle\Entity\Controlling\GestionImputacion'][] = $obj;
        }));
        
        return $repository;
    }


    public function testImputar() {

        $data = array('Pronit\CoreBundle\Entity\Controlling\GestionImputacion' => array());

        $em = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $operaciones = $this->createOperaciones();

        $imputador = new ImputadorObjetosCosto($em, $this->createGestionImputacionRepositoryMock($data), $this->createImputaObjetoCostosAspectoManagerMock($operaciones));

        $objetosCosto = $this->createObjetosCosto();
        $cuentaContable = new Cuenta('CC1', 'Cuenta contable 1');

        $doc = $this->createEntradaMercancias($operaciones, $cuentaContable, $objetosCosto['C1'], 100);

        $imputador->imputar($doc);

        /* @var $imputacion Imputacion */
        $imputacion = $objetosCosto['C1']->getImputaciones()->get(0);

        $this->assertEquals(1, $objetosCosto['C1']->getImputaciones()->count());
        $this->assertEquals(1, $imputacion->getCuentaContable()->equals($cuentaContable));
        $this->assertEquals(100, $imputacion->getImporte());
        $this->assertEquals(1, count($data['Pronit\CoreBundle\Entity\Controlling\GestionImputacion']));

        $gestionImputacion = $data['Pronit\CoreBundle\Entity\Controlling\GestionImputacion'][0];

        $this->assertNotNull($gestionImputacion);
        $this->assertEquals(100, $gestionImputacion->getImporte());
    }

    
}
