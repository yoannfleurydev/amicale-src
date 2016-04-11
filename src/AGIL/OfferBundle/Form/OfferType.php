<?php

namespace AGIL\OfferBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

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

        $builder->add('offerAuthor', TextType::class, array(
            'label' => false,
            'required' => false,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Auteur',
            )
        ));

        $builder->add('offerEmail', EmailType::class, array(
            'label' => false,
            'required' => true,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Email',
            )
        ));

        $builder->add('offerText', TextareaType::class, array(
            'label' => false,
            'required' => false,
            'attr' => array(
                'class' => 'tinymce form-control',
                'placeholder' => 'Description',
            )
        ));

        $builder->add('tags', TextType::class, array(
            'label' => false,
            'mapped' => false,
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
                'stage' => 'Stage',
                'emploi' => 'Emploi'
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
            'mapped' => false,
            'attr' => array(
                'class' => 'form-control',
            )
        ));

        $builder->add('expireAt', ChoiceType::class, array(
            'label' => false,
            'required' => true,
            'mapped' => false,
            'choices' => array(
                'P1M' => '1 mois',
                'P2M' => '2 mois',
                'P3M' => '3 mois',
                'P4M' => '4 mois',
                'P5M' => '5 mois',
                'P6M' => '6 mois',
                'P7M' => '7 mois',
                'P8M' => '8 mois',
                'P9M' => '9 mois',
                'P10M' => '10 mois',
                'P11M' => '11 mois',
                'P12M' => '12 mois',
            ),
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