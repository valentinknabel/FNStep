<?PHP
//
//!FNStep
//!FNException.php
//
//!Created by Valentin Knabel on 24.04.13
//!Copyright (c) 2013 Valentin Knabel. All rights reserved.
//

namespace FNFoundation;

use Exception;

/**
 * Class FNException
 * @package FNFoundation
 */
class FNException extends Exception implements Object {
    use FNDefaultObject;

    /**
     * Caches the trace.
     * @type FNArray
     */
    private $trace;

    /**
     * This constructor is not declared protected: just use new
     * @arg string|Object $message = ""
     * @arg int|FNCountable $code = 0
     * @arg Exception $previous = NULL
     */
    public function __construct($message = "", $code = 0, Exception $previous = NULL) {
        parent::__construct(cstring($message), cint($code), $previous);
    }

    /**
     * Returns the description of the current object.
     * @return string
     */
    public function __toString() {
        if ($this->previous())
            return cstring(__FILE__.' '.__LINE__.''.static::cls(), ': #', $this->code(), ' \'', $this->message(), '\' {', $this->previous(), '}'); else return cstring(static::cls(), ': #', $this->code(), ' \'', $this->message(), '\'');
    }

    //!Implementation
    /**
     * Returns the message.
     * @return FNString
     */
    public function message() {
        return s($this->getMessage());
    }

    /**
     * Returns the error code.
     * @return FNNumber
     */
    public function code() {
        return n($this->getCode());
    }

    /**
     * Returns the previous exception
     * @return Exception
     */
    public function previous() {
        return $this->getPrevious();
    }

    /**
     * Returns the file name.
     * @return FNString
     */
    public function fileName() {
        return s($this->getFile());
    }

    /**
     * Returns the line.
     * @return FNNumber
     */
    public function line() {
        return n($this->getLine());
    }

    /**
     * Returns the trace array.
     * @return FNArray
     */
    public function trace() {
        if (!isset($this->trace))
            $this->trace = a($this->getTrace());
        return $this->trace;
    }

    /**
     * Returns the description of the trace. This method may be faster than calling ->trace()->description()
     * @return FNString
     */
    public function traceDescription() {
        return s($this->getTraceAsString());
    }
}

/**
 * Class FNVersionException
 * @package FNFoundation
 */
class FNVersionException extends FNException {
}

/**
 * Class FNTodoException
 * @package FNFoundation
 */
class FNTodoException extends FNException {
}

/**
 * Class FNTypeException
 * @package FNFoundation
 */
class FNTypeException extends FNException {
}

/**
 * Class FNImplementationException
 * @package FNFoundation
 */
class FNImplementationException extends FNException {
}

/**
 * Class FNUnimplementedFunction
 * @package FNFoundation
 */
class FNUnimplementedFunction extends FNImplementationException {
}

/**
 * Class FNUnimplementedMethod
 * @package FNFoundation
 */
class FNUnimplementedMethod extends FNUnimplementedFunction {
}

/**
 * Class FNResolvabilityException
 * @package FNFoundation
 */
class FNResolvabilityException extends FNException {
}

/**
 * Class FNUnresolvedFunction
 * @package FNFoundation
 */
class FNUnresolvedFunction extends FNResolvabilityException {
}

/**
 * Class FNUnresolvedMethod
 * @package FNFoundation
 */
class FNUnresolvedMethod extends FNUnresolvedFunction {
}

/**
 * Class FNUnresolvedStaticMethod
 * @package FNFoundation
 */
class FNUnresolvedStaticMethod extends FNUnresolvedMethod {
}

/**
 * Class FNUnresolvedProperty
 * @package FNFoundation
 */
class FNUnresolvedProperty extends FNResolvabilityException {
}

/**
 * Class FNSetUnresolvedProperty
 * @package FNFoundation
 */
class FNSetUnresolvedProperty extends FNUnresolvedProperty {
}

/**
 * Class FNArgumentException
 * @package FNFoundation
 */
class FNArgumentException extends FNException {
}


						