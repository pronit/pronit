<?php

namespace Pronit\ComprasBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

use Pronit\ComprasBundle\Entity\Documentos\OrdenesPago\ItemPagoEfectivo;
use Pronit\ComprasBundle\Entity\Documentos\OrdenesPago\ItemPagoTransferenciaBancaria;

use Doctrine\ORM\EntityManager;

class ItemsPagoTransformer implements DataTransformerInterface
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Transforms an object (issue) to a string (number).
     *
     * @param  \Doctrine\Common\Collections\ArrayCollection|null $arrayCollection
     * @return string
     */
    public function transform($arrayCollection)
    {        
        if (null === $arrayCollection) {
            return new \Doctrine\Common\Collections\ArrayCollection();
        }        
               
        
        return $arrayCollection;
    }

    /**
     * Transforms a string (number) to an object (issue).
     *
     * @param  \Doctrine\Common\Collections\ArrayCollection $arrayCollection
     *
     * @return ArrayCollection
     *
     */
    public function reverseTransform($arrayCollection)
    {
        $collectionTransformed = new \Doctrine\Common\Collections\ArrayCollection();
        
        foreach( $arrayCollection as $value )
        {
            switch( $value['type'] ){
                case "efectivo": 
                    
                    $itemPago = new ItemPagoEfectivo();
                    
                    break;
                
                case "transferencia": 
                    
                    $cuentaBancaria = $this->em->getRepository('Pronit\ParametrizacionGeneralBundle\Entity\Bancos\CuentaBancaria')->find( $value['cuentaBancaria'] );
                    
                    $itemPago = new ItemPagoTransferenciaBancaria();
                    $itemPago->setCuentaBancaria( $cuentaBancaria );
                    
                    break;
            }
            
            /** todo: esto sacarlo dinámico */
            $cuentaMayor = $this->em->getRepository('Pronit\CoreBundle\Entity\Contabilidad\CuentasContables\Cuenta')->find( $value['cuentaMayor'] );
            
            $itemPago->setImporte( $value['importe'] );
            $itemPago->setCuenta($cuentaMayor);
                    
            $collectionTransformed->add( $itemPago );            
        }
        
//        echo "<br> reverseTransform <br>";        
        
        return $collectionTransformed;
    }
}