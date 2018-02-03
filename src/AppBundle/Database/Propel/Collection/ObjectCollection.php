<?php

namespace AppBundle\Database\Propel\Collection;

use Propel\Runtime\Collection\ObjectCollection as PropelCollection;

class ObjectCollection extends PropelCollection
{
    /**
     * Filter collection by callback function, same way as array_filter function
     *
     * @param $callback
     * @return ObjectCollection
     */
    public function filterByCallback($callback)
    {
        $ret = new self();
        $ret->setModel($this->getModel());
        $formatter = $this->getFormatter();

        if ($formatter) {
            $ret->setFormatter($formatter);
        }

        $ret->setData(array_filter($this->getData(), $callback));

        return $ret;
    }

    /**
     * array_walk for collection
     *
     * @param callable $callback
     * @return array
     */
    public function walk($callback)
    {
        $data = $this->getData();
        array_walk($data, $callback);

        return $data;
    }

    /** @param $fieldName
     * @return int
     */
    public function sumBy($fieldName)
    {
        $sum = 0;
        $this->walk(function ($object) use ($fieldName, &$sum) {
            if (method_exists($object, 'get' . $fieldName)) {
                $sum += $object->{'get' . $fieldName}();
            }
        });

        return $sum;
    }

    /**
     * array_map for collection
     *
     * @param callable $callback
     * @return array
     */
    public function map($callback)
    {
        return array_map($callback, $this->getData());
    }

    /**
     * @param $fieldName string method name, column name or virtual column name
     * @param $value
     * @return ObjectCollection filtered objects
     */
    public function filterByField($fieldName, $value)
    {
        return $this->filterByCallback(function ($element) use ($fieldName, $value) {
            if (method_exists($element, $fieldName)) {
                return $element->$fieldName() == $value;
            }

            if (method_exists($element, $method = 'get' . $fieldName)) {
                return $element->$method() == $value;
            }

            if ($element->hasVirtualColumn($fieldName)) {
                return $element->getVirtualColumn($fieldName) == $value;
            }

            return false;
        });
    }

    /**
     * @param $objectMethodName
     *
     * @return $this
     */
    public function sortBy($objectMethodName)
    {
        if (strpos($objectMethodName, 'get') !== 0) {
            $objectMethodName = 'get' . ucfirst($objectMethodName);
        }

        $iterator = $this->getIterator();
        $iterator->uasort(function ($a, $b) use ($objectMethodName) {
            if ($a->$objectMethodName() == $b->$objectMethodName()) {
                return 0;
            }

            return $a->$objectMethodName() < $b->$objectMethodName() ? 1 : -1;
        });

        $this->setData(iterator_to_array($iterator));

        return $this;
    }

    /**
     * @param string $keyColumn
     * @param bool $usePrefix
     * @param array|null $columnParams
     *
     * @return array
     */
    public function getArrayCopy($keyColumn = null, $usePrefix = false, $columnParams = null)
    {
        $tmpResult = parent::getArrayCopy($keyColumn, $usePrefix);
        if (false == count($tmpResult) || null === $columnParams) {
            return $tmpResult;
        }

        $result = [];
        $keyGetterMethod = 'get' . $keyColumn;

        foreach ($tmpResult as $item) {
            $key = call_user_func_array(array($item, $keyGetterMethod), $columnParams);
            $result[$key] = $item;
        }

        return $result;
    }

    /**
     * Extracts data from collection by callback
     *
     * @param $callback
     * @return ObjectCollection
     */
    public function extract($callback)
    {
        $ret = new self();
        foreach ($this->getData() as $d) {
            $ret->append($callback($d));
        }

        return $ret;
    }

    /**
     * Extracts data from collection by field name
     *
     * @param $field
     * @return ObjectCollection
     */
    public function extractField($field)
    {
        return $this->extract(function ($e) use ($field) {
            return $e->$field();
        });
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return 'ObjectCollection(' . $this->count() . ')';
    }

    /**
     * @return ObjectCollection
     */
    public function shuffle()
    {
        $same = new self;
        $same->setModel($this->getModel());
        $shuffled = $this->getData();
        shuffle($shuffled);
        $same->setData($shuffled);

        return $same;
    }

    /**
     * @param $offset
     * @param null $length
     * @return ObjectCollection
     */
    public function slice($offset, $length = null)
    {
        $same = new self;
        $same->setModel($this->getModel());
        $data = $this->getData();
        $data = array_slice($data, $offset, $length);
        $same->setData($data);

        return $same;
    }

    /**
     * Merge specified collection to current collection
     *
     * @param PropelCollection $collection
     *
     * @return ObjectCollection
     */
    public function mergeCollection(PropelCollection $collection)
    {
        foreach ($collection as $i) {
            $this->append($i);
        }

        return $this;
    }
}