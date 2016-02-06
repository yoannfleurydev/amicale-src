<?php

namespace AGIL\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('email', 'email', array(
            'label' => false,
            'constraints' => array(
                new NotBlank(),
            ),
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Email',
            )
        ));

        $builder->add('firstName', 'text', array(
            'label' => false,
            'constraints' => array(
                new NotBlank(),
            ),
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Prénom',
            )
        ));

        $builder->add('name', 'text', array(
            'label' => false,
            'constraints' => array(
                new NotBlank(),
            ),
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Nom',
            )
        ));

        $builder->add('role', 'choice', array(
            'label' => false,
            'choices' => array(
                'ROLE_USER' => 'Membre',
                'ROLE_MODERATOR' => 'Modérateur',
                'ROLE_ADMIN' => 'Administrateur'
            ),
            'multiple' => false,
            'expanded' => true,
            'attr' => array(
                'class' => 'form-control',
            )
        ));

        $builder->add('Inviter', 'submit', array(
            'label' => false,
            'attr' => array(
                'class' => 'form-control',
            )
        ));
    }

    public function getName()
    {
        return 'user_add_form';
    }
}