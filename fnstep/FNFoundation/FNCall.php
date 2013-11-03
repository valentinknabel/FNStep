<?php
/**
 * Created by JetBrains PhpStorm.
 * User: valentinknabel
 * Date: 03.11.13
 * Time: 00:46
 * To change this template use File | Settings | File Templates.
 */

namespace FNFoundation;

use Closure;

/**
 * Class FNCallable
 * @package FNFoundation
 */
interface FNCallable {
    /**
     * @return mixed
     */
    function __invoke();
}

/**
 * Class FNCall
 * @package FNFoundation
 */
abstract class FNCall extends FNObject {

    /**
     * @param FNString $value
     * @return FNFunction
     */
    static function initWithName(FNString $value) {
        return FNFunction::initWithName($value);
    }

    /**
     * @param callable $closure
     * @return FNClosure
     */
    static function initWithClosure(Closure $closure) {
        return FNClosure::initWithClosure($closure);
    }

    /**
     * @param \FNFoundation\Object|Object $object
     * @param FNString $name
     * @return FNMethod
     */
    static function initWithTarget(Object $object, FNString $name = NULL) {
        return FNMethod::initWithTarget($object, $name);
    }

    /**
     * @param FNClass $class
     * @param FNString $name
     * @return FNStaticMethod
     */
    static function initWithClass(FNClass $class, FNString $name) {
        return FNStaticMethod::initWithClass($class, $name);
    }

    /**
     * @return mixed
     */
    abstract function __invoke();

}

/**
 * Class FNFunction
 * @package FNFoundation
 */
class FNFunction extends FNCall {
    /**
     * @var FNString
     */
    protected $_name;

    /**
     * @param FNString $name
     */
    protected function __construct(FNString $name)
    {
        parent::__construct();

        $this->_name = s($name);
    }


    /**
     * @param FNString $value
     * @return static
     */
    static function initWithName(FNString $value) {
        return new static($value);
    }

    /**
     * @return mixed
     */
    function __invoke() {
        return call_user_func_array(cstring($this->_name), func_get_args());
    }
}

/**
 * Class FNMethod
 * @package FNFoundation
 */
class FNMethod extends FNFunction {
    /**
     * @var Object
     */
    protected $_object;

    /**
     * @param \FNFoundation\Object|Object $object
     * @param FNString $name
     */
    protected function __construct(Object $object, FNString $name)
    {
        parent::__construct($name);

        $this->_object = $object;
    }

    /**
     * @param \FNFoundation\Object|Object $object
     * @param FNString $name
     * @return FNMethod
     */
    static function initWithTarget(Object $object, FNString $name = NULL) {
        return new static($object, $name);
    }

    /**
     * @return mixed
     */
    function __invoke() {
        return call_user_func_array([$this->_object, $this->_name], func_get_args());
    }
}

/**
 * Class FNStaticMethod
 * @package FNFoundation
 */
class FNStaticMethod extends FNFunction {
    /**
     * @var FNClass
     */
    protected $_class;

    /**
     * @param FNClass $class
     * @param FNString $name
     */
    protected function __construct(FNClass $class, FNString $name)
    {
        parent::__construct($name);

        $this->_class = $class;
    }

    /**
     * @param FNClass $class
     * @param FNString $name
     * @return static
     */
    static function initWithClass(FNClass $class, FNString $name) {
        return new static($class, $name);
    }

    /**
     * @return mixed
     */
    function __invoke() {
        return call_user_func_array([$this->_class, $this->_name], func_get_args());
    }
}

/**
 * Class FNClosure
 * @package FNFoundation
 */
class FNClosure extends FNCall {
    /**
     * @var Closure
     */
    protected $_closure;

    /**
     * @param callable $closure
     */
    protected function __construct(Closure $closure)
    {
        parent::__construct();

        $this->_closure = $closure;
    }

    /**
     * @param callable $closure
     * @return static
     */
    static function initWithClosure(Closure $closure) {
        return new static($closure);
    }

    /**
     * @return mixed
     */
    function __invoke() {
        return call_user_func_array($this->_closure, func_get_args());
    }
}
