<?php

namespace VC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request; // ne jamais oublier de modifier le use en fonction de la requette
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdvertController extends Controller
{
  // On récupère tous les paramètres en arguments de la méthode
      public function indexAction($page)
      {
        // On ne sait pas combien de pages il y a
       // Mais on sait qu'une page doit être supérieure ou égale à 1
        // if(page < 1) {
        //    // On déclenche une exception NotFoundHttpException, cela va afficher

          // une page d'erreur 404 (qu'on pourra personnaliser plus tard d'ailleurs)
        //   throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
        // }

         // Ici, on récupérera la liste des annonces, puis on la passera au template

        // Mais pour l'instant, on ne fait qu'appeler le template
        return $this->render('VCPlatformBundle:Advert:index.html.twig', array(
          'listAdverts' => array()
        ));
      }
  // La route fait appel à OCPlatformBundle:Advert:view,
  // on doit donc définir la méthode viewAction.
  // On donne à cette méthode l'argument $id, pour
  // correspondre au paramètre {id} de la route

     public function viewAction($id)
     {
       // Ici, on récupérera l'annonce correspondante à l'id $id
       return $this->render('VCPlatformBundle:Advert:view.html.twig', array(
         'id' => $id
       ));
     }

      public function addAction(Request $request)
      {
        // La gestion d'un formulaire est particulière, mais l'idée est la suivante :

       // Si la requête est en POST, c'est que le visiteur a soumis le formulaire
       if ($request->isMethod('POST')) {
        // Ici, on s'occupera de la création et de la gestion du formulaire

         $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

         // Puis on redirige vers la page de visualisation de cettte annonce
         return $this->redirectToRoute('vc_platform_view', array('id' => 5));
        }

       // Si on n'est pas en POST, alors on affiche le formulaire
        return $this-render('VCPlatformBundle:Advert:add.html.twig');
      }

      public function editAction($id, Request $request)
      {
      // Ici, on récupérera l'annonce correspondante à l'id

      // Même mécanisme que pour l'ajout
      if ($request->isMethod('POST')) {
        $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');

        return $this->redirectToRoute('vc_platform_view', array('id' => 5));
       }

      return $this->render('VCPlatformBundle:advert:edit.html.twig');
     }

      public function deleteAction($id)
      {
        // Ici, on récupérera l'annonce correspondant à $id

       // Ici, on gérera la suppression de l'annonce en question


        return $this->render('OCPlatformBundle:Advert:delete.html.twig');
      }

      public function menuAction($limit)
      {
        //On fixe en dur une liste ici, bien entendu par la suite
        //On la récupérera depuis la BDD !
        $listAdverts = array(
          array('id' => 2, 'title' => 'Recherche developpeur Symfony'),
          array('id' => 5, 'title' => 'Mission de webmaster'),
          array('id' => 9, 'title' => 'Offre de stage webdesigner')
        );

        return $this->render('VCPlatformBundle:Advert:menu.html.twig', array(
          //Tout l'intérêt est ici : le contrôleur passe
          //lesvariables nécessaires au template !
          'listAdverts' => $listAdverts
        ));
      }

  }
