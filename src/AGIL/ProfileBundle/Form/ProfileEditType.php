<?php

namespace AGIL\ProfileBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
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

        $builder->add('userProfilePictureUrl', 'file', array(
            'label' => false,
            'required' => false,
            'constraints' => [
                new File([
                    'maxSize' => '20M',
                    'mimeTypes' => [
                        "image/jpeg",
                        "image/png",
                        "image/bmp"
                    ],
                ])
            ]
            //            'attr' => array(
            //                'class' => 'form-control',
            //                'placeholder' => 'Pseudo',
            //            )
        ));


        $builder->add('userCVUrl', 'file', array(
            'label' => false,
            'required' => false,
            'constraints' => [
                new File([
                    'maxSize' => '20M',
                    'mimeTypes' => [
                        "application/pdf",
                    ],
                ])
            ]
//            'attr' => array(
//                'class' => 'form-control'
//            )
        ));

        $builder->add('userCVUrlVisibility', 'checkbox', array(
            'label' => false,
            'required' => false,
//            'attr' => array(
//                'class' => 'form-control',
//                'placeholder' => 'mot de passe'
//            )
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