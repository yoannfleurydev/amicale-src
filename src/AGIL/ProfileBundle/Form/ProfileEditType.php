<?php

namespace AGIL\ProfileBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\VarDumper\VarDumper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ProfileEditType extends AbstractType
{
    private $data;

    public function __construct(array $data) {
        $this->data = $data;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('email', EmailType::class, array(
            'label' => false,
            'required' => true,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Email',
            )
        ));

        $builder->add('username', TextType::class, array(
            'label' => false,
            'required' => true,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Pseudo',
            )
        ));

        $builder->add('userProfilePictureUrl', FileType::class, array(
            'label' => false,
            'required' => false,
            //            'attr' => array(
            //                'class' => 'form-control',
            //                'placeholder' => 'Pseudo',
            //            )
        ));


        $builder->add('userCVUrl', FileType::class, array(
            'label' => false,
            'required' => false,
//            'attr' => array(
//                'class' => 'form-control'
//            )
        ));

        $builder->add('userCVUrlVisibility', CheckboxType::class, array(
            'label' => false,
            'required' => false,
//            'attr' => array(
//                'class' => 'form-control',
//                'placeholder' => 'mot de passe'
//            )
        ));

        $builder->add('password', PasswordType::class, array(
            'label' => false,
            'required' => false,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Mot de passe'
            )
        ));


        $builder->add('passwordConfirm', PasswordType::class, array(
            'label' => false,
            'required' => false,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Confirmer mot de passe'
            )
        ));

        // Boucle pour les compétences.
        // TODO Voir si avec un in_array on améliore les performances.
        foreach($this->data['profileSkillsCategories'] as $profileSkillsCategory) {
            foreach($this->data['tags'] as $tag) {
                if ($tag->getSkillCategory() == $profileSkillsCategory) {
                    foreach($this->data['skills'] as $skill) {
                        if ($skill->getTag() == $tag) {
                            $builder->add('tag' . $tag->getTagId(), IntegerType::class, array(
                                'label' => false,
                                'attr' => array(
                                    'class' => 'form-control',
                                    'value' => $skill->getSkillLevel(),
                                    'min' => 0,
                                    'max' => 10
                                )
                            ));
                        }
                    }
                }
            }
        }

        $builder->add('Modifier', SubmitType::class, array(
            'label' => false,
            'attr' => array(
                'class' => 'form-control'
            )
        ));
    }

    public function getBlockPrefix()
    {
        return 'profil_edit_form';
    }
}