<?php

namespace AGIL\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('email', 'email', array(
            'label' => false,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Email',
            )
        ));

        /*$builder->add('role', 'choice', array(
            'choices' => array(
                'user' => 'Membre',
                'moderator' => 'Modérateur',
                'admin' => 'Administrateur'
            ),
            'multiple' => false,
            'expanded' => true,
            'attr' => array(
                'class' => 'form-control',
            )
        ));*/

        $builder->add('invite', 'submit', array(
            'label' => false,
            'attr' => array(
                'class' => 'btn btn-primary',
            )
        ));
    }

    public function getName()
    {
        return 'user_add_form';
    }
}