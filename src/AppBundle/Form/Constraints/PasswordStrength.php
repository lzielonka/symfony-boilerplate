<?php

namespace AppBundle\Form\Constraints;

use AppBundle\Form\Validators\PasswordStrengthValidator;
use Symfony\Component\Validator\Constraint;

class PasswordStrength extends Constraint
{
    /** @var string */
    public $message = 'password_too_weak_8letters_2upper_3lower_1special_2numbers';

    public function validatedBy()
    {
        return PasswordStrengthValidator::class;
    }
}