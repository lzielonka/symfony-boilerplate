<?php

namespace AppBundle\Database\Propel\Model\Base;

use \Exception;
use \PDO;
use AppBundle\Database\Propel\Model\Album as ChildAlbum;
use AppBundle\Database\Propel\Model\AlbumQuery as ChildAlbumQuery;
use AppBundle\Database\Propel\Model\Map\AlbumTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'album' table.
 *
 *
 *
 * @method     ChildAlbumQuery orderByAlbumId($order = Criteria::ASC) Order by the album_id column
 * @method     ChildAlbumQuery orderByArtistId($order = Criteria::ASC) Order by the artist_id column
 * @method     ChildAlbumQuery orderByTitle($order = Criteria::ASC) Order by the title column
 *
 * @method     ChildAlbumQuery groupByAlbumId() Group by the album_id column
 * @method     ChildAlbumQuery groupByArtistId() Group by the artist_id column
 * @method     ChildAlbumQuery groupByTitle() Group by the title column
 *
 * @method     ChildAlbumQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAlbumQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAlbumQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAlbumQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAlbumQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAlbumQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAlbumQuery leftJoinArtist($relationAlias = null) Adds a LEFT JOIN clause to the query using the Artist relation
 * @method     ChildAlbumQuery rightJoinArtist($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Artist relation
 * @method     ChildAlbumQuery innerJoinArtist($relationAlias = null) Adds a INNER JOIN clause to the query using the Artist relation
 *
 * @method     ChildAlbumQuery joinWithArtist($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Artist relation
 *
 * @method     ChildAlbumQuery leftJoinWithArtist() Adds a LEFT JOIN clause and with to the query using the Artist relation
 * @method     ChildAlbumQuery rightJoinWithArtist() Adds a RIGHT JOIN clause and with to the query using the Artist relation
 * @method     ChildAlbumQuery innerJoinWithArtist() Adds a INNER JOIN clause and with to the query using the Artist relation
 *
 * @method     ChildAlbumQuery leftJoinSong($relationAlias = null) Adds a LEFT JOIN clause to the query using the Song relation
 * @method     ChildAlbumQuery rightJoinSong($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Song relation
 * @method     ChildAlbumQuery innerJoinSong($relationAlias = null) Adds a INNER JOIN clause to the query using the Song relation
 *
 * @method     ChildAlbumQuery joinWithSong($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Song relation
 *
 * @method     ChildAlbumQuery leftJoinWithSong() Adds a LEFT JOIN clause and with to the query using the Song relation
 * @method     ChildAlbumQuery rightJoinWithSong() Adds a RIGHT JOIN clause and with to the query using the Song relation
 * @method     ChildAlbumQuery innerJoinWithSong() Adds a INNER JOIN clause and with to the query using the Song relation
 *
 * @method     \AppBundle\Database\Propel\Model\ArtistQuery|\AppBundle\Database\Propel\Model\SongQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAlbum findOne(ConnectionInterface $con = null) Return the first ChildAlbum matching the query
 * @method     ChildAlbum findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAlbum matching the query, or a new ChildAlbum object populated from the query conditions when no match is found
 *
 * @method     ChildAlbum findOneByAlbumId(int $album_id) Return the first ChildAlbum filtered by the album_id column
 * @method     ChildAlbum findOneByArtistId(int $artist_id) Return the first ChildAlbum filtered by the artist_id column
 * @method     ChildAlbum findOneByTitle(string $title) Return the first ChildAlbum filtered by the title column *

 * @method     ChildAlbum requirePk($key, ConnectionInterface $con = null) Return the ChildAlbum by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAlbum requireOne(ConnectionInterface $con = null) Return the first ChildAlbum matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAlbum requireOneByAlbumId(int $album_id) Return the first ChildAlbum filtered by the album_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAlbum requireOneByArtistId(int $artist_id) Return the first ChildAlbum filtered by the artist_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAlbum requireOneByTitle(string $title) Return the first ChildAlbum filtered by the title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAlbum[]|\AppBundle\Database\Propel\Collection\ObjectCollection find(ConnectionInterface $con = null) Return ChildAlbum objects based on current ModelCriteria
 * @method     ChildAlbum[]|\AppBundle\Database\Propel\Collection\ObjectCollection findByAlbumId(int $album_id) Return ChildAlbum objects filtered by the album_id column
 * @method     ChildAlbum[]|\AppBundle\Database\Propel\Collection\ObjectCollection findByArtistId(int $artist_id) Return ChildAlbum objects filtered by the artist_id column
 * @method     ChildAlbum[]|\AppBundle\Database\Propel\Collection\ObjectCollection findByTitle(string $title) Return ChildAlbum objects filtered by the title column
 * @method     ChildAlbum[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AlbumQuery extends ModelCriteria
{

    // AppBundle\Database\Propel\Behavior\ObjectFormatterBehavior behavior
    protected $defaultFormatterClass = '\AppBundle\Database\Propel\Formatter\ObjectFormatter';protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \AppBundle\Database\Propel\Model\Base\AlbumQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\AppBundle\\Database\\Propel\\Model\\Album', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAlbumQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAlbumQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAlbumQuery) {
            return $criteria;
        }
        $query = new ChildAlbumQuery();
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
     * @return ChildAlbum|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AlbumTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = AlbumTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildAlbum A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT album_id, artist_id, title FROM album WHERE album_id = :p0';
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
            /** @var ChildAlbum $obj */
            $obj = new ChildAlbum();
            $obj->hydrate($row);
            AlbumTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildAlbum|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildAlbumQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AlbumTableMap::COL_ALBUM_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAlbumQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AlbumTableMap::COL_ALBUM_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the album_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAlbumId(1234); // WHERE album_id = 1234
     * $query->filterByAlbumId(array(12, 34)); // WHERE album_id IN (12, 34)
     * $query->filterByAlbumId(array('min' => 12)); // WHERE album_id > 12
     * </code>
     *
     * @param     mixed $albumId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAlbumQuery The current query, for fluid interface
     */
    public function filterByAlbumId($albumId = null, $comparison = null)
    {
        if (is_array($albumId)) {
            $useMinMax = false;
            if (isset($albumId['min'])) {
                $this->addUsingAlias(AlbumTableMap::COL_ALBUM_ID, $albumId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($albumId['max'])) {
                $this->addUsingAlias(AlbumTableMap::COL_ALBUM_ID, $albumId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AlbumTableMap::COL_ALBUM_ID, $albumId, $comparison);
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
     * @see       filterByArtist()
     *
     * @param     mixed $artistId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAlbumQuery The current query, for fluid interface
     */
    public function filterByArtistId($artistId = null, $comparison = null)
    {
        if (is_array($artistId)) {
            $useMinMax = false;
            if (isset($artistId['min'])) {
                $this->addUsingAlias(AlbumTableMap::COL_ARTIST_ID, $artistId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($artistId['max'])) {
                $this->addUsingAlias(AlbumTableMap::COL_ARTIST_ID, $artistId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AlbumTableMap::COL_ARTIST_ID, $artistId, $comparison);
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
     * @return $this|ChildAlbumQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AlbumTableMap::COL_TITLE, $title, $comparison);
    }

    /**
     * Filter the query by a related \AppBundle\Database\Propel\Model\Artist object
     *
     * @param \AppBundle\Database\Propel\Model\Artist|\AppBundle\Database\Propel\Collection\ObjectCollection $artist The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAlbumQuery The current query, for fluid interface
     */
    public function filterByArtist($artist, $comparison = null)
    {
        if ($artist instanceof \AppBundle\Database\Propel\Model\Artist) {
            return $this
                ->addUsingAlias(AlbumTableMap::COL_ARTIST_ID, $artist->getArtistId(), $comparison);
        } elseif ($artist instanceof \AppBundle\Database\Propel\Collection\ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AlbumTableMap::COL_ARTIST_ID, $artist->toKeyValue('PrimaryKey', 'ArtistId'), $comparison);
        } else {
            throw new PropelException('filterByArtist() only accepts arguments of type \AppBundle\Database\Propel\Model\Artist or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Artist relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAlbumQuery The current query, for fluid interface
     */
    public function joinArtist($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Artist');

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
            $this->addJoinObject($join, 'Artist');
        }

        return $this;
    }

    /**
     * Use the Artist relation Artist object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AppBundle\Database\Propel\Model\ArtistQuery A secondary query class using the current class as primary query
     */
    public function useArtistQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinArtist($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Artist', '\AppBundle\Database\Propel\Model\ArtistQuery');
    }

    /**
     * Filter the query by a related \AppBundle\Database\Propel\Model\Song object
     *
     * @param \AppBundle\Database\Propel\Model\Song|\AppBundle\Database\Propel\Collection\ObjectCollection $song the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAlbumQuery The current query, for fluid interface
     */
    public function filterBySong($song, $comparison = null)
    {
        if ($song instanceof \AppBundle\Database\Propel\Model\Song) {
            return $this
                ->addUsingAlias(AlbumTableMap::COL_ALBUM_ID, $song->getAlbumId(), $comparison);
        } elseif ($song instanceof \AppBundle\Database\Propel\Collection\ObjectCollection) {
            return $this
                ->useSongQuery()
                ->filterByPrimaryKeys($song->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildAlbumQuery The current query, for fluid interface
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
     * @param   ChildAlbum $album Object to remove from the list of results
     *
     * @return $this|ChildAlbumQuery The current query, for fluid interface
     */
    public function prune($album = null)
    {
        if ($album) {
            $this->addUsingAlias(AlbumTableMap::COL_ALBUM_ID, $album->getAlbumId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the album table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AlbumTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AlbumTableMap::clearInstancePool();
            AlbumTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AlbumTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AlbumTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AlbumTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AlbumTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // AlbumQuery
