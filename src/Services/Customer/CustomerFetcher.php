<?php

namespace Services\Customer;

use Repositories\Interfaces\CustomerRepositoryInterface;

class CustomerFetcher
{
    /**@var CustomerRepositoryInterface */
    private $customerRepository;

    /**
     * CustomerFetcher constructor.
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function fetchAllCustomers()
    {
        return $this->customerRepository->fetchAll();
    }

}