<?php


namespace VC\PlatformBundle\Antispam;

class VCAntispam
{
  private $mailer;
  private $locale;
  private $minLength;

  public function __construct(\swift_Mailer $mailer, $locale, $minLength){
    $this->mailer    = $mailer;
    $this->locale    = $locale;
    $this->minLength = (int) $minLength;
}

  /**
     * Vérifie si le texte est un spam ou non
     *
     * @param string $text
     * @return bool
     */
public function isSpam($text)
{
  return strlen($text) < $this->minLength;
}
}
