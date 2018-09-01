<?php

namespace AppBundle\Services\Email\DTO;

class EmailDTO
{
    public $sender;
    public $recipient;
    public $subject;
    public $body;
    public $contentType = 'text/html';
    public $charset = 'UTF-8';
}