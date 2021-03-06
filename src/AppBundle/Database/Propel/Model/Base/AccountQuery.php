<?php

namespace AppBundle\Database\Propel\Model\Base;

use \Exception;
use \PDO;
use AppBundle\Database\Propel\Model\Account as ChildAccount;
use AppBundle\Database\Propel\Model\AccountQuery as ChildAccountQuery;
use AppBundle\Database\Propel\Model\Map\AccountTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'account' table.
 *
 *
 *
 * @method     ChildAccountQuery orderByAccountId($order = Criteria::ASC) Order by the account_id column
 * @method     ChildAccountQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method     ChildAccountQuery orderByPasswd($order = Criteria::ASC) Order by the passwd column
 * @method     ChildAccountQuery orderBySalt($order = Criteria::ASC) Order by the salt column
 *
 * @method     ChildAccountQuery groupByAccountId() Group by the account_id column
 * @method     ChildAccountQuery groupByEmail() Group by the email column
 * @method     ChildAccountQuery groupByPasswd() Group by the passwd column
 * @method     ChildAccountQuery groupBySalt() Group by the salt column
 *
 * @method     ChildAccountQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAccountQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAccountQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAccountQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAccountQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAccountQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAccountQuery leftJoinAccountBook($relationAlias = null) Adds a LEFT JOIN clause to the query using the AccountBook relation
 * @method     ChildAccountQuery rightJoinAccountBook($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AccountBook relation
 * @method     ChildAccountQuery innerJoinAccountBook($relationAlias = null) Adds a INNER JOIN clause to the query using the AccountBook relation
 *
 * @method     ChildAccountQuery joinWithAccountBook($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the AccountBook relation
 *
 * @method     ChildAccountQuery leftJoinWithAccountBook() Adds a LEFT JOIN clause and with to the query using the AccountBook relation
 * @method     ChildAccountQuery rightJoinWithAccountBook() Adds a RIGHT JOIN clause and with to the query using the AccountBook relation
 * @method     ChildAccountQuery innerJoinWithAccountBook() Adds a INNER JOIN clause and with to the query using the AccountBook relation
 *
 * @method     ChildAccountQuery leftJoinAccountMovie($relationAlias = null) Adds a LEFT JOIN clause to the query using the AccountMovie relation
 * @method     ChildAccountQuery rightJoinAccountMovie($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AccountMovie relation
 * @method     ChildAccountQuery innerJoinAccountMovie($relationAlias = null) Adds a INNER JOIN clause to the query using the AccountMovie relation
 *
 * @method     ChildAccountQuery joinWithAccountMovie($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the AccountMovie relation
 *
 * @method     ChildAccountQuery leftJoinWithAccountMovie() Adds a LEFT JOIN clause and with to the query using the AccountMovie relation
 * @method     ChildAccountQuery rightJoinWithAccountMovie() Adds a RIGHT JOIN clause and with to the query using the AccountMovie relation
 * @method     ChildAccountQuery innerJoinWithAccountMovie() Adds a INNER JOIN clause and with to the query using the AccountMovie relation
 *
 * @method     ChildAccountQuery leftJoinAccountSeries($relationAlias = null) Adds a LEFT JOIN clause to the query using the AccountSeries relation
 * @method     ChildAccountQuery rightJoinAccountSeries($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AccountSeries relation
 * @method     ChildAccountQuery innerJoinAccountSeries($relationAlias = null) Adds a INNER JOIN clause to the query using the AccountSeries relation
 *
 * @method     ChildAccountQuery joinWithAccountSeries($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the AccountSeries relation
 *
 * @method     ChildAccountQuery leftJoinWithAccountSeries() Adds a LEFT JOIN clause and with to the query using the AccountSeries relation
 * @method     ChildAccountQuery rightJoinWithAccountSeries() Adds a RIGHT JOIN clause and with to the query using the AccountSeries relation
 * @method     ChildAccountQuery innerJoinWithAccountSeries() Adds a INNER JOIN clause and with to the query using the AccountSeries relation
 *
 * @method     ChildAccountQuery leftJoinAccountSong($relationAlias = null) Adds a LEFT JOIN clause to the query using the AccountSong relation
 * @method     ChildAccountQuery rightJoinAccountSong($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AccountSong relation
 * @method     ChildAccountQuery innerJoinAccountSong($relationAlias = null) Adds a INNER JOIN clause to the query using the AccountSong relation
 *
 * @method     ChildAccountQuery joinWithAccountSong($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the AccountSong relation
 *
 * @method     ChildAccountQuery leftJoinWithAccountSong() Adds a LEFT JOIN clause and with to the query using the AccountSong relation
 * @method     ChildAccountQuery rightJoinWithAccountSong() Adds a RIGHT JOIN clause and with to the query using the AccountSong relation
 * @method     ChildAccountQuery innerJoinWithAccountSong() Adds a INNER JOIN clause and with to the query using the AccountSong relation
 *
 * @method     \AppBundle\Database\Propel\Model\AccountBookQuery|\AppBundle\Database\Propel\Model\AccountMovieQuery|\AppBundle\Database\Propel\Model\AccountSeriesQuery|\AppBundle\Database\Propel\Model\AccountSongQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAccount findOne(ConnectionInterface $con = null) Return the first ChildAccount matching the query
 * @method     ChildAccount findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAccount matching the query, or a new ChildAccount object populated from the query conditions when no match is found
 *
 * @method     ChildAccount findOneByAccountId(int $account_id) Return the first ChildAccount filtered by the account_id column
 * @method     ChildAccount findOneByEmail(string $email) Return the first ChildAccount filtered by the email column
 * @method     ChildAccount findOneByPasswd(string $passwd) Return the first ChildAccount filtered by the passwd column
 * @method     ChildAccount findOneBySalt(string $salt) Return the first ChildAccount filtered by the salt column *

 * @method     ChildAccount requirePk($key, ConnectionInterface $con = null) Return the ChildAccount by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccount requireOne(ConnectionInterface $con = null) Return the first ChildAccount matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAccount requireOneByAccountId(int $account_id) Return the first ChildAccount filtered by the account_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccount requireOneByEmail(string $email) Return the first ChildAccount filtered by the email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccount requireOneByPasswd(string $passwd) Return the first ChildAccount filtered by the passwd column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccount requireOneBySalt(string $salt) Return the first ChildAccount filtered by the salt column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAccount[]|\AppBundle\Database\Propel\Collection\ObjectCollection find(ConnectionInterface $con = null) Return ChildAccount objects based on current ModelCriteria
 * @method     ChildAccount[]|\AppBundle\Database\Propel\Collection\ObjectCollection findByAccountId(int $account_id) Return ChildAccount objects filtered by the account_id column
 * @method     ChildAccount[]|\AppBundle\Database\Propel\Collection\ObjectCollection findByEmail(string $email) Return ChildAccount objects filtered by the email column
 * @method     ChildAccount[]|\AppBundle\Database\Propel\Collection\ObjectCollection findByPasswd(string $passwd) Return ChildAccount objects filtered by the passwd column
 * @method     ChildAccount[]|\AppBundle\Database\Propel\Collection\ObjectCollection findBySalt(string $salt) Return ChildAccount objects filtered by the salt column
 * @method     ChildAccount[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AccountQuery extends ModelCriteria
{

    // AppBundle\Database\Propel\Behavior\ObjectFormatterBehavior behavior
    protected $defaultFormatterClass = '\AppBundle\Database\Propel\Formatter\ObjectFormatter';protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \AppBundle\Database\Propel\Model\Base\AccountQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\AppBundle\\Database\\Propel\\Model\\Account', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAccountQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAccountQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAccountQuery) {
            return $criteria;
        }
        $query = new ChildAccountQuery();
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
     * @return ChildAccount|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AccountTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = AccountTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAccount A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT account_id, email, passwd, salt FROM account WHERE account_id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildAccount $obj */
            $obj = new ChildAccount();
            $obj->hydrate($row);
            AccountTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildAccount|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return \AppBundle\Database\Propel\Collection\ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildAccountQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AccountTableMap::COL_ACCOUNT_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAccountQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AccountTableMap::COL_ACCOUNT_ID, $keys, Criteria::IN);
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
     * @param     mixed $accountId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAccountQuery The current query, for fluid interface
     */
    public function filterByAccountId($accountId = null, $comparison = null)
    {
        if (is_array($accountId)) {
            $useMinMax = false;
            if (isset($accountId['min'])) {
                $this->addUsingAlias(AccountTableMap::COL_ACCOUNT_ID, $accountId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($accountId['max'])) {
                $this->addUsingAlias(AccountTableMap::COL_ACCOUNT_ID, $accountId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccountTableMap::COL_ACCOUNT_ID, $accountId, $comparison);
    }

    /**
     * Filter the query on the email column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE email = 'fooValue'
     * $query->filterByEmail('%fooValue%', Criteria::LIKE); // WHERE email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAccountQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccountTableMap::COL_EMAIL, $email, $comparison);
    }

    /**
     * Filter the query on the passwd column
     *
     * Example usage:
     * <code>
     * $query->filterByPasswd('fooValue');   // WHERE passwd = 'fooValue'
     * $query->filterByPasswd('%fooValue%', Criteria::LIKE); // WHERE passwd LIKE '%fooValue%'
     * </code>
     *
     * @param     string $passwd The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAccountQuery The current query, for fluid interface
     */
    public function filterByPasswd($passwd = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($passwd)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccountTableMap::COL_PASSWD, $passwd, $comparison);
    }

    /**
     * Filter the query on the salt column
     *
     * Example usage:
     * <code>
     * $query->filterBySalt('fooValue');   // WHERE salt = 'fooValue'
     * $query->filterBySalt('%fooValue%', Criteria::LIKE); // WHERE salt LIKE '%fooValue%'
     * </code>
     *
     * @param     string $salt The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAccountQuery The current query, for fluid interface
     */
    public function filterBySalt($salt = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($salt)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccountTableMap::COL_SALT, $salt, $comparison);
    }

    /**
     * Filter the query by a related \AppBundle\Database\Propel\Model\AccountBook object
     *
     * @param \AppBundle\Database\Propel\Model\AccountBook|\AppBundle\Database\Propel\Collection\ObjectCollection $accountBook the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAccountQuery The current query, for fluid interface
     */
    public function filterByAccountBook($accountBook, $comparison = null)
    {
        if ($accountBook instanceof \AppBundle\Database\Propel\Model\AccountBook) {
            return $this
                ->addUsingAlias(AccountTableMap::COL_ACCOUNT_ID, $accountBook->getAccountId(), $comparison);
        } elseif ($accountBook instanceof \AppBundle\Database\Propel\Collection\ObjectCollection) {
            return $this
                ->useAccountBookQuery()
                ->filterByPrimaryKeys($accountBook->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAccountBook() only accepts arguments of type \AppBundle\Database\Propel\Model\AccountBook or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AccountBook relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAccountQuery The current query, for fluid interface
     */
    public function joinAccountBook($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AccountBook');

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
            $this->addJoinObject($join, 'AccountBook');
        }

        return $this;
    }

    /**
     * Use the AccountBook relation AccountBook object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AppBundle\Database\Propel\Model\AccountBookQuery A secondary query class using the current class as primary query
     */
    public function useAccountBookQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAccountBook($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AccountBook', '\AppBundle\Database\Propel\Model\AccountBookQuery');
    }

    /**
     * Filter the query by a related \AppBundle\Database\Propel\Model\AccountMovie object
     *
     * @param \AppBundle\Database\Propel\Model\AccountMovie|\AppBundle\Database\Propel\Collection\ObjectCollection $accountMovie the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAccountQuery The current query, for fluid interface
     */
    public function filterByAccountMovie($accountMovie, $comparison = null)
    {
        if ($accountMovie instanceof \AppBundle\Database\Propel\Model\AccountMovie) {
            return $this
                ->addUsingAlias(AccountTableMap::COL_ACCOUNT_ID, $accountMovie->getAccountId(), $comparison);
        } elseif ($accountMovie instanceof \AppBundle\Database\Propel\Collection\ObjectCollection) {
            return $this
                ->useAccountMovieQuery()
                ->filterByPrimaryKeys($accountMovie->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAccountMovie() only accepts arguments of type \AppBundle\Database\Propel\Model\AccountMovie or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AccountMovie relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAccountQuery The current query, for fluid interface
     */
    public function joinAccountMovie($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AccountMovie');

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
            $this->addJoinObject($join, 'AccountMovie');
        }

        return $this;
    }

    /**
     * Use the AccountMovie relation AccountMovie object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AppBundle\Database\Propel\Model\AccountMovieQuery A secondary query class using the current class as primary query
     */
    public function useAccountMovieQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAccountMovie($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AccountMovie', '\AppBundle\Database\Propel\Model\AccountMovieQuery');
    }

    /**
     * Filter the query by a related \AppBundle\Database\Propel\Model\AccountSeries object
     *
     * @param \AppBundle\Database\Propel\Model\AccountSeries|\AppBundle\Database\Propel\Collection\ObjectCollection $accountSeries the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAccountQuery The current query, for fluid interface
     */
    public function filterByAccountSeries($accountSeries, $comparison = null)
    {
        if ($accountSeries instanceof \AppBundle\Database\Propel\Model\AccountSeries) {
            return $this
                ->addUsingAlias(AccountTableMap::COL_ACCOUNT_ID, $accountSeries->getAccountId(), $comparison);
        } elseif ($accountSeries instanceof \AppBundle\Database\Propel\Collection\ObjectCollection) {
            return $this
                ->useAccountSeriesQuery()
                ->filterByPrimaryKeys($accountSeries->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAccountSeries() only accepts arguments of type \AppBundle\Database\Propel\Model\AccountSeries or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AccountSeries relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAccountQuery The current query, for fluid interface
     */
    public function joinAccountSeries($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AccountSeries');

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
            $this->addJoinObject($join, 'AccountSeries');
        }

        return $this;
    }

    /**
     * Use the AccountSeries relation AccountSeries object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AppBundle\Database\Propel\Model\AccountSeriesQuery A secondary query class using the current class as primary query
     */
    public function useAccountSeriesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAccountSeries($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AccountSeries', '\AppBundle\Database\Propel\Model\AccountSeriesQuery');
    }

    /**
     * Filter the query by a related \AppBundle\Database\Propel\Model\AccountSong object
     *
     * @param \AppBundle\Database\Propel\Model\AccountSong|\AppBundle\Database\Propel\Collection\ObjectCollection $accountSong the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAccountQuery The current query, for fluid interface
     */
    public function filterByAccountSong($accountSong, $comparison = null)
    {
        if ($accountSong instanceof \AppBundle\Database\Propel\Model\AccountSong) {
            return $this
                ->addUsingAlias(AccountTableMap::COL_ACCOUNT_ID, $accountSong->getAccountId(), $comparison);
        } elseif ($accountSong instanceof \AppBundle\Database\Propel\Collection\ObjectCollection) {
            return $this
                ->useAccountSongQuery()
                ->filterByPrimaryKeys($accountSong->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAccountSong() only accepts arguments of type \AppBundle\Database\Propel\Model\AccountSong or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AccountSong relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAccountQuery The current query, for fluid interface
     */
    public function joinAccountSong($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AccountSong');

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
            $this->addJoinObject($join, 'AccountSong');
        }

        return $this;
    }

    /**
     * Use the AccountSong relation AccountSong object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AppBundle\Database\Propel\Model\AccountSongQuery A secondary query class using the current class as primary query
     */
    public function useAccountSongQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAccountSong($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AccountSong', '\AppBundle\Database\Propel\Model\AccountSongQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAccount $account Object to remove from the list of results
     *
     * @return $this|ChildAccountQuery The current query, for fluid interface
     */
    public function prune($account = null)
    {
        if ($account) {
            $this->addUsingAlias(AccountTableMap::COL_ACCOUNT_ID, $account->getAccountId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the account table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AccountTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AccountTableMap::clearInstancePool();
            AccountTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AccountTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AccountTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AccountTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AccountTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // AccountQuery
