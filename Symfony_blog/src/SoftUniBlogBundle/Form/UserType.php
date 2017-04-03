<?php

namespace SoftUniBlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('email', TextType::class)
            ->add('password', TextType::class)
            ->add('fullName', TextType::class);

    }

//    public function configureOptions(OptionsResolver $resolver)
//    {
//
//    }
//
//    public function getBlockPrefix()
//    {
//        return 'soft_uni_blog_bundle_user_type';
//    }
}
