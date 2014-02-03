<?php

namespace Pronit\ParametrizacionGeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('PronitParametrizacionGeneralBundle:Default:index.html.twig', array('name' => $name));
    }
}
