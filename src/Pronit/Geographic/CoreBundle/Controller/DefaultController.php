<?php

namespace Pronit\Geographic\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\Factory\MetadataProviderFactory;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PronitGeographicCoreBundle:Default:index.html.twig', array());
    }
    
    public function localizarAction()
    {
        $textToSearch = $_POST['query'];
        
        
        $qb = $this->getDoctrine()->getEntityManager()->getRepository('Pronit\Geographic\CoreBundle\Entity\DivisionAdministrativa')->createQueryBuilder('da');
        $qb->join('da.tipo', 't')
                ->where( $qb->expr()->like('da.nombre', ':nombreDivisionAdministrativa') )
                ->andWhere( ' t.nombre IN ( :param ) ');
        
        $query = $qb->getQuery();
        $query->setParameter('nombreDivisionAdministrativa', '%'.$textToSearch.'%');
        $query->setParameter('param', array( 'Barrio', 'Ciudad', 'Distrito Federal', 'Partido' ));
        
        $divisionesAdministrativas = $query->getResult();
        
        foreach( $divisionesAdministrativas as $divisionAdministrativa  ){
            echo $divisionAdministrativa . "<br>";
        }
        die("");
    }   

    protected function testSetMetadata()
    {
        /* @var $tableMetadata \Bluegrass\Metadata\Bundle\MetadataBundle\Entity\EntityTableMetadata  */        
        $tableMetadata = $this->getDoctrine()->getManager()->getRepository('\Bluegrass\Metadata\Bundle\MetadataBundle\Entity\EntityTableMetadata')
                                                            ->findOneByEntityType('\Pronit\Geographic\CoreBundle\Entity\DivisionAdministrativa');        
        
        /**
         * Obtengo la entidad que acepta metadatos
         */
        /* @var $divisionAdministrativa \Pronit\Geographic\CoreBundle\Entity\DivisionAdministrativa  */

        $divisionAdministrativa = $this->getDoctrine()->getManager()
                                        ->getRepository('Pronit\Geographic\CoreBundle\Entity\DivisionAdministrativa')
                                        ->findOneByNombre( 'Argentina' );       
        
        /**
         * Obtengo el provider de metadatos de la entidad 
         */
        /* @var $divisionAdministrativaMetadataProvider \Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\IMetadataProvider */
        
        $divisionAdministrativaMetadataProvider = $this->get('bluegrass.metadata_provider_factory')->getMetadataProviderFor( $tableMetadata );
        

        /**
         * Se setea el valor de un metadato en la entidad (string)
         */

        $divisionAdministrativa->setMetadata($divisionAdministrativaMetadataProvider->getMetadata("himno"), 'Oid mortales el grito sagrado');
        $divisionAdministrativa->setMetadata($divisionAdministrativaMetadataProvider->getMetadata("gentilicio"), 'Argentinos');

        /**
         * Se setea el valor de un metadato en la entidad (object)
         */
        
        $moneda = $this->getDoctrine()->getManager()
                                    ->getRepository('Pronit\ParametrizacionGeneralBundle\Entity\Moneda')
                                    ->findOneByNombre( 'Peso' );        
        
        $divisionAdministrativa->setMetadata($divisionAdministrativaMetadataProvider->getMetadata("moneda"), $moneda);

        /**
         * Se persiste la entidad
         */        
        $em = $this->getDoctrine()->getEntityManager();                
        
        echo "Se guardaron los metadatos correctamente";
        
        /**
         * Obtengo la entidad que acepta metadatos
         */
        /* @var $divisionAdministrativa \Pronit\Geographic\CoreBundle\Entity\DivisionAdministrativa  */

        $divisionAdministrativa = $this->getDoctrine()->getManager()
                                        ->getRepository('Pronit\Geographic\CoreBundle\Entity\DivisionAdministrativa')
                                        ->findOneByNombre( 'España' );                                
        $divisionAdministrativa->setMetadata($divisionAdministrativaMetadataProvider->getMetadata("himno"), 'Otro himno');
        $divisionAdministrativa->setMetadata($divisionAdministrativaMetadataProvider->getMetadata("gentilicio"), 'Argentinos');
        
        $em->flush();
    }

    protected function testGetMetadata()
    {
        /* @var $tableMetadata \Bluegrass\Metadata\Bundle\MetadataBundle\Entity\EntityTableMetadata  */        
        $tableMetadata = $this->getDoctrine()->getManager()->getRepository('\Bluegrass\Metadata\Bundle\MetadataBundle\Entity\EntityTableMetadata')
                                                            ->findOneByEntityType('\Pronit\Geographic\CoreBundle\Entity\DivisionAdministrativa');        
        
        
        /**
         * Obtengo la entidad que acepta metadatos
         */
        /* @var $divisionAdministrativa \Pronit\Geographic\CoreBundle\Entity\DivisionAdministrativa  */

        $divisionAdministrativa = $this->getDoctrine()->getManager()
                                        ->getRepository('Pronit\Geographic\CoreBundle\Entity\DivisionAdministrativa')
                                        ->findOneByNombre( 'Argentina' );                        

        
        /**
         * Obtengo el provider de metadatos de la entidad 
         */
        /* @var $divisionAdministrativaMetadataProvider \Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\IMetadataProvider */
        
        $divisionAdministrativaMetadataProvider = $this->get('bluegrass.metadata_provider_factory')->getMetadataProviderFor( $tableMetadata );
        
        echo "<br>";
        echo "<br>";
        echo "Recuperar valores de metadato:";
        echo "<br>";
        
        /**
         * Se recupera el valor de un metadato en la entidad (string)
         */
        echo $divisionAdministrativa->getMetadata($divisionAdministrativaMetadataProvider->getMetadata("himno"));
        
        echo "<br>";
        
        echo $divisionAdministrativa->getMetadata($divisionAdministrativaMetadataProvider->getMetadata("gentilicio"));
        
        echo "<br>";

        /**
         * Se recupera el valor de un metadato en la entidad (object)
         */        
        $moneda = $divisionAdministrativa->getMetadata($divisionAdministrativaMetadataProvider->getMetadata("moneda"));
        echo $moneda -> getNombre();        
    }
    
    protected function testQueryMetadata()
    {
        $em = $this->getDoctrine()->getManager();
        
        $mer = new \Pronit\Geographic\CoreBundle\Model\MetadataEntityRepository\MetadataEntityRepository();
        $r2 = $mer->find($em, array( 
                'himno' => 'Oid mortales el grito sagrado',
                'gentilicio' => 'Argentinos',
        ));        
        
        echo "<br>";
        echo "<br>";
        echo "Se encontraron: " . count($r2) . " divisiones administrativas según varias condiciones";
        
        foreach($r2 as $r)
        {
            echo "<br>";
            echo $r->getNombre();
        }                
    }    
    
    public function metadataProviderAction()
    {
        $this->testSetMetadata();
        
        $this->testGetMetadata();
        
        $this->testQueryMetadata();
        die();
    }
}
