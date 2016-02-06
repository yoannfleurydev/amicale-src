<?php

namespace AGIL\ProfileBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfileEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('email', 'email', array(
            'label' => false,
            'required' => false,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Email',
            )

        ));

        $builder->add('username', 'text', array(
            'label' => false,
            'required' => false,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Pseudo',
            )
        ));

        $builder->add('CV', 'button', array(
            'label' => false,
            'attr' => array(
                'class' => 'form-control')
        ));

        $builder->add('password', 'password', array(
            'label' => false,
            'required' => false,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'mot de passe'
            )
        ));

        $builder->add('passwordConfirm', 'password', array(
            'label' => false,
            'required' => false,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'confirmer mot de passe'
            )
        ));

        $builder->add('Modifier', 'submit', array(
            'label' => false,
            'attr' => array(
                'class' => 'form-control',
            )
        ));

    }

    public function getName()
    {
        return 'profil_edit_form';
    }
}