<?php

namespace AGIL\ForumBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EditAnswerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('forumAnswerText', 'textarea', array(
            'label' => false,
            'attr' => array(
                'class' => 'tinymce form-control',
                'data-theme' => 'advanced',
                'name' => 'forumAnswerText'
            )
        ));

        $builder->add('Modifier', 'submit', array(
            'label' => false,
            'attr' => array(
                'class' => 'btn btn-default',
            )
        ));
    }

    public function getName()
    {
        return 'forum_edit_answer';
    }
}