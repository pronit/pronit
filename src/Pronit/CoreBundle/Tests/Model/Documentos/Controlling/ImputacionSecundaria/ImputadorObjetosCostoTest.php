<?php

namespace Pronit\CoreBundle\Tests\Model\Documentos\Controlling\ImputacionSecundaria;

use Doctrine\Common\Persistence\ObjectManager;
use Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\EntradaMercancias;
use Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\ItemEntradaMercancias;
use Pronit\CoreBundle\Entity\Contabilidad\CuentasContables\Cuenta;
use Pronit\CoreBundle\Entity\Controlling\Aspectos\ImputaObjetoCostos;
use Pronit\CoreBundle\Entity\Controlling\CentroBeneficio;
use Pronit\CoreBundle\Entity\Controlling\CentroCosto;
use Pronit\CoreBundle\Entity\Controlling\Documentos\ImputacionSecundaria;
use Pronit\CoreBundle\Entity\Controlling\Documentos\ItemEmisor;
use Pronit\CoreBundle\Entity\Controlling\Documentos\ItemReceptor;
use Pronit\CoreBundle\Entity\Controlling\Imputacion;
use Pronit\CoreBundle\Entity\Controlling\ObjetoCosto;
use Pronit\CoreBundle\Entity\Documentos\ItemFinanzas;
use Pronit\CoreBundle\Entity\Operaciones\OperacionContable;
use Pronit\CoreBundle\Model\Aspectos\IAspectoManager;
use Pronit\CoreBundle\Model\Documentos\Controlling\ImputacionSecundaria\ImputadorObjetosCosto;
use Pronit\CoreBundle\Model\Documentos\Controlling\ImputadorObjetosCosto as ImputadorObjetosCostoEM;
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

    private function createGestionImputacionRepositoryMock(&$data) {
        $repository = $this->getMock('Pronit\CoreBundle\Entity\Controlling\Repository\IGestionImputacionRepository');
        $repository->method('find')->will($this->returnCallback(function ($pk) use (&$data) {
                    foreach ($data['Pronit\CoreBundle\Entity\Controlling\GestionImputacion'] as $gestionImputacion) {
                        if ($pk['itemDocumento'] === $gestionImputacion->getImputacionInicial()->getItemDocumento() && $pk['objetoCosto'] === $gestionImputacion->getImputacionInicial()->getObjetoCosto()) {
                            return $gestionImputacion;
                        }
                    }

                    return null;
                }));
        $repository->method('add')->will($this->returnCallback(function ($obj) use (&$data) {
                    $data['Pronit\CoreBundle\Entity\Controlling\GestionImputacion'][] = $obj;
                }));

        return $repository;
    }

    private function createEntradaMercancias(array $operaciones, Cuenta $cuentaContable, ObjetoCosto $objetoCosto, $importeItem) {
        $doc = new EntradaMercancias();
        $item = new ItemEntradaMercancias();
        $item->setObjetoCosto($objetoCosto);
        $doc->addItem($item);
        $doc->addItemFinanzas(new ItemFinanzas($operaciones['BSX'], $cuentaContable, $item, $importeItem));

        return $doc;
    }

    private function createImputacionSecundaria(array $objetosCosto, array $operaciones, Cuenta $cuentaContable, Imputacion $imputacionEmisor, $importeEmisor) {
        $doc = new ImputacionSecundaria();

        $itemEmisor = new ItemEmisor($imputacionEmisor);
        $itemEmisor->setImporte($importeEmisor);

        $doc->addItem($itemEmisor);

        $itemReceptor = new ItemReceptor();
        $itemReceptor->setObjetoCosto($objetosCosto['B1']);

        $doc->addItem($itemReceptor);


        $doc->addItemFinanzas(new ItemFinanzas($operaciones['COE'], $cuentaContable, $itemEmisor, $importeEmisor));
        $doc->addItemFinanzas(new ItemFinanzas($operaciones['COR'], $cuentaContable, $itemReceptor, $importeEmisor));

        return $doc;
    }

    public function testImputarImputacionCompensatoria() {
        $data = array(
            'Pronit\CoreBundle\Entity\Controlling\GestionImputacion' => array()
        );

        $em = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $operaciones = $this->createOperaciones();

        $imputadorEM = new ImputadorObjetosCostoEM($em, $this->createGestionImputacionRepositoryMock($data), $this->createImputaObjetoCostosAspectoManagerMock($operaciones));
        $imputadorDC = new ImputadorObjetosCosto($em, $this->createGestionImputacionRepositoryMock($data), $this->createImputaObjetoCostosAspectoManagerMock($operaciones));

        $objetosCosto = $this->createObjetosCosto();
        $cuentaContable = new Cuenta('CC1', 'Cuenta contable 1');

        $docEM = $this->createEntradaMercancias($operaciones, $cuentaContable, $objetosCosto['C1'], 100);

        $imputadorEM->imputar($docEM);

        /* @var $imputacion Imputacion */
        $imputacion = $objetosCosto['C1']->getImputaciones()->get(0);

        $docDC = $this->createImputacionSecundaria($objetosCosto, $operaciones, $cuentaContable, $imputacion, 50);

        $imputadorDC->imputar($docDC);

        $this->assertEquals(2, count($data['Pronit\CoreBundle\Entity\Controlling\GestionImputacion']), 'Se espera que se hayan generado dos GestionImputacion una generada por la imputación EM y otra por la imputacion DC.');

        $gestionImputacionEM = $data['Pronit\CoreBundle\Entity\Controlling\GestionImputacion'][0];
        $gestionImputacionDC = $data['Pronit\CoreBundle\Entity\Controlling\GestionImputacion'][1];

        $this->assertEquals(1, $gestionImputacionEM->getImputacionesCompensatorias()->count(), 'Se espera que exista una imputacion compensatoria.');
        $this->assertEquals(0, $gestionImputacionDC->getImputacionesCompensatorias()->count(), 'Se espera que la GestionImputacion generada por la imputacion DC no tenga ninguna imputación secundaria.');
        $this->assertEquals(50, $gestionImputacionEM->getImporte());
    }

}
