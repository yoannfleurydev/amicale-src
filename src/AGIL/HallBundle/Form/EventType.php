<?php

namespace AGIL\HallBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\VarDumper\VarDumper;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('eventTitle', 'text', array(
            'label' => false,
            'required' => true,
//            'attr' => array(
//                'class' => 'form-control',
//            )
        ));

        $builder->add('eventText', 'text', array(
            'label' => false,
            'required' => true,
//            'attr' => array(
//                'class' => 'form-control',
//            )
        ));

        $builder->add('eventDate', 'date', array(
            'label' => false,
            'required' => true,
//            'attr' => array(
//                'class' => 'form-control',
//            )
        ));

        $builder->add('Ajouter', 'submit', array(
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