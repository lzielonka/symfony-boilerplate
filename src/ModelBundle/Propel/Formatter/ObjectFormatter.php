<?php

namespace ModelBundle\Propel\Formatter;

use ModelBundle\Propel\Behavior\ObjectFormatterBehavior;

class ObjectFormatter extends \Propel\Runtime\Formatter\ObjectFormatter
{
    public function getCollectionClassName()
    {
        return ObjectFormatterBehavior::CUSTOM_OBJECT_COLLECTION_NAMESPACE;
    }
}