<?php

namespace AppBundle\Form\Validators;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class EmailFormatValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!preg_match("/(^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$)/", $value, $matches)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}