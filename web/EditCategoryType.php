<?php

namespace AGIL\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;




class EditCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('forumCategoryName', 'text', array(
            'label' => false,
            'constraints' => array(
                new NotBlank(),
            ),
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Nom',
            )
        ));

        $builder->add('forumCategoryText', 'text', array(
            'label' => false,
            'constraints' => array(
                new NotBlank(),
            ),
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Description',
            )
        ));

        $builder->add('forumCategoryIcon', HiddenType::class, array(
            'data' => 'glyphicon glyphicon-tag',
        ));


        $builder->add('Modifier', 'submit', array(
            'label' => false,
            'attr' => array(
                'class' => 'btn btn-primary',
            )
        ));
    }

    public function getName()
    {
        return 'forum_edit_category';
    }
}