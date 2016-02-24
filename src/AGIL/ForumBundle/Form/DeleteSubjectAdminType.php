<?php

namespace AGIL\ForumBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class DeleteSubjectAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('choiceReason', 'choice', array(
            'choices'  => array(
                'Abus de langage' => 'Abus de langage',
                'Contenu inapproprié' => 'Contenu inapproprié',
                'Sujet déjà existant' => 'Sujet déjà existant',
                'Autre' => 'Autre',
            ),
            'label' => 'Raison : ',
            'attr' => array(
                'class' => '',
            )
        ));

        $builder->add('reasonOption', 'textarea', array(
            'label' => false,
            'required' => false,
            'attr' => array(
                'class' => 'form-control',
            )
        ));

        $builder->add('Supprimer', 'submit', array(
            'label' => false,
            'attr' => array(
                'class' => 'btn btn-default',
            )
        ));
    }

    public function getName()
    {
        return 'forum_delete_subject';
    }
}