<?php

namespace Pronit\ParametrizacionGeneralBundle\Entity\Bancos;

use Doctrine\ORM\Mapping as ORM;

use Pronit\ParametrizacionGeneralBundle\Entity\Bancos\Banco;

/**
 *
 * @author ldelia
 * @ORM\Entity
 * @ORM\Table(name="pgener_cuentabancaria")
 */
class CuentaBancaria
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * 
     * @ORM\Column(type="string") 
     * @var string 
     */
    private $numero;

    /**
     * @ORM\ManyToOne(targetEntity="Pronit\ParametrizacionGeneralBundle\Entity\Bancos\Banco", inversedBy="cuentas") 
     */
    private $banco;

    public function __construct() 
    {
        
    }

    function getNumero()
    {
        return $this->numero;
    }

    function getBanco()
    {
        return $this->banco;
    }

    function setNumero($numero)
    {
        $this->numero = $numero;
    }

    function setBanco(Banco $banco)
    {
        $this->banco = $banco;
    }
    
    public function __toString()
    {
        return (string) $this->getBanco() . " " . $this->getNumero();
    }
}
