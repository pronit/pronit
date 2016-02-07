<?php

namespace Pronit\CoreBundle\Controller\Controlling;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LiquidacionObjetosCostoController extends Controller
{
    public function indexAction()
    {
        return $this->render('PronitCoreBundle:Controlling:index.html.twig');
    }    
}
