<?php

namespace Services\Email\Clients;

use AppBundle\Services\Email\Clients\SwiftMailerClient;
use AppBundle\Services\Email\DTO\EmailDTO;
use Prophecy\Argument;

class SwiftMailerClientTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Swift_Mailer */
    private $mailer;
    /** @var SwiftMailerClient */
    private $swiftMailerClient;

    public function setUp()
    {
        $this->mailer = $this->prophesize(\Swift_Mailer::class);
        $this->swiftMailerClient = new SwiftMailerClient($this->mailer->reveal());
    }

    public function testResolveProductCurrency(): void
    {
        $this->mailer->send(Argument::type(\Swift_Message::class))->shouldBeCalledTimes(1);
        $this->swiftMailerClient->sendEmail(new EmailDTO);
    }
}