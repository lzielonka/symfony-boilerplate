<?php

namespace AppBundle\Repositories\Interfaces;

interface AccountRepositoryInterface
{
    public function fetchAll();
    public function fetchOneByEmail(string $email);
}