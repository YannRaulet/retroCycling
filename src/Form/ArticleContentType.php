<?php

namespace App\Form;

use App\Entity\ArticleContent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleContentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('article', null, [
                'label' => 'Nom de l\'article',
                'choice_label' => 'name'
            ])

            ->add('title', TextType::class, [
                'label' => 'Titre de l\'article',
                'required' => false,
            ])

            ->add('content', TextareaType::class, [
                'label' => 'Le contenu',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ArticleContent::class,
        ]);
    }
}
