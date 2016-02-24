<?php

namespace AGIL\ForumBundle\Form;

use AGIL\ForumBundle\Form\SubjectType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FirstAnswerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('forumAnswerText', TextareaType::class, array(
            'label' => false,
            'attr' => array(
                'class' => 'form-control tinymce',
                'data-theme' => 'advanced',
            )
        ));

        $builder->add('subject', new SubjectType(), array ('data_class'   =>  'AGIL\ForumBundle\Entity\AgilForumSubject',));

        $builder->add('Ajouter', SubmitType::class, array(
            'label' => false,
            'attr' => array(
                'class' => 'btn btn-primary',
            )
        ));
    }

    public function getBlockPrefix()
    {
        return 'forum_add_first_answer';
    }
}