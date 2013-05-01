<?PHP
//
//!FNStep
//!FNNil.php
//
//!Created by Valentin Knabel on 24.04.13
//!Copyright (c) 2013 Valentin Knabel. All rights reserved.
//

namespace FNFoundation;

class FNNil extends FNContainer
{

    //!FNObject
    /**
     * Implement this method instead of __call.
     * @arg FNString $function
     * @arg array $arguments
     * @param FNString $function
     * @param array $arguments
     * @throws FNUnresolvedMethod
     * @return mixed
     */
    public function unresolvedMethod(FNString $function, array $arguments)
    {
        if (DEBUG) {
            throw new FNUnresolvedMethod($function);
        } else return NULL;
    }

    /**
     * Implement this method instead of __callStatic.
     * @arg FNString $function
     * @arg array $arguments
     * @param FNString $function
     * @param array $arguments
     * @throws FNUnresolvedStaticMethod
     * @return mixed
     */
    public static function unresolvedStaticMethod(FNString $function, array $arguments)
    {
        if (DEBUG) {
            throw new FNUnresolvedStaticMethod($function);
        } else return NULL;
    }

    //!FNValidatable
    /**
     * Returns if the value is valid.
     * @param $value
     * @return boolean
     */
    public static function isValidValue($value)
    {
        return TRUE;
    }

    /**
     * Converts the given value for inner class use.
     * @param $value
     * @return mixed
     */
    public static function convertValue($value)
    {
        return NULL;
    }

    /**
     * Returns a mutable copy of the current object
     * @return FNContainer,FNMutable
     */
    public function mutableCopy()
    {
        return $this;
    }

    /**
     * Returns an immutable copy of the current object
     * @return FNContainer
     */
    public function immutableCopy()
    {
        return $this;
    }

    //!FNCountable
    /**
     * Returns the size.
     * @return FNNumber
     */
    public function size()
    {
        return n(0);
    }

}

