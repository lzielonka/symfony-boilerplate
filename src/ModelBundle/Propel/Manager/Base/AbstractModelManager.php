<?php

namespace ModelBundle\Propel\Manager\Base;

use PDO;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Propel;
use Propel\Runtime\ServiceContainer\ServiceContainerInterface;

abstract class AbstractModelManager
{
    /** @var  ConnectionInterface */
    protected $connection;

    /**
     * @param ModelCriteria $criteria
     * @param ConnectionInterface $con
     * @return array|mixed|ActiveRecordInterface[]|ObjectCollection
     */
    public function find(ModelCriteria $criteria, ConnectionInterface $con = null)
    {
        return $criteria->find($this->connection ?? $con);
    }

    /**
     * @param ModelCriteria $criteria
     * @param ConnectionInterface $con
     * @return ActiveRecordInterface
     */
    public function findOne(ModelCriteria $criteria, ConnectionInterface $con = null)
    {
        return $criteria->findOne($this->connection ?? $con);
    }

    /**
     * @param ModelCriteria $criteria
     * @param int $page
     * @param int $maxPerPage
     * @param ConnectionInterface|null $con
     * @return \Propel\Runtime\Util\PropelModelPager
     */
    public function paginate(ModelCriteria $criteria, $page = 1, $maxPerPage = 10, ConnectionInterface $con = null)
    {
        return $criteria->paginate($page, $maxPerPage, $this->connection ?? $con);
    }


    /**
     * @param ModelCriteria $criteria
     * @param ConnectionInterface|null $con
     * @return ActiveRecordInterface
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function findOneOrCreate(ModelCriteria $criteria, ConnectionInterface $con = null)
    {
        return $criteria->findOneOrCreate($this->connection ?? $con);
    }

    /**
     * @param ModelCriteria $criteria
     * @param ConnectionInterface $con
     * @return int
     */
    public function count(ModelCriteria $criteria, ConnectionInterface $con = null)
    {
        return $criteria->count($this->connection ?? $con);
    }


    /**
     * @param ActiveRecordInterface $activeRecord
     * @throws PropelException
     * @return int
     */
    public function save(ActiveRecordInterface $activeRecord)
    {
        return $activeRecord->save();
    }


    /**
     * @param ModelCriteria $criteria
     * @param array $array
     * @param ConnectionInterface|null $con
     * @return int
     * @throws PropelException
     * @throws \Exception
     */
    public function update(ModelCriteria $criteria, array $array, ConnectionInterface $con = null)
    {
        return $criteria->update($array, $this->connection ?? $con);
    }


    /**
     * @param ModelCriteria $criteria
     * @param ConnectionInterface|null $con
     * @return int
     * @throws PropelException
     */
    public function deleteFromCriteria(ModelCriteria $criteria, ConnectionInterface $con = null)
    {
        return $criteria->delete($this->connection ?? $con);
    }

    /**
     * @param ObjectCollection $objectCollection
     * @param ConnectionInterface $con
     */
    public function delete(ObjectCollection $objectCollection, ConnectionInterface $con = null)
    {
        if (!$objectCollection->isEmpty()) {
            $objectCollection->delete($this->connection ?? $con);
        }
    }


    /**
     * @param ActiveRecordInterface $activeRecord
     * @throws PropelException
     */
    public function deleteActiveRecord(ActiveRecordInterface $activeRecord)
    {
        $activeRecord->delete();
    }

    /**
     * Get a connection for a given datasource.
     *
     * If the connection has not been opened, open it using the related
     * connectionSettings. If the connection has already been opened, return it.
     *
     * @param string $name The datasource name
     * @param string $mode The connection mode (this applies to replication systems).
     *
     * @return \Propel\Runtime\Connection\ConnectionInterface A database connection
     */
    public function getConnection($name = null, $mode = ServiceContainerInterface::CONNECTION_WRITE)
    {
        return Propel::getConnection($name, $mode);
    }

    /**
     * Turns off autocommit mode.
     *
     * While autocommit mode is turned off, changes made to the database via
     * the Connection object instance are not committed until you end the
     * transaction by calling Connection::commit().
     * Calling Connection::rollBack() will roll back all changes to the database
     * and return the connection to autocommit mode.
     *
     * @param ConnectionInterface $connection
     * @return bool TRUE on success or FALSE on failure.
     */
    public function beginTransaction(ConnectionInterface $connection)
    {
        return $connection->beginTransaction();
    }

    /**
     * Commits a transaction.
     *
     * commit() returns the database connection to autocommit mode until the
     * next call to connection::beginTransaction() starts a new transaction.
     *
     * @param ConnectionInterface $connection
     * @return bool TRUE on success or FALSE on failure.
     */
    public function commit(ConnectionInterface $connection)
    {
        return $connection->commit();
    }

    /**
     * Rolls back a transaction.
     *
     * Rolls back the current transaction, as initiated by beginTransaction().
     * It is an error to call this method if no transaction is active.
     * If the database was set to autocommit mode, this function will restore
     * autocommit mode after it has rolled back the transaction.
     *
     * @param ConnectionInterface $connection
     * @return bool TRUE on success or FALSE on failure.
     */
    public function rollBack(ConnectionInterface $connection)
    {
        return $connection->rollBack();
    }

    /**
     * @param $sql
     * @param array $params
     * @param int $fetchMethod
     * @return array
     */
    public function query($sql, array $params, int $fetchMethod = PDO::FETCH_ASSOC)
    {
        $con = $this->getConnection();
        $stmt = $con->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll($fetchMethod);
    }

    /**
     * @param $sql
     * @param array $params
     * @return array
     */
    public function fetch($sql, array $params)
    {
        $con = $this->getConnection();
        $stmt = $con->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetch();
    }
}