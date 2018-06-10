<?php

namespace AppBundle\Database\Propel\Model\Base;

use \Exception;
use \PDO;
use AppBundle\Database\Propel\Model\Artist as ChildArtist;
use AppBundle\Database\Propel\Model\ArtistQuery as ChildArtistQuery;
use AppBundle\Database\Propel\Model\Map\ArtistTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'artist' table.
 *
 *
 *
 * @method     ChildArtistQuery orderByArtistId($order = Criteria::ASC) Order by the artist_id column
 * @method     ChildArtistQuery orderByFirstname($order = Criteria::ASC) Order by the firstname column
 * @method     ChildArtistQuery orderByLastname($order = Criteria::ASC) Order by the lastname column
 *
 * @method     ChildArtistQuery groupByArtistId() Group by the artist_id column
 * @method     ChildArtistQuery groupByFirstname() Group by the firstname column
 * @method     ChildArtistQuery groupByLastname() Group by the lastname column
 *
 * @method     ChildArtistQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildArtistQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildArtistQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildArtistQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildArtistQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildArtistQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildArtistQuery leftJoinAlbum($relationAlias = null) Adds a LEFT JOIN clause to the query using the Album relation
 * @method     ChildArtistQuery rightJoinAlbum($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Album relation
 * @method     ChildArtistQuery innerJoinAlbum($relationAlias = null) Adds a INNER JOIN clause to the query using the Album relation
 *
 * @method     ChildArtistQuery joinWithAlbum($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Album relation
 *
 * @method     ChildArtistQuery leftJoinWithAlbum() Adds a LEFT JOIN clause and with to the query using the Album relation
 * @method     ChildArtistQuery rightJoinWithAlbum() Adds a RIGHT JOIN clause and with to the query using the Album relation
 * @method     ChildArtistQuery innerJoinWithAlbum() Adds a INNER JOIN clause and with to the query using the Album relation
 *
 * @method     \AppBundle\Database\Propel\Model\AlbumQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildArtist findOne(ConnectionInterface $con = null) Return the first ChildArtist matching the query
 * @method     ChildArtist findOneOrCreate(ConnectionInterface $con = null) Return the first ChildArtist matching the query, or a new ChildArtist object populated from the query conditions when no match is found
 *
 * @method     ChildArtist findOneByArtistId(int $artist_id) Return the first ChildArtist filtered by the artist_id column
 * @method     ChildArtist findOneByFirstname(string $firstname) Return the first ChildArtist filtered by the firstname column
 * @method     ChildArtist findOneByLastname(string $lastname) Return the first ChildArtist filtered by the lastname column *

 * @method     ChildArtist requirePk($key, ConnectionInterface $con = null) Return the ChildArtist by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildArtist requireOne(ConnectionInterface $con = null) Return the first ChildArtist matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildArtist requireOneByArtistId(int $artist_id) Return the first ChildArtist filtered by the artist_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildArtist requireOneByFirstname(string $firstname) Return the first ChildArtist filtered by the firstname column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildArtist requireOneByLastname(string $lastname) Return the first ChildArtist filtered by the lastname column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildArtist[]|\AppBundle\Database\Propel\Collection\ObjectCollection find(ConnectionInterface $con = null) Return ChildArtist objects based on current ModelCriteria
 * @method     ChildArtist[]|\AppBundle\Database\Propel\Collection\ObjectCollection findByArtistId(int $artist_id) Return ChildArtist objects filtered by the artist_id column
 * @method     ChildArtist[]|\AppBundle\Database\Propel\Collection\ObjectCollection findByFirstname(string $firstname) Return ChildArtist objects filtered by the firstname column
 * @method     ChildArtist[]|\AppBundle\Database\Propel\Collection\ObjectCollection findByLastname(string $lastname) Return ChildArtist objects filtered by the lastname column
 * @method     ChildArtist[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ArtistQuery extends ModelCriteria
{

    // AppBundle\Database\Propel\Behavior\ObjectFormatterBehavior behavior
    protected $defaultFormatterClass = '\AppBundle\Database\Propel\Formatter\ObjectFormatter';protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \AppBundle\Database\Propel\Model\Base\ArtistQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\AppBundle\\Database\\Propel\\Model\\Artist', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildArtistQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildArtistQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildArtistQuery) {
            return $criteria;
        }
        $query = new ChildArtistQuery();
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
     * @return ChildArtist|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ArtistTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ArtistTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildArtist A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT artist_id, firstname, lastname FROM artist WHERE artist_id = :p0';
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
            /** @var ChildArtist $obj */
            $obj = new ChildArtist();
            $obj->hydrate($row);
            ArtistTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildArtist|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildArtistQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ArtistTableMap::COL_ARTIST_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildArtistQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ArtistTableMap::COL_ARTIST_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the artist_id column
     *
     * Example usage:
     * <code>
     * $query->filterByArtistId(1234); // WHERE artist_id = 1234
     * $query->filterByArtistId(array(12, 34)); // WHERE artist_id IN (12, 34)
     * $query->filterByArtistId(array('min' => 12)); // WHERE artist_id > 12
     * </code>
     *
     * @param     mixed $artistId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildArtistQuery The current query, for fluid interface
     */
    public function filterByArtistId($artistId = null, $comparison = null)
    {
        if (is_array($artistId)) {
            $useMinMax = false;
            if (isset($artistId['min'])) {
                $this->addUsingAlias(ArtistTableMap::COL_ARTIST_ID, $artistId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($artistId['max'])) {
                $this->addUsingAlias(ArtistTableMap::COL_ARTIST_ID, $artistId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArtistTableMap::COL_ARTIST_ID, $artistId, $comparison);
    }

    /**
     * Filter the query on the firstname column
     *
     * Example usage:
     * <code>
     * $query->filterByFirstname('fooValue');   // WHERE firstname = 'fooValue'
     * $query->filterByFirstname('%fooValue%', Criteria::LIKE); // WHERE firstname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $firstname The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildArtistQuery The current query, for fluid interface
     */
    public function filterByFirstname($firstname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($firstname)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArtistTableMap::COL_FIRSTNAME, $firstname, $comparison);
    }

    /**
     * Filter the query on the lastname column
     *
     * Example usage:
     * <code>
     * $query->filterByLastname('fooValue');   // WHERE lastname = 'fooValue'
     * $query->filterByLastname('%fooValue%', Criteria::LIKE); // WHERE lastname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $lastname The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildArtistQuery The current query, for fluid interface
     */
    public function filterByLastname($lastname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($lastname)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArtistTableMap::COL_LASTNAME, $lastname, $comparison);
    }

    /**
     * Filter the query by a related \AppBundle\Database\Propel\Model\Album object
     *
     * @param \AppBundle\Database\Propel\Model\Album|\AppBundle\Database\Propel\Collection\ObjectCollection $album the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildArtistQuery The current query, for fluid interface
     */
    public function filterByAlbum($album, $comparison = null)
    {
        if ($album instanceof \AppBundle\Database\Propel\Model\Album) {
            return $this
                ->addUsingAlias(ArtistTableMap::COL_ARTIST_ID, $album->getArtistId(), $comparison);
        } elseif ($album instanceof \AppBundle\Database\Propel\Collection\ObjectCollection) {
            return $this
                ->useAlbumQuery()
                ->filterByPrimaryKeys($album->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAlbum() only accepts arguments of type \AppBundle\Database\Propel\Model\Album or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Album relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildArtistQuery The current query, for fluid interface
     */
    public function joinAlbum($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Album');

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
            $this->addJoinObject($join, 'Album');
        }

        return $this;
    }

    /**
     * Use the Album relation Album object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AppBundle\Database\Propel\Model\AlbumQuery A secondary query class using the current class as primary query
     */
    public function useAlbumQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAlbum($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Album', '\AppBundle\Database\Propel\Model\AlbumQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildArtist $artist Object to remove from the list of results
     *
     * @return $this|ChildArtistQuery The current query, for fluid interface
     */
    public function prune($artist = null)
    {
        if ($artist) {
            $this->addUsingAlias(ArtistTableMap::COL_ARTIST_ID, $artist->getArtistId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the artist table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ArtistTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ArtistTableMap::clearInstancePool();
            ArtistTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ArtistTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ArtistTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ArtistTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ArtistTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ArtistQuery
