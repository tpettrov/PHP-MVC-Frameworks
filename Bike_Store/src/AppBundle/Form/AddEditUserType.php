<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use AppBundle\Repository\RoleRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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
            ->add('lName', TextType::class, array('label' => 'Last Name'))
            ->add('email', EmailType::class, array('label' => 'E-mail'))
            ->add('rawPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options' => array('label' => 'New Password'),
                'second_options' => array('label' => 'Repeat New Password'),
            ))
            ->add('cash', MoneyType::class, array('label' => 'Cash'))
            ->add('roles_collection', EntityType::class, [
                'class' => 'AppBundle:Role',
                'choice_label' => 'name',
                'query_builder' => function (RoleRepository $repo) {
                    return $repo->createQueryBuilder('f')
                        ->where('f.id > :id')
                        ->setParameter('id', 0);
                },
                'label' => 'Choose a role:',
                'expanded' => true,
                'multiple' => true,
            ])->add('isNotBanned', CheckboxType::class, array('label' => 'Not banned'));


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
