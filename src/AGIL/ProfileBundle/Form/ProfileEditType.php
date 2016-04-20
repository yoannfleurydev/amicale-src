<?php

namespace AGIL\ProfileBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;


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
                'placeholder' => 'Adresse e-mail',
            )
        ));

        $builder->add('username', TextType::class, array(
            'label' => false,
            'required' => true,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Identifiant',
            )
        ));

        $builder->add('userProfilePictureUrl', FileType::class, array(
            'label' => false,
            'required' => false,
        ));

        $builder->add('userDeleteProfilePicture', CheckboxType::class, array(
            'label' => 'Supprimer ma photo de profil : ',
            'required' => false,
        ));


        $builder->add('userCVUrl', FileType::class, array(
            'label' => false,
            'required' => false,
        ));

        $builder->add('userCVUrlVisibility', CheckboxType::class, array(
            'label' => false,
            'required' => false,
        ));

        $builder->add('oldPassword', PasswordType::class, array(
            'label' => false,
            'required' => false,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Ancien mot de passe'
            )
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

        $builder->add('modify', SubmitType::class, array(
            'label' => "Modifier",
            'attr' => array(
                'class' => 'form-control',
                'value'
            )
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'profile_edit_form';
    }
}