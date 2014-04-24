<?php

namespace Pronit\Geographic\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
    
    public function metadataProviderAction()
    {
/*
        $queryBuilder = $this->getDoctrine()
                                            ->getRepository('Pronit\Geographic\CoreBundle\Entity\DivisionAdministrativa')
                                            ->createQueryBuilder('da');
        $queryBuilder->join('da.metadataValues', 'mv')
                                ->where("mv.metadataName = 'himno'")
                                ->andWhere('mv.value LIKE ?1')
                                ->setParameter(1, '%mor%');
        
        $result = $queryBuilder->getQuery()->getResult();
        
        die( "Resultados: " . count($result) );
*/        
        $divisionAdministrativaMetadataProvider = $this->get('bluegrass.metadata_provider_factory')->getProviderFor( 'Pronit\Geographic\CoreBundle\Entity\DivisionAdministrativa' );
        
        /* @var $divisionAdministrativa \Pronit\Geographic\CoreBundle\Entity\DivisionAdministrativa  */

        $divisionAdministrativa = $this->getDoctrine()->getManager()
                                                                    ->getRepository('Pronit\Geographic\CoreBundle\Entity\DivisionAdministrativa')
                                                                    ->findOneByNombre( 'Argentina' );                        
        
        /*
         * Prueba de getter de metadatos 
         * 
         */   
/*         
        echo $divisionAdministrativa->getMetadata($divisionAdministrativaMetadataProvider->getMetadata("himno"));
        
        echo "<br>";
        
        $moneda = $divisionAdministrativa->getMetadata($divisionAdministrativaMetadataProvider->getMetadata("moneda"));
        echo $moneda -> getNombre();
        
        die( '' );
   */           
        /*
         * Prueba de setter de metadatos 
         * 
         * 
         */        

        $moneda = $this->getDoctrine()->getManager()
                                                                    ->getRepository('Pronit\ParametrizacionGeneralBundle\Entity\Moneda')
                                                                    ->findOneByNombre( 'Pesos' );

        
        $divisionAdministrativa->setMetadata($divisionAdministrativaMetadataProvider->getMetadata("himno"), 'Oid ');
        $divisionAdministrativa->setMetadata($divisionAdministrativaMetadataProvider->getMetadata("moneda"), $moneda);
        
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($divisionAdministrativa);
        $em->flush();
        die("test");
        
    }
}
