<?php

namespace AGIL\HallBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class AddEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('eventTitle', TextType::class, array(
            'label' => false,
            'required' => true,
            'attr' => array(
                'class' => 'form-control',
            )
        ));

        $builder->add('eventText', TextareaType::class, array(
            'label' => false,
            'required' => false,
            'attr' => array(
                'class' => 'form-control',
            )
        ));

        $builder->add('eventDate', DateTimeType::class, array(
            'label' => false,
            'required' => true,
            'attr' => array(
                'class' => 'form-control',
            )
        ));

        $builder->add('eventDateEnd', DateTimeType::class, array(
            'label' => false,
            'required' => true,
            'attr' => array(
                'class' => 'form-control',
            )
        ));

        $builder->add('photos', FileType::class, array(
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

        $builder->add('Ajouter', SubmitType::class, array(
            'label' => false,
            'attr' => array(
                'class' => 'btn btn-primary'
            )
        ));

    }

    public function getBlockPrefix()
    {
        return 'event_add_form';
    }
}