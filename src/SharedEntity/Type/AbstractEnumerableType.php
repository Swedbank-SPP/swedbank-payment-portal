<?php

namespace SwedbankPaymentPortal\SharedEntity\Type;

/**
 * Class EnumerableType is use for system types which has a predefined list of options.
 *
 * Please extend this class to add new enumerable types to the system.
 *
 * These types can be registered to EnumerableDataSource and be exposed to SmartClient frontend.
 *
 * You need to extend this method and implement new `public static final` methods which return a specific type object.
 * Example:
 *
 *  class OrderType extends EnumerableType {
 *
 *     public static final function Export()
 *     {
 *          return self::get(1, 'export');
 *     }
 *
 *     public static final function Customer()
 *     {
 *          return self::get(2, 'customer');
 *     }
 *     // no other methods is needed. all methods which is marked as `final` will be enumerated.
 *     // you can get all avaialble types using OrderType::enum()
 *     // also you can use  `EnumerableDataSource` to publish all available options to SmartClient.
 *  }
 *
 *
 * Also in Entities you can annotate a a integer field with options={"enum":"fullclassname"} to get full automatic
 * title display for SmartClient ListGrid component.
 * e.g.
 *     /**
 *      * @[removethis]ORM\Column(type="integer", nullable=true, options={"enum":"System\Type\OrderType"})
 *      * private $orderType;
 *
 * Then you bind this entity with DoctrineDataSource you'll get automatic title generation.
 *
 *
 *
 *
 * @see EnumerableDataSource for more details
 *
 *
 * @package System\Type
 */
abstract class AbstractEnumerableType
{
    /**
     * @var array Of array of instances.
     */
    private static $instances = [];

    /**
     * Static method which returns all available types.
     *
     * @return AbstractEnumerableType[]
     */
    public static function enum()
    {
        $reflection = new \ReflectionClass(get_called_class());
        $finalMethods = $reflection->getMethods(\ReflectionMethod::IS_FINAL);

        $return = [];

        foreach ($finalMethods as $key => $method) {
            $return[] = $method->invoke(null);
        }

        return $return;
    }

    /**
     * Static method which returns a type object from specified id.
     *
     * @param mixed $id
     *
     * @return $this
     */
    public static function fromId($id)
    {
        foreach (self::enum() as $value) {
            if ($value->id() === $id) {
                return $value;
            }
        }

        return null;
    }

    /**
     * Returns enumerate.
     *
     * @param mixed $id
     *
     * @return $this
     */
    protected static function get($id)
    {
        $classKey = crc32(get_called_class()) & 0xFFFFFF;

        if (!isset(self::$instances[$classKey])) {
            self::$instances[$classKey] = [];
        }

        $instances =& self::$instances[$classKey];

        $key = $id;

        if (!isset($instances[$key])) {
            $reflection = new \ReflectionClass(get_called_class());
            $instance   = $reflection->newInstanceWithoutConstructor();

            $refConstructor = $reflection->getConstructor();
            $refConstructor->setAccessible(true);
            $refConstructor->invoke($instance, $id);

            $instances[$key] = $instance;
        }

        return $instances[$key];
    }

    /**
     * @var int
     */
    private $id;

    /**
     * @param mixed $id
     */
    protected function __construct($id = null)
    {
        $this->id = $id;
    }

    /**
     * Returns id.
     *
     * @return mixed
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * Assigns id if it exists.
     *
     * @param mixed $id
     */
    protected function assignId($id)
    {
        $enumObject = $this->fromId($id);

        if (!$enumObject) {
            throw new \RuntimeException("Unknown value '{$id}' was given for enum " . get_class($this));
        }

        $this->id = $enumObject->id();
    }
}
