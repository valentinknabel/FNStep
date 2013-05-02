<?php
/**
 * Created by JetBrains PhpStorm.
 * User: valentinknabel
 * Date: 02.05.13
 * Time: 10:04
 * To change this template use File | Settings | File Templates.
 */

namespace FNFoundation;


use Exception;

class FNProxy extends FNObject {
    private $object;

    public static function objectOf(FNProxy $proxy) {
        return $proxy->object;
    }

    //!additions
    /**
     * This method is declared as protected to disallow the use of the new-operator outside of this class and its subclasses.
     */
    protected function __construct($object = NULL)
    {
        $this->object = $object;
    }

    /**
     * Implement this method instead of __call.
     * @arg FNString $function
     * @arg array $arguments
     * @param FNString $function
     * @param array $arguments
     * @throws FNUnresolvedMethod
     * @return mixed
     */
    public function unresolvedMethod(FNString $function, /** @noinspection PhpUnusedParameterInspection */
                                     array $arguments)
    {
        try {
            return con(call_user_func_array(array($this->object, $function->value()), c($arguments)));
        } catch (Exception $exception) {
            throw new FNUnresolvedMethod($function);
        }
    }

    /**
     * Implement this method instead of __get. This method makes it possible to call methods without arguments without using the brackets.
     * @arg FNString $property
     * @param FNString $property
     * @throws FNUnresolvedProperty
     * @return mixed
     */
    public function unresolvedProperty(FNString $property)
    {
        try {
            if(isset($this->object->{$property->value()}))
                return con($this->object->{$property->value()});
            return con($this->callMethod($property));
        } catch (FNUnresolvedMethod $exception) {
            throw new FNUnresolvedProperty($property);
        }
    }

    /**
     * Implement this method instead of __set. This method makes it possible to call methods with one argument without using the brakes if they start with set followed by a tall character.
     * @arg FNString $property
     * @arg mixed $value
     * @param FNString $property
     * @param $value
     * @throws FNSetUnresolvedProperty
     * @return void
     */
    public function setUnresolvedProperty(FNString $property, $value)
    {
        $setter = s('set')->appendString($property->firstCharacterToUpperCase());
        /** @var $this Object */
        try {
            if(isset($this->object->{$property->value()}))
                $this->object->{$property->value()} = c($value);
            $this->callMethod($setter, $value);
        } catch (FNUnresolvedMethod $exception) {
            throw new FNSetUnresolvedProperty($property);
        }
    }

    //!object
    /**
     * A (non) static function. Returns if the receiver responds to a method.
     * @param $method
     * @return boolean
     */
    public function respondsToMethod($method)
    {
        return method_exists(isset($this) ? $this->object : static::cls(), cstring($method));
    }

    /**
     * Returns if the current object is kind of $type
     * @arg string|object $type
     * @param $type
     * @return boolean
     */
    public function isKindOf($type)
    {
        return $this->object instanceof $type;
    }

    /**
     * Returns if the current object is a member of $type
     * @arg string|object $class
     * @param $class
     * @return boolean
     */
    public function isMemberOf($class)
    {
        return get_class($this->object) == cstring($class);
    }

    /**
     * Returns if the given object is mutable.
     * @return boolean
     */
    public function isMutable()
    {
        return $this->object instanceof FNMutable;
    }

    /**
     * Returns the description of the current object.
     * @return string
     */
    public function __toString()
    {
        return '<' . $this::cls() .'('.cstring($this->object).')'. '>';
    }

    public function isEqualTo($value) {
        if($value instanceof FNProxy) {
            return static::objectOf($this) == static::objectOf($value)
                || cstring(static::objectOf($this)) == cstring(static::objectOf($value));
        } else return c($this) == c($value);
    }

    function callInnerStaticMethod(FNString $method ) {
        $this->call
    }

}

/**
 * A (non) static function. Calls $method and returns it.
 * @arg string|object $method
 * @args mixed $list = NULL
 * @param $method
 * @param null $list
 * @return mixed
 */
public function callMethod($method, /** @noinspection PhpUnusedParameterInspection */
                           $list = NULL /*infinite arguments*/)
{
    return call_user_func_array(array(isset($this) ? $this : static::cls(), cstring($method)), func_get_args());
}

/**
 * A (non) static function. Calls $method and returns it.
 * @arg string|object $method
 * @args array $array
 * @param $method
 * @param array $array
 * @return mixed
 */
public function callMethodWithArray($method, array $array)
{
    return call_user_func_array(array(isset($this) ? $this : static::cls(), cstring($method)), carray($array));
}