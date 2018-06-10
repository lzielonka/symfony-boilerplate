<?php

namespace AppBundle\Database\Propel\Model\Base;

use \Exception;
use \PDO;
use AppBundle\Database\Propel\Model\Movie as ChildMovie;
use AppBundle\Database\Propel\Model\MovieQuery as ChildMovieQuery;
use AppBundle\Database\Propel\Model\Map\MovieTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'movie' table.
 *
 *
 *
 * @method     ChildMovieQuery orderByMovieId($order = Criteria::ASC) Order by the movie_id column
 * @method     ChildMovieQuery orderByTitle($order = Criteria::ASC) Order by the title column
 *
 * @method     ChildMovieQuery groupByMovieId() Group by the movie_id column
 * @method     ChildMovieQuery groupByTitle() Group by the title column
 *
 * @method     ChildMovieQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMovieQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMovieQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMovieQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildMovieQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildMovieQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildMovieQuery leftJoinAccountMovie($relationAlias = null) Adds a LEFT JOIN clause to the query using the AccountMovie relation
 * @method     ChildMovieQuery rightJoinAccountMovie($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AccountMovie relation
 * @method     ChildMovieQuery innerJoinAccountMovie($relationAlias = null) Adds a INNER JOIN clause to the query using the AccountMovie relation
 *
 * @method     ChildMovieQuery joinWithAccountMovie($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the AccountMovie relation
 *
 * @method     ChildMovieQuery leftJoinWithAccountMovie() Adds a LEFT JOIN clause and with to the query using the AccountMovie relation
 * @method     ChildMovieQuery rightJoinWithAccountMovie() Adds a RIGHT JOIN clause and with to the query using the AccountMovie relation
 * @method     ChildMovieQuery innerJoinWithAccountMovie() Adds a INNER JOIN clause and with to the query using the AccountMovie relation
 *
 * @method     \AppBundle\Database\Propel\Model\AccountMovieQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildMovie findOne(ConnectionInterface $con = null) Return the first ChildMovie matching the query
 * @method     ChildMovie findOneOrCreate(ConnectionInterface $con = null) Return the first ChildMovie matching the query, or a new ChildMovie object populated from the query conditions when no match is found
 *
 * @method     ChildMovie findOneByMovieId(int $movie_id) Return the first ChildMovie filtered by the movie_id column
 * @method     ChildMovie findOneByTitle(string $title) Return the first ChildMovie filtered by the title column *

 * @method     ChildMovie requirePk($key, ConnectionInterface $con = null) Return the ChildMovie by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMovie requireOne(ConnectionInterface $con = null) Return the first ChildMovie matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMovie requireOneByMovieId(int $movie_id) Return the first ChildMovie filtered by the movie_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMovie requireOneByTitle(string $title) Return the first ChildMovie filtered by the title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMovie[]|\AppBundle\Database\Propel\Collection\ObjectCollection find(ConnectionInterface $con = null) Return ChildMovie objects based on current ModelCriteria
 * @method     ChildMovie[]|\AppBundle\Database\Propel\Collection\ObjectCollection findByMovieId(int $movie_id) Return ChildMovie objects filtered by the movie_id column
 * @method     ChildMovie[]|\AppBundle\Database\Propel\Collection\ObjectCollection findByTitle(string $title) Return ChildMovie objects filtered by the title column
 * @method     ChildMovie[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class MovieQuery extends ModelCriteria
{

    // AppBundle\Database\Propel\Behavior\ObjectFormatterBehavior behavior
    protected $defaultFormatterClass = '\AppBundle\Database\Propel\Formatter\ObjectFormatter';protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \AppBundle\Database\Propel\Model\Base\MovieQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\AppBundle\\Database\\Propel\\Model\\Movie', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMovieQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMovieQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildMovieQuery) {
            return $criteria;
        }
        $query = new ChildMovieQuery();
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
     * @return ChildMovie|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MovieTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = MovieTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildMovie A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT movie_id, title FROM movie WHERE movie_id = :p0';
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
            /** @var ChildMovie $obj */
            $obj = new ChildMovie();
            $obj->hydrate($row);
            MovieTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildMovie|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildMovieQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(MovieTableMap::COL_MOVIE_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildMovieQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(MovieTableMap::COL_MOVIE_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the movie_id column
     *
     * Example usage:
     * <code>
     * $query->filterByMovieId(1234); // WHERE movie_id = 1234
     * $query->filterByMovieId(array(12, 34)); // WHERE movie_id IN (12, 34)
     * $query->filterByMovieId(array('min' => 12)); // WHERE movie_id > 12
     * </code>
     *
     * @param     mixed $movieId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMovieQuery The current query, for fluid interface
     */
    public function filterByMovieId($movieId = null, $comparison = null)
    {
        if (is_array($movieId)) {
            $useMinMax = false;
            if (isset($movieId['min'])) {
                $this->addUsingAlias(MovieTableMap::COL_MOVIE_ID, $movieId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($movieId['max'])) {
                $this->addUsingAlias(MovieTableMap::COL_MOVIE_ID, $movieId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MovieTableMap::COL_MOVIE_ID, $movieId, $comparison);
    }

    /**
     * Filter the query on the title column
     *
     * Example usage:
     * <code>
     * $query->filterByTitle('fooValue');   // WHERE title = 'fooValue'
     * $query->filterByTitle('%fooValue%', Criteria::LIKE); // WHERE title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $title The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMovieQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MovieTableMap::COL_TITLE, $title, $comparison);
    }

    /**
     * Filter the query by a related \AppBundle\Database\Propel\Model\AccountMovie object
     *
     * @param \AppBundle\Database\Propel\Model\AccountMovie|\AppBundle\Database\Propel\Collection\ObjectCollection $accountMovie the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMovieQuery The current query, for fluid interface
     */
    public function filterByAccountMovie($accountMovie, $comparison = null)
    {
        if ($accountMovie instanceof \AppBundle\Database\Propel\Model\AccountMovie) {
            return $this
                ->addUsingAlias(MovieTableMap::COL_MOVIE_ID, $accountMovie->getMovieId(), $comparison);
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
     * @return $this|ChildMovieQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildMovie $movie Object to remove from the list of results
     *
     * @return $this|ChildMovieQuery The current query, for fluid interface
     */
    public function prune($movie = null)
    {
        if ($movie) {
            $this->addUsingAlias(MovieTableMap::COL_MOVIE_ID, $movie->getMovieId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the movie table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MovieTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            MovieTableMap::clearInstancePool();
            MovieTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(MovieTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MovieTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            MovieTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            MovieTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // MovieQuery
