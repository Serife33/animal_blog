<?php

namespace App\Form;

use App\Entity\Comment;
use App\Entity\Post;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TypeTextType::class, [
                'label' => 'Pseudo', 
                'attr' => [
                    'placeholder' => 'Votre pseudo'
                ]
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Commentaire', 
                'attr' => [
                    'placeholder' => 'Votre commentaire'
                ]               
            ])
            ->add('createdAt', null, [
                'widget' => 'single_text',
                'label' => false, 
                'attr' => [
                    'style' => 'display: none',
                ],               
            ])
            ->add('id_post', EntityType::class, [
                'class' => Post::class,
                'choice_label' => 'id',
                'label' => false,
                'attr' => [
                    'style' => 'display: none',
                ],
            ])
        ;
    }



    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
