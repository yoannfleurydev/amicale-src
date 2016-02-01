<?php

namespace AGIL\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ResettingFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

    }

    public function getParent() {
        return 'FOS\UserBundle\Form\Type\ResettingFormType';
    }

    public function getBlockPrefix()
    {
        return 'agil_user_resetting';
    }

    public function getName() {
        return $this->getBlockPrefix();
    }

}