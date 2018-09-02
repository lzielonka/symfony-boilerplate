<?php

namespace Services\Email\EmailManager;

use AppBundle\Services\Email\DTO\EmailDTO;
use AppBundle\Services\Email\EmailManager\EmailManager;
use AppBundle\Services\Email\Interfaces\EmailClientInterface;
use Prophecy\Argument;

class EmailManagerTest extends \PHPUnit_Framework_TestCase
{
    /** @var EmailClientInterface */
    private $emailClient;
    /** @var EmailManager */
    private $emailManager;

    public function setUp()
    {
        $this->emailClient = $this->prophesize(EmailClientInterface::class);
        $this->emailManager = new EmailManager($this->emailClient->reveal());
    }

    public function testSendProductCreationEmail(): void
    {
        $this->emailClient->sendEmail(Argument::type(EmailDTO::class))->shouldBeCalledTimes(1);
        $this->emailManager->sendProductCreationEmail();
    }
}