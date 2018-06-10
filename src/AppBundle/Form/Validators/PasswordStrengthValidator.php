<?php

namespace AppBundle\Form\Validators;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PasswordStrengthValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        // @TODO: split to have individual messages
        if (!preg_match("/^(?=.*[A-Z].*[A-Z])(?=.*[!@#$&*])(?=.*[0-9].*[0-9])(?=.*[a-z].*[a-z].*[a-z]).{8}$/", $value, $matches)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}