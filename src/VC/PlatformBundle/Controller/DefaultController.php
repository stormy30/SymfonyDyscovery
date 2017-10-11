<?php

namespace VC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('VCPlatformBundle:Default:index.html.twig');
    }
}
