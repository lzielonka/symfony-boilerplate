<?php

namespace AppBundle\Database\Propel\Model\Base;

use \Exception;
use AppBundle\Database\Propel\Model\AccountSong as ChildAccountSong;
use AppBundle\Database\Propel\Model\AccountSongQuery as ChildAccountSongQuery;
use AppBundle\Database\Propel\Model\Map\AccountSongTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'account_song' table.
 *
 *
 *
 * @method     ChildAccountSongQuery orderByAccountId($order = Criteria::ASC) Order by the account_id column
 * @method     ChildAccountSongQuery orderBySongId($order = Criteria::ASC) Order by the song_id column
 *
 * @method     ChildAccountSongQuery groupByAccountId() Group by the account_id column
 * @method     ChildAccountSongQuery groupBySongId() Group by the song_id column
 *
 * @method     ChildAccountSongQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAccountSongQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAccountSongQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAccountSongQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAccountSongQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAccountSongQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAccountSongQuery leftJoinAccount($relationAlias = null) Adds a LEFT JOIN clause to the query using the Account relation
 * @method     ChildAccountSongQuery rightJoinAccount($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Account relation
 * @method     ChildAccountSongQuery innerJoinAccount($relationAlias = null) Adds a INNER JOIN clause to the query using the Account relation
 *
 * @method     ChildAccountSongQuery joinWithAccount($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Account relation
 *
 * @method     ChildAccountSongQuery leftJoinWithAccount() Adds a LEFT JOIN clause and with to the query using the Account relation
 * @method     ChildAccountSongQuery rightJoinWithAccount() Adds a RIGHT JOIN clause and with to the query using the Account relation
 * @method     ChildAccountSongQuery innerJoinWithAccount() Adds a INNER JOIN clause and with to the query using the Account relation
 *
 * @method     ChildAccountSongQuery leftJoinSong($relationAlias = null) Adds a LEFT JOIN clause to the query using the Song relation
 * @method     ChildAccountSongQuery rightJoinSong($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Song relation
 * @method     ChildAccountSongQuery innerJoinSong($relationAlias = null) Adds a INNER JOIN clause to the query using the Song relation
 *
 * @method     ChildAccountSongQuery joinWithSong($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Song relation
 *
 * @method     ChildAccountSongQuery leftJoinWithSong() Adds a LEFT JOIN clause and with to the query using the Song relation
 * @method     ChildAccountSongQuery rightJoinWithSong() Adds a RIGHT JOIN clause and with to the query using the Song relation
 * @method     ChildAccountSongQuery innerJoinWithSong() Adds a INNER JOIN clause and with to the query using the Song relation
 *
 * @method     \AppBundle\Database\Propel\Model\AccountQuery|\AppBundle\Database\Propel\Model\SongQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAccountSong findOne(ConnectionInterface $con = null) Return the first ChildAccountSong matching the query
 * @method     ChildAccountSong findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAccountSong matching the query, or a new ChildAccountSong object populated from the query conditions when no match is found
 *
 * @method     ChildAccountSong findOneByAccountId(int $account_id) Return the first ChildAccountSong filtered by the account_id column
 * @method     ChildAccountSong findOneBySongId(int $song_id) Return the first ChildAccountSong filtered by the song_id column *

 * @method     ChildAccountSong requirePk($key, ConnectionInterface $con = null) Return the ChildAccountSong by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccountSong requireOne(ConnectionInterface $con = null) Return the first ChildAccountSong matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAccountSong requireOneByAccountId(int $account_id) Return the first ChildAccountSong filtered by the account_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccountSong requireOneBySongId(int $song_id) Return the first ChildAccountSong filtered by the song_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAccountSong[]|\AppBundle\Database\Propel\Collection\ObjectCollection find(ConnectionInterface $con = null) Return ChildAccountSong objects based on current ModelCriteria
 * @method     ChildAccountSong[]|\AppBundle\Database\Propel\Collection\ObjectCollection findByAccountId(int $account_id) Return ChildAccountSong objects filtered by the account_id column
 * @method     ChildAccountSong[]|\AppBundle\Database\Propel\Collection\ObjectCollection findBySongId(int $song_id) Return ChildAccountSong objects filtered by the song_id column
 * @method     ChildAccountSong[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AccountSongQuery extends ModelCriteria
{

    // AppBundle\Database\Propel\Behavior\ObjectFormatterBehavior behavior
    protected $defaultFormatterClass = '\AppBundle\Database\Propel\Formatter\ObjectFormatter';protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \AppBundle\Database\Propel\Model\Base\AccountSongQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\AppBundle\\Database\\Propel\\Model\\AccountSong', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAccountSongQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAccountSongQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAccountSongQuery) {
            return $criteria;
        }
        $query = new ChildAccountSongQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildAccountSong|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        throw new LogicException('The AccountSong object has no primary key');
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return \AppBundle\Database\Propel\Collection\ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        throw new LogicException('The AccountSong object has no primary key');
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildAccountSongQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        throw new LogicException('The AccountSong object has no primary key');
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAccountSongQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        throw new LogicException('The AccountSong object has no primary key');
    }

    /**
     * Filter the query on the account_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAccountId(1234); // WHERE account_id = 1234
     * $query->filterByAccountId(array(12, 34)); // WHERE account_id IN (12, 34)
     * $query->filterByAccountId(array('min' => 12)); // WHERE account_id > 12
     * </code>
     *
     * @see       filterByAccount()
     *
     * @param     mixed $accountId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAccountSongQuery The current query, for fluid interface
     */
    public function filterByAccountId($accountId = null, $comparison = null)
    {
        if (is_array($accountId)) {
            $useMinMax = false;
            if (isset($accountId['min'])) {
                $this->addUsingAlias(AccountSongTableMap::COL_ACCOUNT_ID, $accountId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($accountId['max'])) {
                $this->addUsingAlias(AccountSongTableMap::COL_ACCOUNT_ID, $accountId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccountSongTableMap::COL_ACCOUNT_ID, $accountId, $comparison);
    }

    /**
     * Filter the query on the song_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySongId(1234); // WHERE song_id = 1234
     * $query->filterBySongId(array(12, 34)); // WHERE song_id IN (12, 34)
     * $query->filterBySongId(array('min' => 12)); // WHERE song_id > 12
     * </code>
     *
     * @see       filterBySong()
     *
     * @param     mixed $songId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAccountSongQuery The current query, for fluid interface
     */
    public function filterBySongId($songId = null, $comparison = null)
    {
        if (is_array($songId)) {
            $useMinMax = false;
            if (isset($songId['min'])) {
                $this->addUsingAlias(AccountSongTableMap::COL_SONG_ID, $songId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($songId['max'])) {
                $this->addUsingAlias(AccountSongTableMap::COL_SONG_ID, $songId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccountSongTableMap::COL_SONG_ID, $songId, $comparison);
    }

    /**
     * Filter the query by a related \AppBundle\Database\Propel\Model\Account object
     *
     * @param \AppBundle\Database\Propel\Model\Account|\AppBundle\Database\Propel\Collection\ObjectCollection $account The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAccountSongQuery The current query, for fluid interface
     */
    public function filterByAccount($account, $comparison = null)
    {
        if ($account instanceof \AppBundle\Database\Propel\Model\Account) {
            return $this
                ->addUsingAlias(AccountSongTableMap::COL_ACCOUNT_ID, $account->getAccountId(), $comparison);
        } elseif ($account instanceof \AppBundle\Database\Propel\Collection\ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AccountSongTableMap::COL_ACCOUNT_ID, $account->toKeyValue('PrimaryKey', 'AccountId'), $comparison);
        } else {
            throw new PropelException('filterByAccount() only accepts arguments of type \AppBundle\Database\Propel\Model\Account or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Account relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAccountSongQuery The current query, for fluid interface
     */
    public function joinAccount($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Account');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Account');
        }

        return $this;
    }

    /**
     * Use the Account relation Account object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AppBundle\Database\Propel\Model\AccountQuery A secondary query class using the current class as primary query
     */
    public function useAccountQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAccount($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Account', '\AppBundle\Database\Propel\Model\AccountQuery');
    }

    /**
     * Filter the query by a related \AppBundle\Database\Propel\Model\Song object
     *
     * @param \AppBundle\Database\Propel\Model\Song|\AppBundle\Database\Propel\Collection\ObjectCollection $song The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAccountSongQuery The current query, for fluid interface
     */
    public function filterBySong($song, $comparison = null)
    {
        if ($song instanceof \AppBundle\Database\Propel\Model\Song) {
            return $this
                ->addUsingAlias(AccountSongTableMap::COL_SONG_ID, $song->getSongId(), $comparison);
        } elseif ($song instanceof \AppBundle\Database\Propel\Collection\ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AccountSongTableMap::COL_SONG_ID, $song->toKeyValue('PrimaryKey', 'SongId'), $comparison);
        } else {
            throw new PropelException('filterBySong() only accepts arguments of type \AppBundle\Database\Propel\Model\Song or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Song relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAccountSongQuery The current query, for fluid interface
     */
    public function joinSong($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Song');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Song');
        }

        return $this;
    }

    /**
     * Use the Song relation Song object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AppBundle\Database\Propel\Model\SongQuery A secondary query class using the current class as primary query
     */
    public function useSongQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSong($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Song', '\AppBundle\Database\Propel\Model\SongQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAccountSong $accountSong Object to remove from the list of results
     *
     * @return $this|ChildAccountSongQuery The current query, for fluid interface
     */
    public function prune($accountSong = null)
    {
        if ($accountSong) {
            throw new LogicException('AccountSong object has no primary key');

        }

        return $this;
    }

    /**
     * Deletes all rows from the account_song table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AccountSongTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AccountSongTableMap::clearInstancePool();
            AccountSongTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AccountSongTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AccountSongTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AccountSongTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AccountSongTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // AccountSongQuery
