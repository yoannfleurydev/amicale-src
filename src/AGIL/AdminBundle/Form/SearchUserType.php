<?php

namespace AGIL\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SearchUserType extends AbstractType
{
    private $keyword;

    public function __construct($keyword) {
        $this->keyword = $keyword;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('keyword', TextType::class, array(
            'label' => false,
            'data' => $this->keyword,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'nom d\'utilisateur ou prénom ou nom',
            )
        ));
    }
    public function getDefaultOptions()
    {
        return array(
            'id'         => 'search_form'
        );
    }

    public function getBlockPrefix()
    {
        return 'search_user_form';
    }
}