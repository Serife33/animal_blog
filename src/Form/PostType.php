<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\Theme;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TypeTextType::class, [
                'label' => 'Titre', // pour changer le nom de l'ennoncé
                'attr' => [
                    'placeholder' => 'Ajouter le titre du post' // pour ajouter un placeholder
                ]
            ])
            ->add('theme', EntityType::class , [
                'class' => Theme::class,
                 'choice_label' => 'name',
                 'label'=> 'Théme',
                 'placeholder'=> 'Choisir un théme',
            ])
            ->add('summary', TextareaType::class, [
                'label' => 'Résumé', 
                'attr' => [
                    'placeholder' => 'Veuillez noter le résumé du post'
                    ]
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Contenu', 
                'attr' => [
                    'placeholder' => 'Veuillez noter le contenu du post'
                    ]
            ])
            ->add('image', FileType::class, [
                'label' => 'illustration', 
                'mapped'=> false 
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
