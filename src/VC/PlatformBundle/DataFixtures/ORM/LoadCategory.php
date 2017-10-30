<?php


namespace VC\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use VC\PlatformBundle\Entity\Category;

Class LoadCategory implements FixtureInterface
{
  //Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    //liste des noms de catégorie à ajouter
     $names = array(
      'Développement web',
      'Développement mobile',
      'Graphisme',
      'intégration',
      'Réseau'
    );

    foreach ($names as $name) {
      // on crée la catégorie
      $category = new Category();
      $category->setName($name);

      //on la persiste
      $manager->persist($category);
    }

    //on déclenche l'enregistrement de toutes les catégories
    $manager->flush();

  }
}
