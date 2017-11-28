<?php


namespace VC\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use VC\UserBundle\Entity\User;

 Class LoadUser implements FixtureInterface
{
   public function  load(ObjectManager $manager)
   {
       // les noms d'utilisateurs à créer
       $listNames = array('Alexandre', 'Martine', 'Anna');

       foreach($listNames as $name){
           //on crée l'utilisateur
           $user = new User;

           //Le nom d'utilisateur et le mot de passe sont identiques pour l'instant
           $user->setUsername($name);
           $user->setPassword($name);

           //on ne se sert pas du sel pour l'instant
           $user->setRoles(array('ROLE_USER'));

           //on le persiste
           $manager->persit($user);
       }

       //on déclenche l'enregistrement
       $manager->flush();
   }
}