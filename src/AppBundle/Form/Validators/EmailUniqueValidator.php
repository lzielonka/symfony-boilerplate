<?php

namespace AppBundle\Form\Validators;

use AppBundle\Services\Account\AccountFetcher;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class EmailUniqueValidator extends ConstraintValidator
{
    /** @var AccountFetcher */
    private $accountFetcher;

    public function __construct(AccountFetcher $accountFetcher)
    {
        $this->accountFetcher = $accountFetcher;
    }
    public function validate($value, Constraint $constraint)
    {
        $account = $this->accountFetcher->fetchOneByEmail($value);
        if (null !== $account) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}