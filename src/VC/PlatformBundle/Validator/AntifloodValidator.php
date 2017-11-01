<?php


namespace VC\PlatformBundle\Validator;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\httpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\validator\ConstraintValidator;

class AntifloodValidator extends ConstraintValidator
{
  /**
  * @var RequestStack
  */
  private $requesttack;

  /**
  * @var EntityManagerInterface
  */
  private $em;

  // Les arguments déclarés dans la définition du service arrivent au constructeur
  // On doit les enregistrer dans l'objet pour pourvoir s'en resservir dans la méthode validate()
  public function __construct(RequestStack $requestStack, EntityManagerInterface $em)
   {
     $this->requestStack = $requestStack;
     $this->em           = $em;
   }
  public function validate($value, Constraint $constraint)
  {
    // pour recupérer l'objet Request tel qu'on le connait, il faut utiliser getCurrentRequest du service requestStack
      $request = $this->requestStack->getCurrentRequest();

    //on récupère l'Ip de celui qui poste
    $ip = $request->getClientIp();

    // on vérifie si cette Ip a déjà posté une candidature il y a moins de 15 secondes
     $isFlood = $this->em
       ->getRepository('VCPlatformBundle:Application')
       ->isFlood($ip, 15)    // Bien entendu, il faudrait écrire cette méthode isFlood , c'est pour l'exemple
       ;

    if ($isFlood){
      // C'est cette ligne qui déclenche l'erreur pour le formulaire, avec un argument le massage de la contrainte

      $this->context->addViolation($constraint->message);
    }
  }
}
