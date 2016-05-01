<?php

namespace AGIL\DefaultBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class IdeaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('idea', TextareaType::class, array(
            'label' => false,
            'constraints' => array(
                new NotBlank(),new Length(array('min' => 10,'max' => 12000))
            ),
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Entrer votre idée ici...',
            )
        ));

        $builder->add('Valider', SubmitType::class, array(
            'label' => false,
            'attr' => array(
                'class' => 'btn btn-primary',
            )
        ));
    }

    public function getBlockPrefix()
    {
        return 'idea_box';
    }
}