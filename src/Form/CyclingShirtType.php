<?php

namespace App\Form;

use App\Entity\CyclingShirt;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CyclingShirtType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('picture', TextType::class, [
                'label' => 'L\image du maillot',
            ])

            ->add('name', TextType::class, [
                'label' => 'Nom du maillot',
            ])

            ->add('cyclistName', TextType::class, [
                'label' => 'Nom du cycliste',
            ])

            ->add('teamInformations', TextareaType::class, [
                'label' => 'Informations sur l\'équipe',
            ])

            ->add('results', TextareaType::class, [
                'label' => 'Résultats notables : ',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CyclingShirt::class,
        ]);
    }
}