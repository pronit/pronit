<?php

namespace Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo;

use Doctrine\ORM\Mapping as ORM;
use Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\Estrategias\EstrategiaCalculo;
use Pronit\CoreBundle\Model\Automatizacion\EsquemasCalculo\Contextos\ContextoItemEsquemaCalculo;

/**
 * Description of ClaseCondicion
 *
 * @author gcaseres
 * @ORM\Entity
 * @ORM\Table(name="core_clasescondicion")
 */
class ClaseCondicion
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=8)
     */
    protected $codigo;

    /**
     * @ORM\Column(type="string", length=60)
     */
    protected $nombre;

    /** @var EstrategiaCalculo */
    protected $estrategiaCalculo;

    public function getId()
    {
        return $this->id;
    }

    public function setCodigo($value)
    {
        $this->codigo = $value;
    }

    public function getCodigo()
    {
        return $this->codigo;
    }

    public function setNombre($value)
    {
        $this->nombre = $value;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * 
     * @param EstrategiaCalculo $value
     */
    public function setEstrategiaCalculo(EstrategiaCalculo $value)
    {
        $this->estrategiaCalculo = $value;
    }

    /**
     * 
     * @return EstrategiaCalculo
     */
    public function getEstrategiaCalculo()
    {
        return $this->estrategiaCalculo;
    }

    /**
     * 
     * @param ContextoItemEsquemaCalculo $contexto
     */
    public function calcular(ContextoItemEsquemaCalculo $contexto, ResultadoCalculo $parcial)
    {
        $descripcion = $contexto->getItemEsquemaCalculo()->getDescripcion();

        $valor = $this->estrategiaCalculo->calcular($contexto);

        $parcial->addCondicion($descripcion, $valor);
    }

}
