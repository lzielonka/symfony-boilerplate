<?php

namespace AppBundle\Database\Propel\Model\Base;

use \Exception;
use \PDO;
use AppBundle\Database\Propel\Model\AccountBook as ChildAccountBook;
use AppBundle\Database\Propel\Model\AccountBookQuery as ChildAccountBookQuery;
use AppBundle\Database\Propel\Model\Book as ChildBook;
use AppBundle\Database\Propel\Model\BookQuery as ChildBookQuery;
use AppBundle\Database\Propel\Model\Writer as ChildWriter;
use AppBundle\Database\Propel\Model\WriterQuery as ChildWriterQuery;
use AppBundle\Database\Propel\Model\Map\AccountBookTableMap;
use AppBundle\Database\Propel\Model\Map\BookTableMap;
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
 * Base class that represents a row from the 'book' table.
 *
 *
 *
 * @package    propel.generator.src.AppBundle.Database.Propel.Model.Base
 */
abstract class Book implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\AppBundle\\Database\\Propel\\Model\\Map\\BookTableMap';


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
     * The value for the book_id field.
     *
     * @var        int
     */
    protected $book_id;

    /**
     * The value for the writer_id field.
     *
     * @var        int
     */
    protected $writer_id;

    /**
     * The value for the title field.
     *
     * @var        string
     */
    protected $title;

    /**
     * The value for the isbn field.
     *
     * @var        string
     */
    protected $isbn;

    /**
     * @var        ChildWriter
     */
    protected $aWriter;

    /**
     * @var        \AppBundle\Database\Propel\Collection\ObjectCollection|ChildAccountBook[] Collection to store aggregation of ChildAccountBook objects.
     */
    protected $collAccountBooks;
    protected $collAccountBooksPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var \AppBundle\Database\Propel\Collection\ObjectCollection|ChildAccountBook[]
     */
    protected $accountBooksScheduledForDeletion = null;

    /**
     * Initializes internal state of AppBundle\Database\Propel\Model\Base\Book object.
     */
    public function __construct()
    {
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
     * Compares this with another <code>Book</code> instance.  If
     * <code>obj</code> is an instance of <code>Book</code>, delegates to
     * <code>equals(Book)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Book The current object, for fluid interface
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
     * Get the [book_id] column value.
     *
     * @return int
     */
    public function getBookId()
    {
        return $this->book_id;
    }

    /**
     * Get the [writer_id] column value.
     *
     * @return int
     */
    public function getWriterId()
    {
        return $this->writer_id;
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
     * Get the [isbn] column value.
     *
     * @return string
     */
    public function getIsbn()
    {
        return $this->isbn;
    }

    /**
     * Set the value of [book_id] column.
     *
     * @param int $v new value
     * @return $this|\AppBundle\Database\Propel\Model\Book The current object (for fluent API support)
     */
    public function setBookId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->book_id !== $v) {
            $this->book_id = $v;
            $this->modifiedColumns[BookTableMap::COL_BOOK_ID] = true;
        }

        return $this;
    } // setBookId()

    /**
     * Set the value of [writer_id] column.
     *
     * @param int $v new value
     * @return $this|\AppBundle\Database\Propel\Model\Book The current object (for fluent API support)
     */
    public function setWriterId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->writer_id !== $v) {
            $this->writer_id = $v;
            $this->modifiedColumns[BookTableMap::COL_WRITER_ID] = true;
        }

        if ($this->aWriter !== null && $this->aWriter->getWriterId() !== $v) {
            $this->aWriter = null;
        }

        return $this;
    } // setWriterId()

    /**
     * Set the value of [title] column.
     *
     * @param string $v new value
     * @return $this|\AppBundle\Database\Propel\Model\Book The current object (for fluent API support)
     */
    public function setTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->title !== $v) {
            $this->title = $v;
            $this->modifiedColumns[BookTableMap::COL_TITLE] = true;
        }

        return $this;
    } // setTitle()

    /**
     * Set the value of [isbn] column.
     *
     * @param string $v new value
     * @return $this|\AppBundle\Database\Propel\Model\Book The current object (for fluent API support)
     */
    public function setIsbn($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->isbn !== $v) {
            $this->isbn = $v;
            $this->modifiedColumns[BookTableMap::COL_ISBN] = true;
        }

        return $this;
    } // setIsbn()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : BookTableMap::translateFieldName('BookId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->book_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : BookTableMap::translateFieldName('WriterId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->writer_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : BookTableMap::translateFieldName('Title', TableMap::TYPE_PHPNAME, $indexType)];
            $this->title = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : BookTableMap::translateFieldName('Isbn', TableMap::TYPE_PHPNAME, $indexType)];
            $this->isbn = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 4; // 4 = BookTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\AppBundle\\Database\\Propel\\Model\\Book'), 0, $e);
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
        if ($this->aWriter !== null && $this->writer_id !== $this->aWriter->getWriterId()) {
            $this->aWriter = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(BookTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildBookQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aWriter = null;
            $this->collAccountBooks = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Book::setDeleted()
     * @see Book::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(BookTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildBookQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(BookTableMap::DATABASE_NAME);
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
                BookTableMap::addInstanceToPool($this);
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

            if ($this->aWriter !== null) {
                if ($this->aWriter->isModified() || $this->aWriter->isNew()) {
                    $affectedRows += $this->aWriter->save($con);
                }
                $this->setWriter($this->aWriter);
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

            if ($this->accountBooksScheduledForDeletion !== null) {
                if (!$this->accountBooksScheduledForDeletion->isEmpty()) {
                    \AppBundle\Database\Propel\Model\AccountBookQuery::create()
                        ->filterByPrimaryKeys($this->accountBooksScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->accountBooksScheduledForDeletion = null;
                }
            }

            if ($this->collAccountBooks !== null) {
                foreach ($this->collAccountBooks as $referrerFK) {
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

        $this->modifiedColumns[BookTableMap::COL_BOOK_ID] = true;
        if (null !== $this->book_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . BookTableMap::COL_BOOK_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(BookTableMap::COL_BOOK_ID)) {
            $modifiedColumns[':p' . $index++]  = 'book_id';
        }
        if ($this->isColumnModified(BookTableMap::COL_WRITER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'writer_id';
        }
        if ($this->isColumnModified(BookTableMap::COL_TITLE)) {
            $modifiedColumns[':p' . $index++]  = 'title';
        }
        if ($this->isColumnModified(BookTableMap::COL_ISBN)) {
            $modifiedColumns[':p' . $index++]  = 'ISBN';
        }

        $sql = sprintf(
            'INSERT INTO book (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'book_id':
                        $stmt->bindValue($identifier, $this->book_id, PDO::PARAM_INT);
                        break;
                    case 'writer_id':
                        $stmt->bindValue($identifier, $this->writer_id, PDO::PARAM_INT);
                        break;
                    case 'title':
                        $stmt->bindValue($identifier, $this->title, PDO::PARAM_STR);
                        break;
                    case 'ISBN':
                        $stmt->bindValue($identifier, $this->isbn, PDO::PARAM_STR);
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
        $this->setBookId($pk);

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
        $pos = BookTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getBookId();
                break;
            case 1:
                return $this->getWriterId();
                break;
            case 2:
                return $this->getTitle();
                break;
            case 3:
                return $this->getIsbn();
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

        if (isset($alreadyDumpedObjects['Book'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Book'][$this->hashCode()] = true;
        $keys = BookTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getBookId(),
            $keys[1] => $this->getWriterId(),
            $keys[2] => $this->getTitle(),
            $keys[3] => $this->getIsbn(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aWriter) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'writer';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'writer';
                        break;
                    default:
                        $key = 'Writer';
                }

                $result[$key] = $this->aWriter->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collAccountBooks) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'accountBooks';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'account_books';
                        break;
                    default:
                        $key = 'AccountBooks';
                }

                $result[$key] = $this->collAccountBooks->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\AppBundle\Database\Propel\Model\Book
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = BookTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\AppBundle\Database\Propel\Model\Book
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setBookId($value);
                break;
            case 1:
                $this->setWriterId($value);
                break;
            case 2:
                $this->setTitle($value);
                break;
            case 3:
                $this->setIsbn($value);
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
        $keys = BookTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setBookId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setWriterId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setTitle($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setIsbn($arr[$keys[3]]);
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
     * @return $this|\AppBundle\Database\Propel\Model\Book The current object, for fluid interface
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
        $criteria = new Criteria(BookTableMap::DATABASE_NAME);

        if ($this->isColumnModified(BookTableMap::COL_BOOK_ID)) {
            $criteria->add(BookTableMap::COL_BOOK_ID, $this->book_id);
        }
        if ($this->isColumnModified(BookTableMap::COL_WRITER_ID)) {
            $criteria->add(BookTableMap::COL_WRITER_ID, $this->writer_id);
        }
        if ($this->isColumnModified(BookTableMap::COL_TITLE)) {
            $criteria->add(BookTableMap::COL_TITLE, $this->title);
        }
        if ($this->isColumnModified(BookTableMap::COL_ISBN)) {
            $criteria->add(BookTableMap::COL_ISBN, $this->isbn);
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
        $criteria = ChildBookQuery::create();
        $criteria->add(BookTableMap::COL_BOOK_ID, $this->book_id);

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
        $validPk = null !== $this->getBookId();

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
        return $this->getBookId();
    }

    /**
     * Generic method to set the primary key (book_id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setBookId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getBookId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \AppBundle\Database\Propel\Model\Book (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setWriterId($this->getWriterId());
        $copyObj->setTitle($this->getTitle());
        $copyObj->setIsbn($this->getIsbn());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getAccountBooks() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAccountBook($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setBookId(NULL); // this is a auto-increment column, so set to default value
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
     * @return \AppBundle\Database\Propel\Model\Book Clone of current object.
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
     * Declares an association between this object and a ChildWriter object.
     *
     * @param  ChildWriter $v
     * @return $this|\AppBundle\Database\Propel\Model\Book The current object (for fluent API support)
     * @throws PropelException
     */
    public function setWriter(ChildWriter $v = null)
    {
        if ($v === null) {
            $this->setWriterId(NULL);
        } else {
            $this->setWriterId($v->getWriterId());
        }

        $this->aWriter = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildWriter object, it will not be re-added.
        if ($v !== null) {
            $v->addBook($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildWriter object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildWriter The associated ChildWriter object.
     * @throws PropelException
     */
    public function getWriter(ConnectionInterface $con = null)
    {
        if ($this->aWriter === null && ($this->writer_id != 0)) {
            $this->aWriter = ChildWriterQuery::create()->findPk($this->writer_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aWriter->addBooks($this);
             */
        }

        return $this->aWriter;
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
        if ('AccountBook' == $relationName) {
            $this->initAccountBooks();
            return;
        }
    }

    /**
     * Clears out the collAccountBooks collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addAccountBooks()
     */
    public function clearAccountBooks()
    {
        $this->collAccountBooks = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collAccountBooks collection loaded partially.
     */
    public function resetPartialAccountBooks($v = true)
    {
        $this->collAccountBooksPartial = $v;
    }

    /**
     * Initializes the collAccountBooks collection.
     *
     * By default this just sets the collAccountBooks collection to an empty array (like clearcollAccountBooks());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAccountBooks($overrideExisting = true)
    {
        if (null !== $this->collAccountBooks && !$overrideExisting) {
            return;
        }

        $collectionClassName = AccountBookTableMap::getTableMap()->getCollectionClassName();

        $this->collAccountBooks = new $collectionClassName;
        $this->collAccountBooks->setModel('\AppBundle\Database\Propel\Model\AccountBook');
    }

    /**
     * Gets an array of ChildAccountBook objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildBook is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return \AppBundle\Database\Propel\Collection\ObjectCollection|ChildAccountBook[] List of ChildAccountBook objects
     * @throws PropelException
     */
    public function getAccountBooks(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collAccountBooksPartial && !$this->isNew();
        if (null === $this->collAccountBooks || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAccountBooks) {
                // return empty collection
                $this->initAccountBooks();
            } else {
                $collAccountBooks = ChildAccountBookQuery::create(null, $criteria)
                    ->filterByBook($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collAccountBooksPartial && count($collAccountBooks)) {
                        $this->initAccountBooks(false);

                        foreach ($collAccountBooks as $obj) {
                            if (false == $this->collAccountBooks->contains($obj)) {
                                $this->collAccountBooks->append($obj);
                            }
                        }

                        $this->collAccountBooksPartial = true;
                    }

                    return $collAccountBooks;
                }

                if ($partial && $this->collAccountBooks) {
                    foreach ($this->collAccountBooks as $obj) {
                        if ($obj->isNew()) {
                            $collAccountBooks[] = $obj;
                        }
                    }
                }

                $this->collAccountBooks = $collAccountBooks;
                $this->collAccountBooksPartial = false;
            }
        }

        return $this->collAccountBooks;
    }

    /**
     * Sets a collection of ChildAccountBook objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $accountBooks A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildBook The current object (for fluent API support)
     */
    public function setAccountBooks(Collection $accountBooks, ConnectionInterface $con = null)
    {
        /** @var ChildAccountBook[] $accountBooksToDelete */
        $accountBooksToDelete = $this->getAccountBooks(new Criteria(), $con)->diff($accountBooks);


        $this->accountBooksScheduledForDeletion = $accountBooksToDelete;

        foreach ($accountBooksToDelete as $accountBookRemoved) {
            $accountBookRemoved->setBook(null);
        }

        $this->collAccountBooks = null;
        foreach ($accountBooks as $accountBook) {
            $this->addAccountBook($accountBook);
        }

        $this->collAccountBooks = $accountBooks;
        $this->collAccountBooksPartial = false;

        return $this;
    }

    /**
     * Returns the number of related AccountBook objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related AccountBook objects.
     * @throws PropelException
     */
    public function countAccountBooks(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collAccountBooksPartial && !$this->isNew();
        if (null === $this->collAccountBooks || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAccountBooks) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAccountBooks());
            }

            $query = ChildAccountBookQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByBook($this)
                ->count($con);
        }

        return count($this->collAccountBooks);
    }

    /**
     * Method called to associate a ChildAccountBook object to this object
     * through the ChildAccountBook foreign key attribute.
     *
     * @param  ChildAccountBook $l ChildAccountBook
     * @return $this|\AppBundle\Database\Propel\Model\Book The current object (for fluent API support)
     */
    public function addAccountBook(ChildAccountBook $l)
    {
        if ($this->collAccountBooks === null) {
            $this->initAccountBooks();
            $this->collAccountBooksPartial = true;
        }

        if (!$this->collAccountBooks->contains($l)) {
            $this->doAddAccountBook($l);

            if ($this->accountBooksScheduledForDeletion and $this->accountBooksScheduledForDeletion->contains($l)) {
                $this->accountBooksScheduledForDeletion->remove($this->accountBooksScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildAccountBook $accountBook The ChildAccountBook object to add.
     */
    protected function doAddAccountBook(ChildAccountBook $accountBook)
    {
        $this->collAccountBooks[]= $accountBook;
        $accountBook->setBook($this);
    }

    /**
     * @param  ChildAccountBook $accountBook The ChildAccountBook object to remove.
     * @return $this|ChildBook The current object (for fluent API support)
     */
    public function removeAccountBook(ChildAccountBook $accountBook)
    {
        if ($this->getAccountBooks()->contains($accountBook)) {
            $pos = $this->collAccountBooks->search($accountBook);
            $this->collAccountBooks->remove($pos);
            if (null === $this->accountBooksScheduledForDeletion) {
                $this->accountBooksScheduledForDeletion = clone $this->collAccountBooks;
                $this->accountBooksScheduledForDeletion->clear();
            }
            $this->accountBooksScheduledForDeletion[]= clone $accountBook;
            $accountBook->setBook(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Book is new, it will return
     * an empty collection; or if this Book has previously
     * been saved, it will retrieve related AccountBooks from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Book.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return \AppBundle\Database\Propel\Collection\ObjectCollection|ChildAccountBook[] List of ChildAccountBook objects
     */
    public function getAccountBooksJoinAccount(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildAccountBookQuery::create(null, $criteria);
        $query->joinWith('Account', $joinBehavior);

        return $this->getAccountBooks($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aWriter) {
            $this->aWriter->removeBook($this);
        }
        $this->book_id = null;
        $this->writer_id = null;
        $this->title = null;
        $this->isbn = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
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
            if ($this->collAccountBooks) {
                foreach ($this->collAccountBooks as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collAccountBooks = null;
        $this->aWriter = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(BookTableMap::DEFAULT_STRING_FORMAT);
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
