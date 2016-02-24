<?php

namespace AGIL\ForumBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SubjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('forumSubjectTitle', TextType::class, array(
            'label' => false,
            'constraints' => array(
                new NotBlank(),new Length(array('min' => 2,'max' => 70))
            ),
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Titre',
            )
        ));

        $builder->add('forumSubjectDescription', TextareaType::class, array(
            'label' => false,
            'constraints' => array(
                new Length(array('max' => 120))
            ),
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Description',
            )
        ));

        $builder->add('tags', TextType::class, array(
            'label' => false,
            'required' => false,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Tags associés',
            )
        ));
    }

    public function getBlockPrefix()
    {
        return 'forum_add_subject';
    }
}