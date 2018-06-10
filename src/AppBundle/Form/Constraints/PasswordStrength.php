<?php

namespace AppBundle\Form\Constraints;

use AppBundle\Form\Validators\PasswordStrengthValidator;
use Symfony\Component\Validator\Constraint;

class PasswordStrength extends Constraint
{
    /** @var string */
    public $message = 'password_too_weak_8length_1upper_1lower_1special_1numbers';

    public function validatedBy()
    {
        return PasswordStrengthValidator::class;
    }
}