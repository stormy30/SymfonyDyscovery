<?php

namespace VC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AdvertController extends Controller
{
    public function indexAction()
    {
      $content = $this
          ->get('templating')
          ->render('VCPlatformBundle:Advert:index.html.twig', array('nom' => 'winzou'));

        return new Response($content);
    }
    public function goodbyeAction()
    {
      $content = $this
          ->get('templating')
          ->render('VCPlatformBundle:Advert:goodbye.html.twig');

        return new Response($content);
    }
}
