<?php

namespace AGIL\SearchBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Validator\Constraints\Length;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('tags', TextType::class, array(
            'label' => false,
            'constraints' => array(
                new Length(array('min' => 2,'max' => 50))
            ),
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Recherche'
            )
        ));

        $builder->add('filter', HiddenType::class, array(
            'data' => 'all',
        ));

        $builder->add('method', HiddenType::class, array(
            'data' => 'and',
        ));

    }

    public function getBlockPrefix()
    {
        return '';
    }
}