<?php

namespace VC\PlatformBundle\Form;

use VC\PlatformBundle\Repository\CategoryRepository;
use VC\PlatformBundle\Form\CategoryType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
// N'oubliez pas ces deux use !
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdvertType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       // Arbitrairement, on récupère toutes les catégories qui commencent par "D"
        // $pattern ='d%';

        $builder
          ->add('date',      DateTimeType::class)
          ->add('published', CheckboxType::class, array('required' => false))
          ->add('title',     TextType::class)
          ->add('author',    TextType::class)
          ->add('content',   TextareaType::class)
          ->add('image',     ImageType::class)
          /*
                 * Rappel :
                 ** - 1er argument : nom du champ, ici « categories », car c'est le nom de l'attribut
                 ** - 2e argument : type du champ, ici « CollectionType » qui est une liste de quelque chose
                 ** - 3e argument : tableau d'options du champ
                 */
          ->add('categories', EntityType::class, array(
            'class'         => 'VCPlatformBundle:Category',
            'choice_label'  => 'name',
            'multiple'      => true,
            // 'query_builder' => function(CategoryRepository $repository) use($pattern){
            //   return $repository->getLikeQueryBuilder($pattern);
            //   }
          ))
          ->add('save',      SubmitType::class);

        // On ajoute une fonction qui va écouter un évènement
           $builder-> addEventListener(
           FormEvents::PRE_SET_DATA,   // 1er argument : L'évènement qui nous intéresse : ici, PRE_SET_DATA
           function(FormEvent $event) { // 2e argument : La fonction à exécuter lorsque l'évènement est déclenché
             // On récupère notre objet Advert sous-jacent
             $advert =$event->getData();

             // Cette condition est importante, on en reparle plus loin
             if (null === $advert){
               return; // On sort de la fonction sans rien faire lorsque $advert vaut null
             }

             // si l'annonce n'est pas publiée, ou si elle n'existe pas encore en base (id est null)
             if (!$advert->getPublished() || null === $advert->getId()) {
               //alors on ajoute le champ published
               $event->getForm()->add('published', CheckboxType::class, array('required' => false));
             } else{
               // sinon, on le supprime
               $event->getForm()->remove('published');
             }
           }
          ) ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
      $resolver->setDefaults(array(
        'data_class' => 'VC\PlatformBundle\Entity\Advert'
      ));
    }

}
