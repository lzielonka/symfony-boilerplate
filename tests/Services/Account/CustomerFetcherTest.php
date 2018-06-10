<?php

namespace Services\Account;

use AppBundle\Database\Propel\Model\Account;
use AppBundle\Repositories\Interfaces\AccountRepositoryInterface;
use AppBundle\Services\Account\AccountFetcher;
use PHPUnit_Framework_MockObject_MockObject;
use Propel\Runtime\Collection\ObjectCollection;
use Tests\PrivateAccessTestCase;
use Tests\Stubs\Account\AccountStub;
use Tests\Stubs\ObjectCollectionStub;

class CustomerFetcherTest extends PrivateAccessTestCase
{
    /** @var AccountFetcher */
    private $accountFetcher;
    /** @var AccountRepositoryInterface|PHPUnit_Framework_MockObject_MockObject */
    private $accountRepository;

    public function setUp()
    {
        $this->accountRepository = $this->createMock(AccountRepositoryInterface::class);
        $this->accountFetcher = new AccountFetcher($this->accountRepository);
    }

    public function testFetchAllAccounts()
    {
        $oc = new ObjectCollectionStub;
        $oc->append(new AccountStub);

        $this->accountRepository
            ->expects($this->once())
            ->method('fetchAll')
            ->willReturn($oc);

        /** @var ObjectCollection $result */
        $result = $this->accountFetcher->fetchAllAccounts();

        $this->assertInstanceOf(ObjectCollection::class, $result);
        $this->assertEquals(1, $result->count());
        $this->assertInstanceOf(Account::class, $result->getFirst());
    }

    public function testFetchOneByEmail()
    {
        $this->accountRepository
            ->expects($this->once())
            ->method('fetchOneByEmail')
            ->willReturn(new AccountStub);

        $result = $this->accountFetcher->fetchOneByEmail('email');

        $this->assertInstanceOf(Account::class, $result);
    }
}