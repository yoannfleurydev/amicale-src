<?php

namespace AGIL\UserBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        /*$builder
            ->add('userLastName')
            ->add('userFirstName')
            ->add('userSignupDate', 'datetime')
            ->add('userBirthdayDate', 'datetime');*/
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';

        // Or for Symfony < 2.8
        // return 'fos_user_registration';
    }

    public function getBlockPrefix()
    {
        return 'agil_user_registration';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }
}