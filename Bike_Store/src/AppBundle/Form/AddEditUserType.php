<?php

namespace AppBundle\Form;

use AppBundle\Entity\Role;
use AppBundle\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddEditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('fName', TextType::class, array('label' => 'First Name'))
            ->add('lName', TextType::class , array('label' => 'Last Name'))
            ->add('email', EmailType::class, array('label' => 'E-mail'))
            ->add('rawPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'New Password'),
                'second_options' => array('label' => 'Repeat New Password'),
            ))
            ->add('cash', MoneyType::class, array('label' => 'Cash'))
            ->add('roles');


    }

    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults(array(

            'data_class' => User::class,
        ));

    }

    public function getBlockPrefix()
    {
        return 'app_bundle_add_edit_user_type';
    }
}
