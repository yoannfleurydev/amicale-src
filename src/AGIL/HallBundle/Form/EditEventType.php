<?php

namespace AGIL\HallBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Validator\Constraints\NotBlank;

class EditEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('eventTitle', TextType::class, array(
            'label' => false,
            'required' => true,
            'constraints' => array(
                new NotBlank(),
            ),
            'attr' => array(
                'class' => 'form-control',
            )
        ));

        $builder->add('eventText', TextareaType::class, array(
            'label' => false,
            'required' => true,
            'constraints' => array(
                new NotBlank(),
            ),
            'attr' => array(
                'class' => 'tinymce form-control',
            )
        ));

        $builder->add('tags', TextType::class, array(
            'label' => false,
            'required' => false,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Tags associés',
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
            'required' => false,
            'attr' => array(
                'class' => 'form-control',
            )
        ));

        $builder->add('photos', CollectionType::class, array(
            // each entry in the array will be an "email" field
            'entry_type'   => FileType::class,
            'label' => false,
            'prototype_name' => 0,
            'allow_add' => true,
            'allow_delete' => true,
            // these options are passed to each "email" type
            'entry_options'  => array(
                'required' => false,
                'multiple' => true,
                'label' => false,
                'attr'   => array('class' => 'form-control')
            ),
        ));

        $builder->add('Modifier', SubmitType::class, array(
            'label' => false,
            'attr' => array(
                'class' => 'btn btn-primary'
            )
        ));
    }

    public function getBlockPrefix()
    {
        return 'event_edit_form';
    }
}