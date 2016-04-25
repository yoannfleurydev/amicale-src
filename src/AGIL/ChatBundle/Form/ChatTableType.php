<?php

namespace AGIL\ChatBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ChatTableType extends AbstractType
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


        $builder->add('chatTableName', TextType::class, array(
            'label' => false,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Nom',
                'autocomplete' => 'off',
                'value'=>''
            )
        ));

        $builder->add('chatTablePassword', TextType::class, array(
            'label' => false,
            'required' => false,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Mot de passe (facultatif)',
                'autocomplete' => 'off',
                'value'=>''
                )
        ));

        $builder->add('Ajouter', SubmitType::class, array(
            'label' => false,
            'attr' => array(
                'class' => 'btn btn-primary',

                )
        ));

    }

    public function getBlockPrefix()
    {
        return 'chat_add_table';
    }
}