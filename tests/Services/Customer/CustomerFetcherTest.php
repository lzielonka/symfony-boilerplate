<?php

namespace Services\Customer;

use ModelBundle\Propel\Model\Customer;
use PHPUnit_Framework_MockObject_MockObject;
use Propel\Runtime\Collection\ObjectCollection;
use Repositories\Interfaces\CustomerRepositoryInterface;
use Tests\PrivateAccessTestCase;
use Tests\Stubs\Customer\CustomerStub;
use Tests\Stubs\ObjectCollectionStub;

class CustomerFetcherTest extends PrivateAccessTestCase
{
    /** @var CustomerFetcher */
    private $customerFetcher;
    /** @var CustomerRepositoryInterface|PHPUnit_Framework_MockObject_MockObject */
    private $customerRepository;

    public function setUp()
    {
        $this->customerRepository = $this->createMock(CustomerRepositoryInterface::class);
        $this->customerFetcher = new CustomerFetcher($this->customerRepository);
    }

    public function testFetchAllCustomers()
    {
        $oc = new ObjectCollectionStub;
        $oc->append(new CustomerStub);

        $this->customerRepository
            ->expects($this->once())
            ->method('fetchAll')
            ->willReturn($oc);

        /** @var ObjectCollection $result */
        $result = $this->customerFetcher->fetchAllCustomers();

        $this->assertInstanceOf(ObjectCollection::class, $result);
        $this->assertEquals(1, $result->count());
        $this->assertInstanceOf(Customer::class, $result->getFirst());
    }
}