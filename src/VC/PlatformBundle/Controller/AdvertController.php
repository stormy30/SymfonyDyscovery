<?php

namespace VC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse; // Ne pas oublier  ce use!!!
use Symfony\Component\HttpFoundation\Response;

class AdvertController extends Controller
{
  // On récupère tous les paramètres en arguments de la méthode
      public function indexAction()
      {
        //on veut avoir l'url de l'annonce d'id 5.
        $url = $this->get('router')->generate(
            'vc_platform_view' ,  // 1er argument : le nom de la router
             array('id' => 5)     // 2e argument : les valeurs des paramètres
        );

        return new Response("L'URL de l'annonce d'id 5 est :".$url);
      }


      public function viewSlugAction($slug, $year, $format)
      {
          return new Response(
              "On pourrait afficher l'annonce correspondant au
              slug '".$slug."', créée en ".$year." et au format ".$format."."
          );
      }
  // La route fait appel à OCPlatformBundle:Advert:view,
  // on doit donc définir la méthode viewAction.
  // On donne à cette méthode l'argument $id, pour
  // correspondre au paramètre {id} de la route

  public function viewAction($id)
  {
    // que l'on renvoie du JSON et non du HTML
    return new JsonResponse(array('id' => $id));

  }
}
