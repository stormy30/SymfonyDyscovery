<?php


namespace VC\PlatformBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
*@Annotation
*/
class Antiflood extends Constraint
{
  public $message = "Vous aves déjà posté un message il y a moins de 15 secondes, merci
  d'attendre un peu.";

  public function validatedBy()
  {
    return 'vc_platform_antiflood'; // ici, on fait appel à l'alias du service
  }
}
