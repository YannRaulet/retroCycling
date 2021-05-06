<?php

namespace App\Form;

use App\Entity\BackgroundPicture;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class BackgroundPictureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('backgroundPicture', VichFileType::class, [
                'label' => 'Image de fond',
                'required'      => false,
                'allow_delete'  => false,
                'download_uri' => false,
                'attr' => ['placeholder' => 'Choisir un fichier'],
            ])

            ->add('name', ChoiceType::class, [
                'choices' => [
                    'Pages accueil / collection / blog / mentions légales et espace utilisateur' => 'background-main',
                    'Page de connexion' => 'background-connexion',
                    'Page contact' => 'background-contact',
                    'Espace de gestion du site (administrateur)' => 'background-admin',
                ],
                'label' => 'Emplacement de l\'image : ',
                'expanded' => true,
            ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BackgroundPicture::class,
        ]);
    }
}
