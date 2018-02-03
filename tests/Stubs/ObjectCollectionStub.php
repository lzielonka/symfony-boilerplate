<?php

namespace Tests\Stubs;

use AppBundle\Database\Propel\Collection\ObjectCollection;

class ObjectCollectionStub extends ObjectCollection
{
    public function save($con = null) {}
    public function delete($con = null) {}
}