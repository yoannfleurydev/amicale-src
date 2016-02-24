<?php

namespace AGIL\ForumBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DeleteAnswerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Supprimer', SubmitType::class, array(
            'label' => false,
            'attr' => array(
                'class' => 'btn btn-default',
            )
        ));
    }

    public function getBlockPrefix()
    {
        return 'forum_delete_answer';
    }
}