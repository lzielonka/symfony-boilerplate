<?php

namespace AppBundle\Form;

use AppBundle\Database\Propel\Model\Account;
use AppBundle\Form\Constraints\EmailFormat;
use AppBundle\Form\Constraints\EmailUnique;
use AppBundle\Form\Constraints\PasswordStrength;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'type' => 'email'
                ],
                'constraints' => [new EmailUnique, new EmailFormat],
            ])
            ->add('passwd', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'password_fields_must_match',
                'constraints' => [new PasswordStrength],
                'first_options' => [
                    'attr' => ['class' => 'form-control', 'type' => 'password'],
                ],
                'second_options' => [
                    'attr' => ['class' => 'form-control', 'type' => 'password'],
                ],
                'required' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Account::class
        ]);
    }
}
