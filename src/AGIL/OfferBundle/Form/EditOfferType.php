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
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\Date;

class EditOfferType extends AbstractType
{
    private $yearExpire;

    public function __construct($yearExpire) {
        $this->yearExpire = $yearExpire;
    }
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
                'placeholder' => 'Autheur',
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

        $builder->add('offerExpirationDate', DateType::class, array(
            'label' => false,
            'required' => true,
            'years' => range($this->yearExpire, $this->yearExpire+1),
            'input'  => 'datetime',
            'widget' => 'choice',
            'attr' => array(
                'class' => 'form-control',
            )
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
        return 'offer_add';
    }
}