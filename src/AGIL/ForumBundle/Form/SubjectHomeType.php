<?php

namespace AGIL\ForumBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SubjectHomeType extends AbstractType
{


    /**
     * Formulaire pour ajouter un sujet depuis la page d'accueil du forum
     * (contient une liste des catégories)
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('category', EntityType::class, array(
            'class' => 'AGILForumBundle:AgilForumCategory',
            'property' => 'forumCategoryName',
            'label' => false,
            'attr' => array(
                'class' => 'form-control'
            ),
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('c')
                    ->orderBy('c.forumCategoryName', 'ASC');
            },
        ));


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
            'required' => false,
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
                'autocomplete'=> 'off',
            )
        ));
    }

    public function getBlockPrefix()
    {
        return 'forum_add_subject_home';
    }
}