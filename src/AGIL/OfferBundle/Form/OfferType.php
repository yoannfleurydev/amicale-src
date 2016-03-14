<?php

namespace AGIL\OfferBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class OfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('offerTitle', TextType::class, array(
            'label' => false,
            'required' => true,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Titre',
            )
        ));

        $builder->add('offerText', TextareaType::class, array(
            'label' => false,
            'required' => false,
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
            )
        ));

        $builder->add('offerType', ChoiceType::class, array(
            'label' => false,
            'required' => true,
            'choices' => array(
                'Stage' => 'Stage',
                'Emplois' => 'Emplois'
            ),
            'multiple' => false,
            'expanded' => true,
            'attr' => array(
                'class' => 'form-control',
            )
        ));

        $builder->add('offerPdfUrl', FileType::class, array(
            'label' => false,
            'required' => false,
            'attr' => array(
                'class' => 'form-control',
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
        return 'offer_add';
    }
}