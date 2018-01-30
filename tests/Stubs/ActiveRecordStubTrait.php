<?php

namespace Tests\Stubs;

use Propel\Runtime\Connection\ConnectionInterface;

trait ActiveRecordStubTrait
{
    public function reload($deep = false, ConnectionInterface $con = null) {}
    public function delete(ConnectionInterface $con = null) {}
    public function save(ConnectionInterface $con = null) {}
    protected function doSave(ConnectionInterface $con) {}
    protected function doInsert(ConnectionInterface $con) {}
    protected function doUpdate(ConnectionInterface $con) {}
    public function preSave(ConnectionInterface $con = null) {}
    public function postSave(ConnectionInterface $con = null) {}
    public function preInsert(ConnectionInterface $con = null) {}
    public function postInsert(ConnectionInterface $con = null) {}
    public function preUpdate(ConnectionInterface $con = null) {}
    public function postUpdate(ConnectionInterface $con = null) {}
    public function preDelete(ConnectionInterface $con = null) {}
    public function postDelete(ConnectionInterface $con = null) {}
}