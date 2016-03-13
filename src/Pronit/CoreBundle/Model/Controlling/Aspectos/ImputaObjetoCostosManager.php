<?php

namespace Pronit\CoreBundle\Model\Controlling\Aspectos;

use Doctrine\ORM\EntityManager;

use Pronit\CoreBundle\Model\Aspectos\IAspectoManager;

use Pronit\CoreBundle\Entity\Operaciones\Operacion;
use Pronit\CoreBundle\Entity\Controlling\Aspectos\ImputaObjetoCostos;

/**
 *
 * @author ldelia
 */
class ImputaObjetoCostosManager implements IAspectoManager
{
    /**
     *
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em) 
    {
        $this->em = $em;
    }

    /**
     * 
     * @param Operacion $operacion
     */
    public function set(Operacion $operacion)
    {
        $aspecto = new ImputaObjetoCostos($operacion, 1);
        
        $this->em->persist($aspecto);
        
        return $aspecto;
    }
    
    /**
     * 
     * @return Aspecto
     * @param Operacion $operacion
     */
    public function get(Operacion $operacion)
    {
        $aspecto = $this->em->getRepository('Pronit\CoreBundle\Entity\Controlling\Aspectos\ImputaObjetoCostos')->findOneBy(array('operacion'=> $operacion));
        
        if(is_null($aspecto) ){
            throw new \Exception("La operación " . $operacion->getCodigo() . " no Imputa Objeto Costos");
        }        
        
        return $aspecto;
    }
    
    /**
     * @return boolean 
     * @param Operacion $operacion
     */
    public function has(Operacion $operacion)
    {
        $result = $this->em->getRepository('Pronit\CoreBundle\Entity\Controlling\Aspectos\ImputaObjetoCostos')->findBy(array('operacion'=> $operacion));
        
        return count($result);
    }
}
