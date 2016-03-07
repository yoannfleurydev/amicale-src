<?php

namespace AGIL\HallBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\File;


class PhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('photoTitle', TextType::class, array(
            'label' => false,
            'required' => true,
            'attr' => array(
                'class' => 'form-control',
            )
        ));

        $builder->add('photoDescription', TextareaType::class, array(
            'label' => false,
            'required' => false,
            'attr' => array(
                'class' => 'form-control',
            )
        ));

        $builder->add('photoUrl', FileType::class, array(
            'label' => false,
            'required' => false,
            'multiple' => true,
            'constraints' => [
                new File([
                    'maxSize' => '1M',
                    'mimeTypes' => [
                        "image/jpeg",
                        "image/png",
                        "image/bmp"
                    ],
                ])
            ],
            'attr' => array(
                'class' => 'form-control'
            )
        ));
        $builder->add('event', new AddEventType(), array (
            'data_class' => 'AGIL\HallBundle\Entity\AgilEvent',
        ));

        $builder->add('Ajouter', SubmitType::class, array(
            'label' => false,
            'attr' => array(
                'class' => 'btn btn-primary'
            )
        ));

    }

    public function getBlockPrefix()
    {
        return 'photo_form';
    }
}