<?php

namespace Pronit\EstructuraEmpresaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('PronitEstructuraEmpresaBundle:Default:index.html.twig', array('name' => $name));
    }
}
