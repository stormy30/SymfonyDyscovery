<?php

namespace VC\PlatformBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
// N'oubliez pas de rajouter ce « use », il définit le namespace pour les annotations de validation
use Symfony\Component\Validator\Constraints as Assert;
use VC\PlatformBundle\Validator\Antiflood;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
/**
 * Advert
 *
 * @ORM\Table(name="advert")
 * @ORM\Entity(repositoryClass="VC\PlatformBundle\Repository\AdvertRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Advert
{
  /**
     * @ORM\ManyToMany(targetEntity="VC\PlatformBundle\Entity\Category", cascade={"persist"})
     * @ORM\JoinTable(name="vc_advert_category")
     */
    private $categories;

  /**
     * @ORM\OneToOne(targetEntity="VC\PlatformBundle\Entity\Image", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $image;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
       * @ORM\Column(name="published", type="boolean")
       */
      private $published = true;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     *@Assert\DateTime()
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, unique=true)
     * @Assert\Length(min=10)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     * @Assert\length(min=2)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     * @Assert\NotBlank()
     * @Antiflood()
     */
    private $content;

    /**
     * @ORM\OneToMany(targetEntity="VC\PlatformBundle\Entity\Application", mappedBy="advert")
    */
    private $applications; // Notez le « s », une annonce est liée à plusieurs candidatures

    /**
    * @ORM\Column(name="updated_at", type="datetime", nullable=true)
    */
    private $updateAt;

    /**
     * @ORM\Column(name="nb_applications", type="integer")
     */
    private $nbApplications = 0;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    public function __construct()
    {
      $this->date         = new \Datetime();
      $this->categories   = new ArrayCollection();
      $this->applications = new ArrayCollection();
    }



    /**
     * @ORM\PreUpdate
     */
    public function updateDate()
    {
    $this->setUpdateAt(new \Datetime());
    }

    public function increaseApplication()
    {
    $this->nbApplications++;
    }

    public function decreaseApplication()
    {
    $this->nbApplications--;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Advert
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Advert
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return Advert
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Advert
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set published
     *
     * @param boolean $published
     *
     * @return Advert
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set image
     *
     * @param \VC\PlatformBundle\Entity\Image $image
     *
     * @return Advert
     */
    public function setImage(Image $image = null)
    {
        $this->image = $image;

    }

    /**
     * Get image
     *
     * @return \VC\PlatformBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Add category
     *
     * @param \VC\PlatformBundle\Entity\Category $category
     *
     * @return Advert
     */
    public function addCategory(\VC\PlatformBundle\Entity\Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \VC\PlatformBundle\Entity\Category $category
     */
    public function removeCategory(\VC\PlatformBundle\Entity\Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param Application $application
     */
   public function addApplication(Application $application)
   {
    $this->applications[] = $application;

    // On lie l'annonce à la candidature
    $application->setAdvert($this);
  }

  /**
   * @param Application $application
   */
  public function removeApplication(Application $application)
  {
    $this->applications->removeElement($application);
  }

  /**
   * @return \Doctrine\Common\Collections\Collection
   */
  public function getApplications()
  {
    return $this->applications;
  }
  /**
    * @param integer $nbApplications
    */
   public function setNbApplications($nbApplications)
   {
       $this->nbApplications = $nbApplications;
   }

   /**
    * @return integer
    */
   public function getNbApplications()
   {
       return $this->nbApplications;
   }

   /**
    * @param string $slug
    */
   public function setSlug($slug)
   {
       $this->slug = $slug;
   }

   /**
    * @return string
    */
   public function getSlug()
   {
       return $this->slug;
   }

    /**
     * Set updateAt
     *
     * @param \DateTime $updateAt
     *
     * @return Advert
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * Get updateAt
     *
     * @return \DateTime
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    // public function testAction()
    // {
    //   $advert = new Advert;
    //
    //   $advert->setDate(new_Datetime()); //champs "date" Ok
    //   $advert->setTitle('abc');        //champs "title" incorect : moins de 10 caractères
    //   //$advert-> setContent('blabla') // champ "content" incorrect : on ne le definit pas.
    //   $advert->setAuthor('A');        // champs "author" incorrect: moins de 2 cararatères
    //
    //   //On récupère le service Validator
    //   $validator =$this->get('validator');
    //
    //   // on déclenche la validation sur notre object
    //   $listErrors = $validator->validate($advert);
    //
    //   // di $listErroes n'est pas vide, on affiche les erreurs
    //   if(count($listErrors) >0) {
    //      // $listErrors est un objet, sa méthode __toString permet de lister joliement les erreurs
    //      return new Response((string) $listErrors);
    //   } else {
    //     return new Response("L'annonce est valide !");
    //   }
    //
    // }

    /**
     * @Assert\Callback
     */
    public function isContentValid(ExecutionContextInterface $context)
    {
      $forbiddenWords = array('démotivation', 'abandon');
      // On vérifie que le contenu ne contient pas l'un des mots
      if (preg_match('#'.implode('|', $forbiddenWords).'#', $this->getContent())) {
        // La règle est violée, on définit l'erreur
        $context
          ->buildViolation('Contenu invalide car il contient un mot interdit.') // message
          ->atPath('content')                                                   // attribut de l'objet qui est violé
          ->addViolation() // ceci déclenche l'erreur, ne l'oubliez pas
        ;
      }
    }

}
