<?php

namespace AppBundle\Form\Constraints;

use AppBundle\Form\Validators\EmailUniqueValidator;
use Symfony\Component\Validator\Constraint;

class EmailUnique extends Constraint
{
    /** @var string */
    public $message = 'email_already_in_use';

    public function validatedBy()
    {
        return EmailUniqueValidator::class;
    }
}