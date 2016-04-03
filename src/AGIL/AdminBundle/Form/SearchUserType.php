<?php

namespace AGIL\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SearchUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('keyword', TextType::class, array(
            'label' => false,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'nom utilisateur ou prénom ou nom',
            )
        ));
    }

    public function getBlockPrefix()
    {
        return 'search_user_form';
    }
}