<?php

namespace Tests;

class PrivateAccessTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @param mixed $object
     * @param string $methodName
     * @param array $arguments
     * @return mixed
     * @throws \ReflectionException
     */
    public static function executePrivateMethod($object, $methodName, $arguments = []) {
        $method = self::getPrivateMethodOfClass($methodName, get_class($object));

        return $method->invokeArgs($object, $arguments);
    }

    /**
     * @param mixed $object
     * @param $propertyName
     * @return mixed
     * @throws \ReflectionException
     */
    public static function getPrivatePropertyValue($object, $propertyName) {
        $property = self::getPrivatePropertyOfClass($propertyName, get_class($object));

        return $property->getValue($object);
    }

    /**
     * @param mixed $object
     * @param string $propertyName
     * @param mixed $value
     * @return mixed
     * @throws \ReflectionException
     */
    public static function setPrivatePropertyValue($object, $propertyName, $value) {
        $property = self::getPrivatePropertyOfClass($propertyName, get_class($object));

        return $property->setValue($object, $value);
    }

    /**
     * @param $methodName
     * @param $className
     * @return \ReflectionMethod
     * @throws \ReflectionException
     */
    private static function getPrivateMethodOfClass($methodName, $className) {
        $class = new \ReflectionClass($className);
        $method = $class->getMethod($methodName);
        $method->setAccessible(true);

        return $method;
    }

    /**
     * @param string $propertyName
     * @param string $className
     * @return mixed
     * @throws \ReflectionException
     */
    private static function getPrivatePropertyOfClass($propertyName, $className) {
        $class = new \ReflectionClass($className);
        $property = $class->getProperty($propertyName);
        $property->setAccessible(true);

        return $property;
    }
}