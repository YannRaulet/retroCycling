<?php

namespace App\Form;

use App\Entity\BackgroundPicture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Vich\UploaderBundle\Form\Type\VichFileType;

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

            ->add('name', TextType::class, [
                'label' => 'Nom de l\'image',
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
