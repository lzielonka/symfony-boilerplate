<?php

namespace ModelBundle\Propel\Behavior;

use Propel\Generator\Model\Behavior;

class ObjectFormatterBehavior extends Behavior
{
    public const DEFAULT_FORMATTER_NAMESPACE = '\\ModelBundle\\Propel\\Formatter\\ObjectFormatter';
    public const CUSTOM_OBJECT_COLLECTION_NAMESPACE = '\\ModelBundle\\Propel\\Collection\\ObjectCollection';

    public function queryAttributes()
    {
        return "protected \$defaultFormatterClass = '". self::DEFAULT_FORMATTER_NAMESPACE . "';";
    }

    /**
     * @param \string $script
     */
    public function queryFilter(&$script)
    {
        $script = preg_replace('/ObjectCollection/i', self::CUSTOM_OBJECT_COLLECTION_NAMESPACE, $script);
//		$script = preg_replace('/@return\s+PropelObjectCollection\b/i', '@return \System\ModelBundle\Propel\Formatter\ObjectFormatter|PropelObjectCollection', $script);
    }

    public function objectFilter(&$script)
    {
        $script = preg_replace('/new ObjectCollection\;\b/i', 'use \\' . self::CUSTOM_OBJECT_COLLECTION_NAMESPACE, $script);
        $script = preg_replace('/ObjectCollection/i', self::CUSTOM_OBJECT_COLLECTION_NAMESPACE, $script);
//		$script = preg_replace('/@return\s+PropelObjectCollection\b/i', '@return \\' . $collectionClass . '', $script);
//		$script = preg_replace('/@var\s+PropelObjectCollection\b/i', '@var \\' . $collectionClass . '', $script);
//		$script = preg_replace('/new\s+PropelObjectCollection\b/i', 'new \\' . $collectionClass . '', $script);
    }
}