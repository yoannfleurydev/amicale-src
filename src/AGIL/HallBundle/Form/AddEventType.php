<?php

namespace AGIL\HallBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\VarDumper\VarDumper;

class AddEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('eventTitle', TextType::class, array(
            'label' => false,
            'required' => true,
//            'attr' => array(
//                'class' => 'form-control',
//            )
        ));

        $builder->add('eventText', TextareaType::class, array(
            'label' => false,
            'required' => false,
//            'attr' => array(
//                'class' => 'form-control',
//            )
        ));

        $builder->add('eventDate', DateTimeType::class, array(
            'label' => false,
            'required' => true,
//            'attr' => array(
//                'class' => 'form-control',
//            )
        ));

        $builder->add('eventDateEnd', DateTimeType::class, array(
            'label' => false,
            'required' => true,
//            'attr' => array(
//                'class' => 'form-control',
//            )
        ));

        $builder->add('photos', CollectionType::class, array(
                'type'          =>      new PhotoType(),
                'allow_add'     =>      true,
                'allow_delete'  =>      true
            )
        ),

        $builder->add('Ajouter', SubmitType::class, array(
            'label' => false,
//            'attr' => array(
//                'class' => 'form-control'
//            )
        ));

    }

    public function getBlockPrefix()
    {
        return 'event_add_form';
    }
}