<?php

namespace Pronit\CoreBundle\Tests\Model\Documentos\Referencias;

use ArrayObject;
use Pronit\CoreBundle\Entity\Documentos\Documento;
use Pronit\CoreBundle\Entity\Documentos\Item;
use Pronit\CoreBundle\Entity\Documentos\Referencias\ReferenciaDocumento;
use Pronit\CoreBundle\Entity\Documentos\Referencias\ReferenciaItemDocumento;
use Pronit\CoreBundle\Model\Documentos\Referencias\ReferenciasManager;

/**
 * Description of ReferenciasManagerTest
 *
 * @author gcaseres
 */
class ReferenciasManagerTest extends \PHPUnit_Framework_TestCase {

    protected function createDocumentos() {
        $documentos = new ArrayObject();

        $documento = $this->getMock('Pronit\CoreBundle\Entity\Documentos\Documento', array('getId'),array(), '', false);
        $documento->expects($this->any())
                ->method('getId')
                ->will($this->returnValue(1));
        $documentos->append($documento);
        
                
        $documento = $this->getMock('Pronit\CoreBundle\Entity\Documentos\Documento', array('getId'), array(), '', false);
        $documento->expects($this->any())
                ->method('getId')
                ->will($this->returnValue(2));
        $documentos->append($documento);
        
        $documento = $this->getMock('Pronit\CoreBundle\Entity\Documentos\Documento', array('getId'), array(), '', false);
        $documento->expects($this->any())
                ->method('getId')
                ->will($this->returnValue(3));
        $documentos->append($documento);

        return $documentos;
    }
    
    protected function createItemsDocumento() {
        $items = new ArrayObject();
        
        $item = $this->getMock('Pronit\CoreBundle\Entity\Documentos\Item', array('getId'), array(), '', false);
        $item->expects($this->any())
                ->method('getId')
                ->will($this->returnValue(1));
        $items->append($item);

        $item = $this->getMock('Pronit\CoreBundle\Entity\Documentos\Item', array('getId'), array(), '', false);
        $item->expects($this->any())
                ->method('getId')
                ->will($this->returnValue(2));
        $items->append($item);

        $item = $this->getMock('Pronit\CoreBundle\Entity\Documentos\Item', array('getId'), array(), '', false);
        $item->expects($this->any())
                ->method('getId')
                ->will($this->returnValue(3));
        $items->append($item);
        
        return $items;
    }

    protected function createReferenciasDocumentos(ArrayObject $documentos) {
        $referencias = new ArrayObject();
        
        $referencia = new ReferenciaDocumento($documentos[0], $documentos[1]);
        $referencias->append($referencia);

        $referencia = new ReferenciaDocumento($documentos[2], $documentos[1]);
        $referencias->append($referencia);
        
        return $referencias;
    }

    protected function createReferenciasItemsDocumentos(ArrayObject $items) {
        $referencias = new ArrayObject();
        
        $referencia = new ReferenciaItemDocumento($items[0], $items[1]);
        $referencias->append($referencia);

        $referencia = new ReferenciaItemDocumento($items[2], $items[1]);
        $referencias->append($referencia);
        
        return $referencias;
    }

    protected function createReferenciasDocumentoRepository(ArrayObject $referencias) {

        $repository = $this->getMock('Pronit\CoreBundle\Repositories\IReferenciasDocumentoRepository');
        $repository->expects($this->any())
                ->method('fetchHacia')
                ->will($this->returnCallback(function(Documento $documento) use ($referencias) {
                            $result = new ArrayObject();
                            foreach ($referencias as $referencia) {
                                if ($documento->getId() == $referencia->getDestino()->getId()) {
                                    $result->append($referencia);
                                }
                            }
                            return $result;
                        }));

        $repository->expects($this->any())
                ->method('fetchDesde')
                ->will($this->returnCallback(function(Documento $documento) use ($referencias) {
                            $result = new ArrayObject();
                            foreach ($referencias as $referencia) {
                                if ($documento->getId() == $referencia->getOrigen()->getId()) {
                                    $result->append($referencia);
                                }
                            }
                            return $result;
                        }));


        return $repository;
    }

