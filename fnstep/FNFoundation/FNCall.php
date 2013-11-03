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

interface FNCallable {
    function __invoke();
}

abstract class FNCall extends FNObject {

    static function initWithName(FNString $value) {
        return FNFunction::initWithName($value);
    }

    static function initWithClosure(Closure $closure) {
        return FNClosure::initWithClosure($closure);
    }

    static function initWithTarget(Object $object, FNString $name = NULL) {
        return FNMethod::initWithTarget($object, $name);
    }

    //TODO static function initWithClass(FNClass $class, FNString $name) {}

    abstract function __invoke();

}

class FNFunction extends FNCall {
    protected $_name;

    function __invoke() {
        return call_user_func_array($this->_name, func_get_args());
    }
}

class FNMethod extends FNFunction {
    protected $_object;

    function __invoke() {
        return call_user_func_array([$this->_object, $this->_name], func_get_args());
    }
}

class FNStaticMethod extends FNFunction {
    protected $_class;

    function __invoke() {
        return call_user_func_array([$this->_class, $this->_name], func_get_args());
    }
}

class FNClosure extends FNCall {
    protected $_closure;

    function __invoke() {
        return call_user_func_array($this->_closure, func_get_args());
    }
}
