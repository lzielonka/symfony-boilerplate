<?php

namespace AppBundle\Database\Propel\Model\Base;

use \Exception;
use \PDO;
use AppBundle\Database\Propel\Model\AccountSong as ChildAccountSong;
use AppBundle\Database\Propel\Model\AccountSongQuery as ChildAccountSongQuery;
use AppBundle\Database\Propel\Model\Album as ChildAlbum;
use AppBundle\Database\Propel\Model\AlbumQuery as ChildAlbumQuery;
use AppBundle\Database\Propel\Model\Song as ChildSong;
use AppBundle\Database\Propel\Model\SongQuery as ChildSongQuery;
use AppBundle\Database\Propel\Model\Map\AccountSongTableMap;
use AppBundle\Database\Propel\Model\Map\SongTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

/**
 * Base class that represents a row from the 'song' table.
 *
 *
 *
 * @package    propel.generator.src.AppBundle.Database.Propel.Model.Base
 */
abstract class Song implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\AppBundle\\Database\\Propel\\Model\\Map\\SongTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the song_id field.
     *
     * @var        int
     */
    protected $song_id;

    /**
     * The value for the album_id field.
     *
     * @var        int
     */
    protected $album_id;

    /**
     * The value for the title field.
     *
     * @var        string
     */
    protected $title;

    /**
     * The value for the play_count field.
     *
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $play_count;

    /**
     * @var        ChildAlbum
     */
    protected $aAlbum;

    /**
     * @var        \AppBundle\Database\Propel\Collection\ObjectCollection|ChildAccountSong[] Collection to store aggregation of ChildAccountSong objects.
     */
    protected $collAccountSongs;
    protected $collAccountSongsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var \AppBundle\Database\Propel\Collection\ObjectCollection|ChildAccountSong[]
     */
    protected $accountSongsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->play_count = 0;
    }

    /**
     * Initializes internal state of AppBundle\Database\Propel\Model\Base\Song object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Song</code> instance.  If
     * <code>obj</code> is an instance of <code>Song</code>, delegates to
     * <code>equals(Song)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Song The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [song_id] column value.
     *
     * @return int
     */
    public function getSongId()
    {
        return $this->song_id;
    }

    /**
     * Get the [album_id] column value.
     *
     * @return int
     */
    public function getAlbumId()
    {
        return $this->album_id;
    }

    /**
     * Get the [title] column value.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get the [play_count] column value.
     *
     * @return int
     */
    public function getPlayCount()
    {
        return $this->play_count;
    }

    /**
     * Set the value of [song_id] column.
     *
     * @param int $v new value
     * @return $this|\AppBundle\Database\Propel\Model\Song The current object (for fluent API support)
     */
    public function setSongId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->song_id !== $v) {
            $this->song_id = $v;
            $this->modifiedColumns[SongTableMap::COL_SONG_ID] = true;
        }

        return $this;
    } // setSongId()

    /**
     * Set the value of [album_id] column.
     *
     * @param int $v new value
     * @return $this|\AppBundle\Database\Propel\Model\Song The current object (for fluent API support)
     */
    public function setAlbumId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->album_id !== $v) {
            $this->album_id = $v;
            $this->modifiedColumns[SongTableMap::COL_ALBUM_ID] = true;
        }

        if ($this->aAlbum !== null && $this->aAlbum->getAlbumId() !== $v) {
            $this->aAlbum = null;
        }

        return $this;
    } // setAlbumId()

    /**
     * Set the value of [title] column.
     *
     * @param string $v new value
     * @return $this|\AppBundle\Database\Propel\Model\Song The current object (for fluent API support)
     */
    public function setTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->title !== $v) {
            $this->title = $v;
            $this->modifiedColumns[SongTableMap::COL_TITLE] = true;
        }

        return $this;
    } // setTitle()

    /**
     * Set the value of [play_count] column.
     *
     * @param int $v new value
     * @return $this|\AppBundle\Database\Propel\Model\Song The current object (for fluent API support)
     */
    public function setPlayCount($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->play_count !== $v) {
            $this->play_count = $v;
            $this->modifiedColumns[SongTableMap::COL_PLAY_COUNT] = true;
        }

        return $this;
    } // setPlayCount()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
            if ($this->play_count !== 0) {
                return false;
            }

        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : SongTableMap::translateFieldName('SongId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->song_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : SongTableMap::translateFieldName('AlbumId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->album_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : SongTableMap::translateFieldName('Title', TableMap::TYPE_PHPNAME, $indexType)];
            $this->title = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : SongTableMap::translateFieldName('PlayCount', TableMap::TYPE_PHPNAME, $indexType)];
            $this->play_count = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 4; // 4 = SongTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\AppBundle\\Database\\Propel\\Model\\Song'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aAlbum !== null && $this->album_id !== $this->aAlbum->getAlbumId()) {
            $this->aAlbum = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SongTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildSongQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aAlbum = null;
            $this->collAccountSongs = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Song::setDeleted()
     * @see Song::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(SongTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildSongQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(SongTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                SongTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aAlbum !== null) {
                if ($this->aAlbum->isModified() || $this->aAlbum->isNew()) {
                    $affectedRows += $this->aAlbum->save($con);
                }
                $this->setAlbum($this->aAlbum);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->accountSongsScheduledForDeletion !== null) {
                if (!$this->accountSongsScheduledForDeletion->isEmpty()) {
                    \AppBundle\Database\Propel\Model\AccountSongQuery::create()
                        ->filterByPrimaryKeys($this->accountSongsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->accountSongsScheduledForDeletion = null;
                }
            }

            if ($this->collAccountSongs !== null) {
                foreach ($this->collAccountSongs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[SongTableMap::COL_SONG_ID] = true;
        if (null !== $this->song_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . SongTableMap::COL_SONG_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(SongTableMap::COL_SONG_ID)) {
            $modifiedColumns[':p' . $index++]  = 'song_id';
        }
        if ($this->isColumnModified(SongTableMap::COL_ALBUM_ID)) {
            $modifiedColumns[':p' . $index++]  = 'album_id';
        }
        if ($this->isColumnModified(SongTableMap::COL_TITLE)) {
            $modifiedColumns[':p' . $index++]  = 'title';
        }
        if ($this->isColumnModified(SongTableMap::COL_PLAY_COUNT)) {
            $modifiedColumns[':p' . $index++]  = 'play_count';
        }

        $sql = sprintf(
            'INSERT INTO song (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'song_id':
                        $stmt->bindValue($identifier, $this->song_id, PDO::PARAM_INT);
                        break;
                    case 'album_id':
                        $stmt->bindValue($identifier, $this->album_id, PDO::PARAM_INT);
                        break;
                    case 'title':
                        $stmt->bindValue($identifier, $this->title, PDO::PARAM_STR);
                        break;
                    case 'play_count':
                        $stmt->bindValue($identifier, $this->play_count, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setSongId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = SongTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getSongId();
                break;
            case 1:
                return $this->getAlbumId();
                break;
            case 2:
                return $this->getTitle();
                break;
            case 3:
                return $this->getPlayCount();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Song'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Song'][$this->hashCode()] = true;
        $keys = SongTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getSongId(),
            $keys[1] => $this->getAlbumId(),
            $keys[2] => $this->getTitle(),
            $keys[3] => $this->getPlayCount(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aAlbum) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'album';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'album';
                        break;
                    default:
                        $key = 'Album';
                }

                $result[$key] = $this->aAlbum->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collAccountSongs) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'accountSongs';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'account_songs';
                        break;
                    default:
                        $key = 'AccountSongs';
                }

                $result[$key] = $this->collAccountSongs->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\AppBundle\Database\Propel\Model\Song
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = SongTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\AppBundle\Database\Propel\Model\Song
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setSongId($value);
                break;
            case 1:
                $this->setAlbumId($value);
                break;
            case 2:
                $this->setTitle($value);
                break;
            case 3:
                $this->setPlayCount($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = SongTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setSongId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setAlbumId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setTitle($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setPlayCount($arr[$keys[3]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\AppBundle\Database\Propel\Model\Song The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(SongTableMap::DATABASE_NAME);

        if ($this->isColumnModified(SongTableMap::COL_SONG_ID)) {
            $criteria->add(SongTableMap::COL_SONG_ID, $this->song_id);
        }
        if ($this->isColumnModified(SongTableMap::COL_ALBUM_ID)) {
            $criteria->add(SongTableMap::COL_ALBUM_ID, $this->album_id);
        }
        if ($this->isColumnModified(SongTableMap::COL_TITLE)) {
            $criteria->add(SongTableMap::COL_TITLE, $this->title);
        }
        if ($this->isColumnModified(SongTableMap::COL_PLAY_COUNT)) {
            $criteria->add(SongTableMap::COL_PLAY_COUNT, $this->play_count);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildSongQuery::create();
        $criteria->add(SongTableMap::COL_SONG_ID, $this->song_id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getSongId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getSongId();
    }

    /**
     * Generic method to set the primary key (song_id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setSongId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getSongId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \AppBundle\Database\Propel\Model\Song (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setAlbumId($this->getAlbumId());
        $copyObj->setTitle($this->getTitle());
        $copyObj->setPlayCount($this->getPlayCount());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getAccountSongs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAccountSong($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setSongId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \AppBundle\Database\Propel\Model\Song Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildAlbum object.
     *
     * @param  ChildAlbum $v
     * @return $this|\AppBundle\Database\Propel\Model\Song The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAlbum(ChildAlbum $v = null)
    {
        if ($v === null) {
            $this->setAlbumId(NULL);
        } else {
            $this->setAlbumId($v->getAlbumId());
        }

        $this->aAlbum = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildAlbum object, it will not be re-added.
        if ($v !== null) {
            $v->addSong($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildAlbum object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildAlbum The associated ChildAlbum object.
     * @throws PropelException
     */
    public function getAlbum(ConnectionInterface $con = null)
    {
        if ($this->aAlbum === null && ($this->album_id != 0)) {
            $this->aAlbum = ChildAlbumQuery::create()->findPk($this->album_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAlbum->addSongs($this);
             */
        }

        return $this->aAlbum;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('AccountSong' == $relationName) {
            $this->initAccountSongs();
            return;
        }
    }

    /**
     * Clears out the collAccountSongs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addAccountSongs()
     */
    public function clearAccountSongs()
    {
        $this->collAccountSongs = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collAccountSongs collection loaded partially.
     */
    public function resetPartialAccountSongs($v = true)
    {
        $this->collAccountSongsPartial = $v;
    }

    /**
     * Initializes the collAccountSongs collection.
     *
     * By default this just sets the collAccountSongs collection to an empty array (like clearcollAccountSongs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAccountSongs($overrideExisting = true)
    {
        if (null !== $this->collAccountSongs && !$overrideExisting) {
            return;
        }

        $collectionClassName = AccountSongTableMap::getTableMap()->getCollectionClassName();

        $this->collAccountSongs = new $collectionClassName;
        $this->collAccountSongs->setModel('\AppBundle\Database\Propel\Model\AccountSong');
    }

    /**
     * Gets an array of ChildAccountSong objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSong is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return \AppBundle\Database\Propel\Collection\ObjectCollection|ChildAccountSong[] List of ChildAccountSong objects
     * @throws PropelException
     */
    public function getAccountSongs(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collAccountSongsPartial && !$this->isNew();
        if (null === $this->collAccountSongs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAccountSongs) {
                // return empty collection
                $this->initAccountSongs();
            } else {
                $collAccountSongs = ChildAccountSongQuery::create(null, $criteria)
                    ->filterBySong($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collAccountSongsPartial && count($collAccountSongs)) {
                        $this->initAccountSongs(false);

                        foreach ($collAccountSongs as $obj) {
                            if (false == $this->collAccountSongs->contains($obj)) {
                                $this->collAccountSongs->append($obj);
                            }
                        }

                        $this->collAccountSongsPartial = true;
                    }

                    return $collAccountSongs;
                }

                if ($partial && $this->collAccountSongs) {
                    foreach ($this->collAccountSongs as $obj) {
                        if ($obj->isNew()) {
                            $collAccountSongs[] = $obj;
                        }
                    }
                }

                $this->collAccountSongs = $collAccountSongs;
                $this->collAccountSongsPartial = false;
            }
        }

        return $this->collAccountSongs;
    }

    /**
     * Sets a collection of ChildAccountSong objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $accountSongs A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSong The current object (for fluent API support)
     */
    public function setAccountSongs(Collection $accountSongs, ConnectionInterface $con = null)
    {
        /** @var ChildAccountSong[] $accountSongsToDelete */
        $accountSongsToDelete = $this->getAccountSongs(new Criteria(), $con)->diff($accountSongs);


        $this->accountSongsScheduledForDeletion = $accountSongsToDelete;

        foreach ($accountSongsToDelete as $accountSongRemoved) {
            $accountSongRemoved->setSong(null);
        }

        $this->collAccountSongs = null;
        foreach ($accountSongs as $accountSong) {
            $this->addAccountSong($accountSong);
        }

        $this->collAccountSongs = $accountSongs;
        $this->collAccountSongsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related AccountSong objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related AccountSong objects.
     * @throws PropelException
     */
    public function countAccountSongs(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collAccountSongsPartial && !$this->isNew();
        if (null === $this->collAccountSongs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAccountSongs) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAccountSongs());
            }

            $query = ChildAccountSongQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySong($this)
                ->count($con);
        }

        return count($this->collAccountSongs);
    }

    /**
     * Method called to associate a ChildAccountSong object to this object
     * through the ChildAccountSong foreign key attribute.
     *
     * @param  ChildAccountSong $l ChildAccountSong
     * @return $this|\AppBundle\Database\Propel\Model\Song The current object (for fluent API support)
     */
    public function addAccountSong(ChildAccountSong $l)
    {
        if ($this->collAccountSongs === null) {
            $this->initAccountSongs();
            $this->collAccountSongsPartial = true;
        }

        if (!$this->collAccountSongs->contains($l)) {
            $this->doAddAccountSong($l);

            if ($this->accountSongsScheduledForDeletion and $this->accountSongsScheduledForDeletion->contains($l)) {
                $this->accountSongsScheduledForDeletion->remove($this->accountSongsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildAccountSong $accountSong The ChildAccountSong object to add.
     */
    protected function doAddAccountSong(ChildAccountSong $accountSong)
    {
        $this->collAccountSongs[]= $accountSong;
        $accountSong->setSong($this);
    }

    /**
     * @param  ChildAccountSong $accountSong The ChildAccountSong object to remove.
     * @return $this|ChildSong The current object (for fluent API support)
     */
    public function removeAccountSong(ChildAccountSong $accountSong)
    {
        if ($this->getAccountSongs()->contains($accountSong)) {
            $pos = $this->collAccountSongs->search($accountSong);
            $this->collAccountSongs->remove($pos);
            if (null === $this->accountSongsScheduledForDeletion) {
                $this->accountSongsScheduledForDeletion = clone $this->collAccountSongs;
                $this->accountSongsScheduledForDeletion->clear();
            }
            $this->accountSongsScheduledForDeletion[]= clone $accountSong;
            $accountSong->setSong(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Song is new, it will return
     * an empty collection; or if this Song has previously
     * been saved, it will retrieve related AccountSongs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Song.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return \AppBundle\Database\Propel\Collection\ObjectCollection|ChildAccountSong[] List of ChildAccountSong objects
     */
    public function getAccountSongsJoinAccount(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildAccountSongQuery::create(null, $criteria);
        $query->joinWith('Account', $joinBehavior);

        return $this->getAccountSongs($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aAlbum) {
            $this->aAlbum->removeSong($this);
        }
        $this->song_id = null;
        $this->album_id = null;
        $this->title = null;
        $this->play_count = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collAccountSongs) {
                foreach ($this->collAccountSongs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collAccountSongs = null;
        $this->aAlbum = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(SongTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preSave')) {
            return parent::preSave($con);
        }
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postSave')) {
            parent::postSave($con);
        }
    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preInsert')) {
            return parent::preInsert($con);
        }
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postInsert')) {
            parent::postInsert($con);
        }
    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preUpdate')) {
            return parent::preUpdate($con);
        }
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postUpdate')) {
            parent::postUpdate($con);
        }
    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preDelete')) {
            return parent::preDelete($con);
        }
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postDelete')) {
            parent::postDelete($con);
        }
    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
