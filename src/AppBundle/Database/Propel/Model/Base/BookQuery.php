<?php

namespace AppBundle\Database\Propel\Model\Base;

use \Exception;
use \PDO;
use AppBundle\Database\Propel\Model\Book as ChildBook;
use AppBundle\Database\Propel\Model\BookQuery as ChildBookQuery;
use AppBundle\Database\Propel\Model\Map\BookTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'book' table.
 *
 *
 *
 * @method     ChildBookQuery orderByBookId($order = Criteria::ASC) Order by the book_id column
 * @method     ChildBookQuery orderByWriterId($order = Criteria::ASC) Order by the writer_id column
 * @method     ChildBookQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildBookQuery orderByIsbn($order = Criteria::ASC) Order by the ISBN column
 *
 * @method     ChildBookQuery groupByBookId() Group by the book_id column
 * @method     ChildBookQuery groupByWriterId() Group by the writer_id column
 * @method     ChildBookQuery groupByTitle() Group by the title column
 * @method     ChildBookQuery groupByIsbn() Group by the ISBN column
 *
 * @method     ChildBookQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildBookQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildBookQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildBookQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildBookQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildBookQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildBookQuery leftJoinWriter($relationAlias = null) Adds a LEFT JOIN clause to the query using the Writer relation
 * @method     ChildBookQuery rightJoinWriter($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Writer relation
 * @method     ChildBookQuery innerJoinWriter($relationAlias = null) Adds a INNER JOIN clause to the query using the Writer relation
 *
 * @method     ChildBookQuery joinWithWriter($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Writer relation
 *
 * @method     ChildBookQuery leftJoinWithWriter() Adds a LEFT JOIN clause and with to the query using the Writer relation
 * @method     ChildBookQuery rightJoinWithWriter() Adds a RIGHT JOIN clause and with to the query using the Writer relation
 * @method     ChildBookQuery innerJoinWithWriter() Adds a INNER JOIN clause and with to the query using the Writer relation
 *
 * @method     ChildBookQuery leftJoinAccountBook($relationAlias = null) Adds a LEFT JOIN clause to the query using the AccountBook relation
 * @method     ChildBookQuery rightJoinAccountBook($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AccountBook relation
 * @method     ChildBookQuery innerJoinAccountBook($relationAlias = null) Adds a INNER JOIN clause to the query using the AccountBook relation
 *
 * @method     ChildBookQuery joinWithAccountBook($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the AccountBook relation
 *
 * @method     ChildBookQuery leftJoinWithAccountBook() Adds a LEFT JOIN clause and with to the query using the AccountBook relation
 * @method     ChildBookQuery rightJoinWithAccountBook() Adds a RIGHT JOIN clause and with to the query using the AccountBook relation
 * @method     ChildBookQuery innerJoinWithAccountBook() Adds a INNER JOIN clause and with to the query using the AccountBook relation
 *
 * @method     \AppBundle\Database\Propel\Model\WriterQuery|\AppBundle\Database\Propel\Model\AccountBookQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildBook findOne(ConnectionInterface $con = null) Return the first ChildBook matching the query
 * @method     ChildBook findOneOrCreate(ConnectionInterface $con = null) Return the first ChildBook matching the query, or a new ChildBook object populated from the query conditions when no match is found
 *
 * @method     ChildBook findOneByBookId(int $book_id) Return the first ChildBook filtered by the book_id column
 * @method     ChildBook findOneByWriterId(int $writer_id) Return the first ChildBook filtered by the writer_id column
 * @method     ChildBook findOneByTitle(string $title) Return the first ChildBook filtered by the title column
 * @method     ChildBook findOneByIsbn(string $ISBN) Return the first ChildBook filtered by the ISBN column *

 * @method     ChildBook requirePk($key, ConnectionInterface $con = null) Return the ChildBook by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBook requireOne(ConnectionInterface $con = null) Return the first ChildBook matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBook requireOneByBookId(int $book_id) Return the first ChildBook filtered by the book_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBook requireOneByWriterId(int $writer_id) Return the first ChildBook filtered by the writer_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBook requireOneByTitle(string $title) Return the first ChildBook filtered by the title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBook requireOneByIsbn(string $ISBN) Return the first ChildBook filtered by the ISBN column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBook[]|\AppBundle\Database\Propel\Collection\ObjectCollection find(ConnectionInterface $con = null) Return ChildBook objects based on current ModelCriteria
 * @method     ChildBook[]|\AppBundle\Database\Propel\Collection\ObjectCollection findByBookId(int $book_id) Return ChildBook objects filtered by the book_id column
 * @method     ChildBook[]|\AppBundle\Database\Propel\Collection\ObjectCollection findByWriterId(int $writer_id) Return ChildBook objects filtered by the writer_id column
 * @method     ChildBook[]|\AppBundle\Database\Propel\Collection\ObjectCollection findByTitle(string $title) Return ChildBook objects filtered by the title column
 * @method     ChildBook[]|\AppBundle\Database\Propel\Collection\ObjectCollection findByIsbn(string $ISBN) Return ChildBook objects filtered by the ISBN column
 * @method     ChildBook[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class BookQuery extends ModelCriteria
{

    // AppBundle\Database\Propel\Behavior\ObjectFormatterBehavior behavior
    protected $defaultFormatterClass = '\AppBundle\Database\Propel\Formatter\ObjectFormatter';protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \AppBundle\Database\Propel\Model\Base\BookQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\AppBundle\\Database\\Propel\\Model\\Book', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildBookQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildBookQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildBookQuery) {
            return $criteria;
        }
        $query = new ChildBookQuery();
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
     * @return ChildBook|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(BookTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = BookTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildBook A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT book_id, writer_id, title, ISBN FROM book WHERE book_id = :p0';
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
            /** @var ChildBook $obj */
            $obj = new ChildBook();
            $obj->hydrate($row);
            BookTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildBook|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildBookQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(BookTableMap::COL_BOOK_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildBookQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(BookTableMap::COL_BOOK_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the book_id column
     *
     * Example usage:
     * <code>
     * $query->filterByBookId(1234); // WHERE book_id = 1234
     * $query->filterByBookId(array(12, 34)); // WHERE book_id IN (12, 34)
     * $query->filterByBookId(array('min' => 12)); // WHERE book_id > 12
     * </code>
     *
     * @param     mixed $bookId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBookQuery The current query, for fluid interface
     */
    public function filterByBookId($bookId = null, $comparison = null)
    {
        if (is_array($bookId)) {
            $useMinMax = false;
            if (isset($bookId['min'])) {
                $this->addUsingAlias(BookTableMap::COL_BOOK_ID, $bookId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($bookId['max'])) {
                $this->addUsingAlias(BookTableMap::COL_BOOK_ID, $bookId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BookTableMap::COL_BOOK_ID, $bookId, $comparison);
    }

    /**
     * Filter the query on the writer_id column
     *
     * Example usage:
     * <code>
     * $query->filterByWriterId(1234); // WHERE writer_id = 1234
     * $query->filterByWriterId(array(12, 34)); // WHERE writer_id IN (12, 34)
     * $query->filterByWriterId(array('min' => 12)); // WHERE writer_id > 12
     * </code>
     *
     * @see       filterByWriter()
     *
     * @param     mixed $writerId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBookQuery The current query, for fluid interface
     */
    public function filterByWriterId($writerId = null, $comparison = null)
    {
        if (is_array($writerId)) {
            $useMinMax = false;
            if (isset($writerId['min'])) {
                $this->addUsingAlias(BookTableMap::COL_WRITER_ID, $writerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($writerId['max'])) {
                $this->addUsingAlias(BookTableMap::COL_WRITER_ID, $writerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BookTableMap::COL_WRITER_ID, $writerId, $comparison);
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
     * @return $this|ChildBookQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BookTableMap::COL_TITLE, $title, $comparison);
    }

    /**
     * Filter the query on the ISBN column
     *
     * Example usage:
     * <code>
     * $query->filterByIsbn('fooValue');   // WHERE ISBN = 'fooValue'
     * $query->filterByIsbn('%fooValue%', Criteria::LIKE); // WHERE ISBN LIKE '%fooValue%'
     * </code>
     *
     * @param     string $isbn The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBookQuery The current query, for fluid interface
     */
    public function filterByIsbn($isbn = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($isbn)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BookTableMap::COL_ISBN, $isbn, $comparison);
    }

    /**
     * Filter the query by a related \AppBundle\Database\Propel\Model\Writer object
     *
     * @param \AppBundle\Database\Propel\Model\Writer|\AppBundle\Database\Propel\Collection\ObjectCollection $writer The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildBookQuery The current query, for fluid interface
     */
    public function filterByWriter($writer, $comparison = null)
    {
        if ($writer instanceof \AppBundle\Database\Propel\Model\Writer) {
            return $this
                ->addUsingAlias(BookTableMap::COL_WRITER_ID, $writer->getWriterId(), $comparison);
        } elseif ($writer instanceof \AppBundle\Database\Propel\Collection\ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BookTableMap::COL_WRITER_ID, $writer->toKeyValue('PrimaryKey', 'WriterId'), $comparison);
        } else {
            throw new PropelException('filterByWriter() only accepts arguments of type \AppBundle\Database\Propel\Model\Writer or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Writer relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBookQuery The current query, for fluid interface
     */
    public function joinWriter($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Writer');

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
            $this->addJoinObject($join, 'Writer');
        }

        return $this;
    }

    /**
     * Use the Writer relation Writer object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AppBundle\Database\Propel\Model\WriterQuery A secondary query class using the current class as primary query
     */
    public function useWriterQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinWriter($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Writer', '\AppBundle\Database\Propel\Model\WriterQuery');
    }

    /**
     * Filter the query by a related \AppBundle\Database\Propel\Model\AccountBook object
     *
     * @param \AppBundle\Database\Propel\Model\AccountBook|\AppBundle\Database\Propel\Collection\ObjectCollection $accountBook the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBookQuery The current query, for fluid interface
     */
    public function filterByAccountBook($accountBook, $comparison = null)
    {
        if ($accountBook instanceof \AppBundle\Database\Propel\Model\AccountBook) {
            return $this
                ->addUsingAlias(BookTableMap::COL_BOOK_ID, $accountBook->getBookId(), $comparison);
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
     * @return $this|ChildBookQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildBook $book Object to remove from the list of results
     *
     * @return $this|ChildBookQuery The current query, for fluid interface
     */
    public function prune($book = null)
    {
        if ($book) {
            $this->addUsingAlias(BookTableMap::COL_BOOK_ID, $book->getBookId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the book table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BookTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            BookTableMap::clearInstancePool();
            BookTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(BookTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(BookTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            BookTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            BookTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // BookQuery
