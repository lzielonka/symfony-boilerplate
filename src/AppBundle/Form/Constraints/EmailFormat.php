<?php

namespace AppBundle\Form\Constraints;

use AppBundle\Form\Validators\EmailFormatValidator;
use Symfony\Component\Validator\Constraint;

class EmailFormat extends Constraint
{
    /** @var string */
    public $message = 'incorrect_email_address';

    public function validatedBy()
    {
        return EmailFormatValidator::class;
    }
}