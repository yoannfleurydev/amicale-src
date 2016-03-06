<?php

namespace AGIL\HallBundle\Form;

//use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\VarDumper\VarDumper;

class EditEventType extends AbstractType
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
            'required' => true,
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

        $builder->add('Modifier', SubmitType::class, array(
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