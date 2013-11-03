<?php
/**
 * Created by JetBrains PhpStorm.
 * User: valentinknabel
 * Date: 03.11.13
 * Time: 01:18
 * To change this template use File | Settings | File Templates.
 */

namespace FNFoundation;


/**
 * Class FNClass
 * @package FNFoundation
 */
class FNClass extends FNObject implements FNIdentifiable {
    /**
     * @var FNString
     */
    protected $_name;

    /**
     * @param $name
     */
    protected function __construct($name)
    {
        parent::__construct();

        $this->_name = s($name);
    }

    /**
     * @param $string
     * @return static
     */
    public static function initWith($string) {
        return new static($string);
    }

    /**
     * @param FNString $string
     * @return static
     */
    public static function initWithString(FNString $string) {
        return new static($string);
    }

    /**
     * Returns the id.
     * @return FNString|FNNumber|string|int
     */
    public function id() {
        return $this->_name;
    }
    /**
     * Returns an identifier.
     * @return FNIdentifier
     */
    public function identifier() {
        return FNCommonIdentifier::initWithId($this);
    }
    /**
     * Returns a numeric identifier.
     * @return FNNumericIdentifier
     */
    public function numericIdentifier() {
        return FNNumericIdentifier::initWithId($this);
    }
    /**
     * Returns a common identifier.
     * @return FNCommonIdentifier
     */
    public function commonIdentifier() {
        return FNCommonIdentifier::initWithId($this);
    }
    /**
     * Returns a generic identifier.
     * @return FNGenericIdentifier
     */
    public function genericIdentifier() {
        return FNGenericIdentifier::initWithId($this);
    }

    /**
     * @return FNString
     */
    public function name() {
        return $this->_name;
    }

    /**
     * @param $method
     * @param null $list
     * @return mixed
     */
    public function callMethod($method, /** @noinspection PhpUnusedParameterInspection */
                               $list = NULL /*infinite arguments*/) {
        return call_user_func_array([cstring($this->_name), cstring($method)], array_slice(func_get_args(), 1, func_num_args() - 2));
    }

    /**
     * @param $method
     * @param array $array
     * @return mixed
     */
    public function callMethodWithArray($method, array $array) {
        return call_user_func_array([cstring($this->_name), cstring($method)], $array);
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function isEqualTo($value) {
        if ($value instanceof FNClass) {
            return $value->name()->isEqualTo($this->name());
        } else if ($value instanceof FNIdentifiable) {
            return cstring($value) == cstring($this->name());
        } else {
            return parent::isEqualTo($value);
        }
    }


    /**
     * @return FNClass
     */
    public function superClass()
    {
        return FNClass::initWith(get_parent_class(cstring($this->name())));
    }

}
