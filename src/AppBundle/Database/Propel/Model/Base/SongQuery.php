<?php

namespace AppBundle\Database\Propel\Model\Base;

use \Exception;
use \PDO;
use AppBundle\Database\Propel\Model\Song as ChildSong;
use AppBundle\Database\Propel\Model\SongQuery as ChildSongQuery;
use AppBundle\Database\Propel\Model\Map\SongTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'song' table.
 *
 *
 *
 * @method     ChildSongQuery orderBySongId($order = Criteria::ASC) Order by the song_id column
 * @method     ChildSongQuery orderByAlbumId($order = Criteria::ASC) Order by the album_id column
 * @method     ChildSongQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildSongQuery orderByPlayCount($order = Criteria::ASC) Order by the play_count column
 *
 * @method     ChildSongQuery groupBySongId() Group by the song_id column
 * @method     ChildSongQuery groupByAlbumId() Group by the album_id column
 * @method     ChildSongQuery groupByTitle() Group by the title column
 * @method     ChildSongQuery groupByPlayCount() Group by the play_count column
 *
 * @method     ChildSongQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSongQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSongQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSongQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildSongQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildSongQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildSongQuery leftJoinAlbum($relationAlias = null) Adds a LEFT JOIN clause to the query using the Album relation
 * @method     ChildSongQuery rightJoinAlbum($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Album relation
 * @method     ChildSongQuery innerJoinAlbum($relationAlias = null) Adds a INNER JOIN clause to the query using the Album relation
 *
 * @method     ChildSongQuery joinWithAlbum($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Album relation
 *
 * @method     ChildSongQuery leftJoinWithAlbum() Adds a LEFT JOIN clause and with to the query using the Album relation
 * @method     ChildSongQuery rightJoinWithAlbum() Adds a RIGHT JOIN clause and with to the query using the Album relation
 * @method     ChildSongQuery innerJoinWithAlbum() Adds a INNER JOIN clause and with to the query using the Album relation
 *
 * @method     ChildSongQuery leftJoinAccountSong($relationAlias = null) Adds a LEFT JOIN clause to the query using the AccountSong relation
 * @method     ChildSongQuery rightJoinAccountSong($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AccountSong relation
 * @method     ChildSongQuery innerJoinAccountSong($relationAlias = null) Adds a INNER JOIN clause to the query using the AccountSong relation
 *
 * @method     ChildSongQuery joinWithAccountSong($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the AccountSong relation
 *
 * @method     ChildSongQuery leftJoinWithAccountSong() Adds a LEFT JOIN clause and with to the query using the AccountSong relation
 * @method     ChildSongQuery rightJoinWithAccountSong() Adds a RIGHT JOIN clause and with to the query using the AccountSong relation
 * @method     ChildSongQuery innerJoinWithAccountSong() Adds a INNER JOIN clause and with to the query using the AccountSong relation
 *
 * @method     \AppBundle\Database\Propel\Model\AlbumQuery|\AppBundle\Database\Propel\Model\AccountSongQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSong findOne(ConnectionInterface $con = null) Return the first ChildSong matching the query
 * @method     ChildSong findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSong matching the query, or a new ChildSong object populated from the query conditions when no match is found
 *
 * @method     ChildSong findOneBySongId(int $song_id) Return the first ChildSong filtered by the song_id column
 * @method     ChildSong findOneByAlbumId(int $album_id) Return the first ChildSong filtered by the album_id column
 * @method     ChildSong findOneByTitle(string $title) Return the first ChildSong filtered by the title column
 * @method     ChildSong findOneByPlayCount(int $play_count) Return the first ChildSong filtered by the play_count column *

 * @method     ChildSong requirePk($key, ConnectionInterface $con = null) Return the ChildSong by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSong requireOne(ConnectionInterface $con = null) Return the first ChildSong matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSong requireOneBySongId(int $song_id) Return the first ChildSong filtered by the song_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSong requireOneByAlbumId(int $album_id) Return the first ChildSong filtered by the album_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSong requireOneByTitle(string $title) Return the first ChildSong filtered by the title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSong requireOneByPlayCount(int $play_count) Return the first ChildSong filtered by the play_count column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSong[]|\AppBundle\Database\Propel\Collection\ObjectCollection find(ConnectionInterface $con = null) Return ChildSong objects based on current ModelCriteria
 * @method     ChildSong[]|\AppBundle\Database\Propel\Collection\ObjectCollection findBySongId(int $song_id) Return ChildSong objects filtered by the song_id column
 * @method     ChildSong[]|\AppBundle\Database\Propel\Collection\ObjectCollection findByAlbumId(int $album_id) Return ChildSong objects filtered by the album_id column
 * @method     ChildSong[]|\AppBundle\Database\Propel\Collection\ObjectCollection findByTitle(string $title) Return ChildSong objects filtered by the title column
 * @method     ChildSong[]|\AppBundle\Database\Propel\Collection\ObjectCollection findByPlayCount(int $play_count) Return ChildSong objects filtered by the play_count column
 * @method     ChildSong[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SongQuery extends ModelCriteria
{

    // AppBundle\Database\Propel\Behavior\ObjectFormatterBehavior behavior
    protected $defaultFormatterClass = '\AppBundle\Database\Propel\Formatter\ObjectFormatter';protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \AppBundle\Database\Propel\Model\Base\SongQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\AppBundle\\Database\\Propel\\Model\\Song', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSongQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSongQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSongQuery) {
            return $criteria;
        }
        $query = new ChildSongQuery();
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
     * @return ChildSong|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SongTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = SongTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildSong A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT song_id, album_id, title, play_count FROM song WHERE song_id = :p0';
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
            /** @var ChildSong $obj */
            $obj = new ChildSong();
            $obj->hydrate($row);
            SongTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildSong|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSongQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SongTableMap::COL_SONG_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSongQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SongTableMap::COL_SONG_ID, $keys, Criteria::IN);
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
     * @param     mixed $songId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSongQuery The current query, for fluid interface
     */
    public function filterBySongId($songId = null, $comparison = null)
    {
        if (is_array($songId)) {
            $useMinMax = false;
            if (isset($songId['min'])) {
                $this->addUsingAlias(SongTableMap::COL_SONG_ID, $songId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($songId['max'])) {
                $this->addUsingAlias(SongTableMap::COL_SONG_ID, $songId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SongTableMap::COL_SONG_ID, $songId, $comparison);
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
     * @see       filterByAlbum()
     *
     * @param     mixed $albumId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSongQuery The current query, for fluid interface
     */
    public function filterByAlbumId($albumId = null, $comparison = null)
    {
        if (is_array($albumId)) {
            $useMinMax = false;
            if (isset($albumId['min'])) {
                $this->addUsingAlias(SongTableMap::COL_ALBUM_ID, $albumId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($albumId['max'])) {
                $this->addUsingAlias(SongTableMap::COL_ALBUM_ID, $albumId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SongTableMap::COL_ALBUM_ID, $albumId, $comparison);
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
     * @return $this|ChildSongQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SongTableMap::COL_TITLE, $title, $comparison);
    }

    /**
     * Filter the query on the play_count column
     *
     * Example usage:
     * <code>
     * $query->filterByPlayCount(1234); // WHERE play_count = 1234
     * $query->filterByPlayCount(array(12, 34)); // WHERE play_count IN (12, 34)
     * $query->filterByPlayCount(array('min' => 12)); // WHERE play_count > 12
     * </code>
     *
     * @param     mixed $playCount The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSongQuery The current query, for fluid interface
     */
    public function filterByPlayCount($playCount = null, $comparison = null)
    {
        if (is_array($playCount)) {
            $useMinMax = false;
            if (isset($playCount['min'])) {
                $this->addUsingAlias(SongTableMap::COL_PLAY_COUNT, $playCount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($playCount['max'])) {
                $this->addUsingAlias(SongTableMap::COL_PLAY_COUNT, $playCount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SongTableMap::COL_PLAY_COUNT, $playCount, $comparison);
    }

    /**
     * Filter the query by a related \AppBundle\Database\Propel\Model\Album object
     *
     * @param \AppBundle\Database\Propel\Model\Album|\AppBundle\Database\Propel\Collection\ObjectCollection $album The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSongQuery The current query, for fluid interface
     */
    public function filterByAlbum($album, $comparison = null)
    {
        if ($album instanceof \AppBundle\Database\Propel\Model\Album) {
            return $this
                ->addUsingAlias(SongTableMap::COL_ALBUM_ID, $album->getAlbumId(), $comparison);
        } elseif ($album instanceof \AppBundle\Database\Propel\Collection\ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SongTableMap::COL_ALBUM_ID, $album->toKeyValue('PrimaryKey', 'AlbumId'), $comparison);
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
     * @return $this|ChildSongQuery The current query, for fluid interface
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
     * Filter the query by a related \AppBundle\Database\Propel\Model\AccountSong object
     *
     * @param \AppBundle\Database\Propel\Model\AccountSong|\AppBundle\Database\Propel\Collection\ObjectCollection $accountSong the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSongQuery The current query, for fluid interface
     */
    public function filterByAccountSong($accountSong, $comparison = null)
    {
        if ($accountSong instanceof \AppBundle\Database\Propel\Model\AccountSong) {
            return $this
                ->addUsingAlias(SongTableMap::COL_SONG_ID, $accountSong->getSongId(), $comparison);
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
     * @return $this|ChildSongQuery The current query, for fluid interface
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
     * @param   ChildSong $song Object to remove from the list of results
     *
     * @return $this|ChildSongQuery The current query, for fluid interface
     */
    public function prune($song = null)
    {
        if ($song) {
            $this->addUsingAlias(SongTableMap::COL_SONG_ID, $song->getSongId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the song table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SongTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SongTableMap::clearInstancePool();
            SongTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SongTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SongTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SongTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SongTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SongQuery
