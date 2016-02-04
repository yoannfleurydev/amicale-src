<?php

namespace AGIL\ForumBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SubjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('forumSubjectTitle', 'text', array(
            'label' => false,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Titre',
            )
        ));

        $builder->add('forumSubjectDescription', 'textarea', array(
            'label' => false,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Description',
            )
        ));

        /*$builder->add('tags', 'text', array(
            'label' => false,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Tags associés',
            )
        ));*/

        $builder->add('Ajouter', 'submit', array(
            'label' => false,
            'attr' => array(
                'class' => 'form-control',
            )
        ));
    }

    public function getName()
    {
        return 'forum_add_subject';
    }
}