<?php

namespace AGIL\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityRepository;

class EditCategoryType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('forumCategoryName', TextType::class, array(
            'label' => false,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Nom',
            )
        ));

        $builder->add('forumCategoryText', TextType::class, array(
            'label' => false,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Description',
            )
        ));

        $builder->add('forumCategoryIcon', HiddenType::class, array(
            'data' => 'glyphicon-stats',
        ));


        $builder->add('Modifier', SubmitType::class, array(
            'label' => false,
            'attr' => array(
                'class' => 'btn btn-primary',
            )
        ));
    }

    public function getBlockPrefix()
    {
        return 'forum_edit_category';
    }
}