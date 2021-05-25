<?php

namespace App\Form;

use App\Entity\CyclingShirt;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CyclingShirtType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('shirtPictureFront', VichFileType::class, [
                'label' => 'Maillot face avant',
                'required'      => false,
                'allow_delete'  => false,
                'download_uri' => false,
                'attr' => ['placeholder' => 'Choisir un fichier'],
            ])

            ->add('shirtPictureBack', VichFileType::class, [
                'label' => 'Maillot face arrière',
                'required'      => false,
                'allow_delete'  => false,
                'download_uri' => false,
                'attr' => ['placeholder' => 'Choisir un fichier'],
            ])

            ->add('name', TextType::class, [
                'label' => 'Nom du maillot',
            ])

            ->add('years', ChoiceType::class, [
                'choices' => [
                    'Années 50-60' => 'Années 50-60',
                    'Années 70' => 'Années 70',
                    'Années 80' => 'Années 80',
                    'Années 90' => 'Années 90',
                ],
                'label' => 'Années : ',
                'expanded' => true,
            ])

            ->add('cyclistName', TextType::class, [
                'label' => 'Nom du cycliste',
                'required' => false,
            ])

            ->add('teamInformations', TextareaType::class, [
                'label' => 'Informations sur l\'équipe',
                'required' => false,
            ])

            ->add('results', TextareaType::class, [
                'label' => 'Résultats notables : ',
                'required' => false,
            ])

            ->add('city', TextType::class, [
                'label' => 'Ville d\'origine du club',
                'required' => false,
            ])

            ->add('latitude', NumberType::class, [
                'label' => 'latitude',
                'required' => false,
                'scale' => 7,
            ])

            ->add('longitude', NumberType::class, [
                'label' => 'longitude',
                'required' => false,
                'scale' => 7,
            ])

            ->add('departmentName', TextType::class, [
                'label' => 'nom du département',
                'required' => false,
            ])

            ->add('departmentNumber', NumberType::class, [
                'label' => 'numéro du département',
                'required' => false,
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
