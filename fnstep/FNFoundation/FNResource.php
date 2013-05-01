<?php
/**
 * Created by JetBrains PhpStorm.
 * User: valentinknabel
 * Date: 01.05.13
 * Time: 21:32
 * To change this template use File | Settings | File Templates.
 */

namespace FNFoundation;


class FNResource extends FNContainer
{

    public static function isValidValue($value)
    {
        return is_resource($value);
    }

    /**
     * Returns a mutable copy of the current object
     * @return FNContainer,FNMutable
     */
    public function mutableCopy()
    {
        return FNMutableResource::initWith($this->value());
    }

    /**
     * Returns an immutable copy of the current object
     * @return FNContainer
     */
    public function immutableCopy()
    {
        return self::initWith($this->value());
    }

    /**
     * Returns the size.
     * @return FNNumber
     */
    public function size()
    {
        return n($this->value());
    }

    public function type()
    {
        return s(get_resource_type($this->value()));
    }

}

class FNMutableResource extends FNResource
{
    use FNDefaultMutableContainer;
}