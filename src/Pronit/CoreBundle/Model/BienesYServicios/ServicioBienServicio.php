<?php

namespace Pronit\CoreBundle\Model\BienesYServicios;

use Doctrine\Common\Persistence\ObjectManager;
use Pronit\CoreBundle\Model\Almacenamiento\IServicioAlmacenamiento;
use Pronit\EstructuraEmpresaBundle\Entity\Almacen;
use Pronit\EstructuraEmpresaBundle\Entity\CentroLogistico;
use Pronit\EstructuraEmpresaBundle\Entity\SociedadFI;
use Pronit\GestionBienesYServiciosBundle\Entity\BienServicio;
use Pronit\GestionBienesYServiciosBundle\Entity\Customizing\EstructuraEmpresa\BienServicioSociedadFI;
use Pronit\GestionBienesYServiciosBundle\Entity\Material;

/**
 * Description of ServicioMateriales
 *
 * @author gcaseres
 */
class ServicioBienServicio implements IServicioBienServicio
{

    /**
     *
     * @var IServicioAlmacenamiento
     */
    private $servicioAlmacenamiento;

    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(ObjectManager $em, IServicioAlmacenamiento $servicioAlmacenamiento)
    {
        $this->em = $em;
        $this->servicioAlmacenamiento = $servicioAlmacenamiento;
    }

    public function asociarSociedad(BienServicio $bienServicio, SociedadFI $sociedad, $codigo)
    {
        $bienServicioSociedadFI = new BienServicioSociedadFI();
        $bienServicioSociedadFI->setBienServicio($bienServicio);
        $bienServicioSociedadFI->setSociedadFI($sociedad);
        $bienServicioSociedadFI->setCodigo($codigo);

        $this->em->persist($bienServicioSociedadFI);

        if ($bienServicio instanceof Material) {
            $this->configurarMaterial($bienServicio, $sociedad);
        }

        $this->em->flush();
        return $bienServicioSociedadFI;
    }

    private function configurarMaterial(Material $material, SociedadFI $sociedad) {
        foreach ($sociedad->getCentrosLogisticos() as $centroLogistico) {
            /* @var $centroLogistico CentroLogistico */
            foreach ($centroLogistico->getAlmacenes() as $almacen) {
                /* @var $almacen Almacen */
                $this->servicioAlmacenamiento->configurar($material, $almacen);
            }
        }
    }

    public function desasociarSociedad(BienServicio $material, SociedadFI $sociedad)
    {

    }

}
