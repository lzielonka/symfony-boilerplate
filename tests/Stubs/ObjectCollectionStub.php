<?php

namespace Tests\Stubs;

use ModelBundle\Propel\Collection\ObjectCollection;

class ObjectCollectionStub extends ObjectCollection
{
    public function save($con = null) {}
    public function delete($con = null) {}
}