<?php

namespace AGIL\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UsersCSVType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('attachment', 'file', array(
            'label' => false,
            'required' => false,
            'attr' => array(
                'class' => 'form-control',
            )
        ));

        $builder->add('Inviter', 'submit', array(
            'label' => false,
            'attr' => array(
                'class' => 'form-control',
            )
        ));
    }

    public function getName()
    {
        return 'user_add_csv_form';
    }
}