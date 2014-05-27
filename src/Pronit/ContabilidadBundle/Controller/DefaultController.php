<?php

namespace Pronit\ContabilidadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('PronitContabilidadBundle:Default:index.html.twig', array('name' => $name));
    }
}
