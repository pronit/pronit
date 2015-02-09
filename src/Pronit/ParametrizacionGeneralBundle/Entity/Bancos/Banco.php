<?php

namespace Pronit\ParametrizacionGeneralBundle\Entity\Bancos;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;

use Pronit\ParametrizacionGeneralBundle\Entity\Bancos\CuentaBancaria;

/**
 * @author ldelia
 * @ORM\Entity
 * @ORM\Table(name="pgener_banco")
 */
class Banco
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true) 
     * @var string 
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="CuentaBancaria", mappedBy="banco", cascade={"ALL"}, orphanRemoval=true)
     * @var ArrayCollection
     */
    private $cuentas;

    public function __construct() 
    {
        $this->cuentas = new ArrayCollection();
    }

    function getNombre()
    {
        return $this->nombre;
    }

    function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }    

    /**
     * 
     * @return ArrayCollection
     */
    public function getCuentas() 
    {
        return $this->cuentas;
    }

    /**
     * 
     * @param CuentaBancaria $cuenta
     */
    public function addCuenta(CuentaBancaria $cuenta) 
    {
        $cuenta->setBanco($this);
        $this->cuentas->add($cuenta);
    }

    /**
     * 
     * @param CuentaBancaria $cuenta
     */
    public function removeCuenta(CuentaBancaria $cuenta) 
    {
        $cuenta->setBanco(null);
        $this->cuentas->removeElement($cuenta);
    }
    
    public function __toString()
    {
        return (string) $this->getNombre();
    }
}