    protected function createReferenciasItemDocumentoRepository(ArrayObject $referencias) {
        $repository = $this->getMock('Pronit\CoreBundle\Repositories\IReferenciasItemDocumentoRepository');
        $repository->expects($this->any())
                ->method('fetchHacia')
                ->will($this->returnCallback(function(Item $item) use ($referencias) {
                            $result = new ArrayObject();
                            foreach ($referencias as $referencia) {
                                if ($item->getId() == $referencia->getDestino()->getId()) {
                                    $result->append($referencia);
                                }
                            }
                            return $result;
                        }));
        
        $repository->expects($this->any())
                ->method('fetchDesde')
                ->will($this->returnCallback(function(Item $item) use ($referencias) {
                            $result = new ArrayObject();
                            foreach ($referencias as $referencia) {
                                if ($item->getId() == $referencia->getOrigen()->getId()) {
                                    $result->append($referencia);
                                }
                            }
                            return $result;
                        }));

        return $repository;
    }

    public function testObtenerDocumentosOrigen() {
        $documentos = $this->createDocumentos();
        $items = $this->createItemsDocumento();
        
        $referenciasDocumentos = $this->createReferenciasDocumentos($documentos);
        $referenciasItemsDocumento = $this->createReferenciasItemsDocumentos($items);

        $manager = new ReferenciasManager($this->createReferenciasDocumentoRepository($referenciasDocumentos), $this->createReferenciasItemDocumentoRepository($referenciasItemsDocumento));

        $documentosOrigen = $manager->obtenerDocumentosOrigen($documentos[1]);

        $this->assertEquals(2, $documentosOrigen->count(), "La cantidad de documentos origen no es correcta.");
        $this->assertEquals($documentosOrigen[0]->getId(), $documentos[0]->getId(), "El documento origen no es el esperado.");
        $this->assertEquals($documentosOrigen[1]->getId(), $documentos[2]->getId(), "El documento origen no es el esperado.");
    }

    public function testObtenerDocumentosDestino() {
        $documentos = $this->createDocumentos();
        $items = $this->createItemsDocumento();

        $referenciasDocumentos = $this->createReferenciasDocumentos($documentos);
        $referenciasItemsDocumento = $this->createReferenciasItemsDocumentos($items);

        $manager = new ReferenciasManager($this->createReferenciasDocumentoRepository($referenciasDocumentos), $this->createReferenciasItemDocumentoRepository($referenciasItemsDocumento));

        $documentosDestino = $manager->obtenerDocumentosDestino($documentos[0]);

        $this->assertEquals(1, $documentosDestino->count(), "La cantidad de documentos destino no es correcta.");
        $this->assertEquals($documentosDestino[0]->getId(), $documentos[1]->getId(), "El documento destino no es el esperado.");
    }

    public function testObtenerItemsOrigen() {
        $documentos = $this->createDocumentos();
        $items = $this->createItemsDocumento();
        
        $referenciasDocumentos = $this->createReferenciasDocumentos($documentos);
        $referenciasItemsDocumento = $this->createReferenciasItemsDocumentos($items);

        $manager = new ReferenciasManager($this->createReferenciasDocumentoRepository($referenciasDocumentos), $this->createReferenciasItemDocumentoRepository($referenciasItemsDocumento));

        $itemsOrigen = $manager->obtenerItemsOrigen($items[1]);

        $this->assertEquals(2, $itemsOrigen->count(), "La cantidad de items origen no es correcta.");
        $this->assertEquals($itemsOrigen[0]->getId(), $items[0]->getId(), "El item origen no es el esperado.");
        $this->assertEquals($itemsOrigen[1]->getId(), $items[2]->getId(), "El item origen no es el esperado.");
    }

    public function testObtenerItemsDestino() {
        $documentos = $this->createDocumentos();
        $items = $this->createItemsDocumento();
        
        $referenciasDocumentos = $this->createReferenciasDocumentos($documentos);
        $referenciasItemsDocumento = $this->createReferenciasItemsDocumentos($items);

        $manager = new ReferenciasManager($this->createReferenciasDocumentoRepository($referenciasDocumentos), $this->createReferenciasItemDocumentoRepository($referenciasItemsDocumento));

        $itemsDestino = $manager->obtenerItemsDestino($items[0]);

        $this->assertEquals(1, $itemsDestino->count(), "La cantidad de items destino no es correcta.");
        $this->assertEquals($itemsDestino[0]->getId(), $items[1]->getId(), "El item destino no es el esperado.");
    }
    
}
