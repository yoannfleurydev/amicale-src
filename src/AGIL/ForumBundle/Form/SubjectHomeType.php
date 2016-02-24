<?php

namespace AGIL\ForumBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


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

        $builder->add('category', 'entity', array(
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


        $builder->add('forumSubjectTitle', 'text', array(
            'label' => false,
            'constraints' => array(
                new NotBlank(),new Length(array('min' => 2,'max' => 70))
            ),
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Titre',
            )
        ));

        $builder->add('forumSubjectDescription', 'textarea', array(
            'label' => false,
            'constraints' => array(
                new Length(array('max' => 120))
            ),
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Description',
            )
        ));

        $builder->add('tags', 'text', array(
            'label' => false,
            'required' => false,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Tags associés',
            )
        ));
    }

    public function getName()
    {
        return 'forum_add_subject_home';
    }
}