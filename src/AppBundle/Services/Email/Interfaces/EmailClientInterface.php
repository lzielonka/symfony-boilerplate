<?php

namespace AppBundle\Services\Email\Interfaces;

use AppBundle\Services\Email\DTO\EmailDTO;

interface EmailClientInterface
{
    public function sendEmail(EmailDTO $emailDTO);
}