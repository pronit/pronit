<?php

namespace Pronit\GestionMaterialesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('PronitGestionMaterialesBundle:Default:index.html.twig', array('name' => $name));
    }
}
