<?php

namespace AGIL\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('email', EmailType::class, array(
            'label' => false,
            'constraints' => array(
                new NotBlank(),
            ),
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Email',
            )
        ));

        $builder->add('firstName', TextType::class, array(
            'label' => false,
            'constraints' => array(
                new NotBlank(),
            ),
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Prénom',
            )
        ));

        $builder->add('name', TextType::class, array(
            'label' => false,
            'constraints' => array(
                new NotBlank(),
            ),
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Nom',
            )
        ));

        $builder->add('role', ChoiceType::class, array(
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

        $builder->add('Inviter', SubmitType::class, array(
            'label' => false,
            'attr' => array(
                'class' => 'btn btn-primary',
            )
        ));
    }

    public function getBlockPrefix()
    {
        return 'user_add_form';
    }
}