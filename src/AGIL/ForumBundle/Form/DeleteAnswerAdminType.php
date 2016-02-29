<?php

namespace AGIL\ForumBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DeleteAnswerAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('choiceReason',  ChoiceType::class, array(
            'choices'  => array(
                'Abus de langage' => 'Abus de langage',
                'Contenu inapproprié' => 'Contenu inapproprié',
                'Autre' => 'Autre',
            ),
            'label' => 'Raison : ',
            'attr' => array(
                'class' => '',
            )
        ));

        $builder->add('reasonOption', TextareaType::class, array(
            'label' => false,
            'required' => false,
            'attr' => array(
                'class' => 'form-control',
            )
        ));

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