<?php

namespace AppBundle\Form;

use AppBundle\Database\Propel\Model\Account;
use AppBundle\Form\Constraints\EmailUnique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => ['class' => 'form-control', 'type' => 'email'],
                'label_attr' => ['class' =>  'abc'],
                'constraints' => new EmailUnique
            ])
            ->add('passwd', PasswordType::class, [
                'attr' => ['class' => 'form-control', 'type' => 'password'],
                'required' => false
            ])
            ->add('passwdRepeat', PasswordType::class, [
                'attr' => ['class' => 'form-control', 'type' => 'password'],
                'mapped' => false,
                'required' => false,
                'constraints' => new NotBlank()
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Account::class
        ]);
    }
}
