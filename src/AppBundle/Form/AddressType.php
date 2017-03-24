<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('email')
            ->remove('current_password')
            ->add('Pay', SubmitType::class)
        ;
    }

    public function getParent()
    {
        return 'AppBundle\Form\ProfileType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_address';
    }
}