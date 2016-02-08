<?php

namespace AGIL\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;

class UsersCSVType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('file', 'file', array(
            'label' => false,
            'mapped'=>false,
            'required' => true,
            'constraints'   => [
                new File([
                    'mimeTypes' => [
                        'text/csv',
                        'text/plain',
                        'application/csv',
                        'text/comma-separated-values',
                        'application/excel',
                        'application/vnd.ms-excel',
                        'application/vnd.msexcel',
                        'text/anytext',
                        'application/octet-stream',
                        'application/txt',
                    ]
                ])
            ],
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