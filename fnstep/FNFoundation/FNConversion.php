<?php
/**
 * Created by JetBrains PhpStorm.
 * User: valentinknabel
 * Date: 08.05.13
 * Time: 15:21
 * To change this template use File | Settings | File Templates.
 */

namespace FNFoundation;


use Closure;
use Exception;

class FNConversion extends FNObject {
    private static $conversions = array();
    private $target;
    private $source;
    private $converter;
    private $identifier;

    protected function __construct(Closure $converter, FNString $source = NULL, FNString $target = NULL, FNIdentifiable $id = NULL) {
        $this->converter = $converter;
        if ($target) $this->target = $target;
        if ($source) $this->source = $source;
        if ($id) $this->setIdentifier($id);
    }

    public static function initWithId(FNIdentifiable $id) {
        try {
            return self::$conversions[cstring($id)];
        } catch (Exception $exce) {
            return NULL;
        }
    }

    public static function initWith(Closure $converter, FNString $source, FNString $target, FNIdentifiable $id = NULL) {
        return new static($converter, $source, $target, $id);
    }

    public static function initWithClosure(Closure $converter, FNString $source, FNString $target, FNIdentifiable $id = NULL) {
        return new static($converter, $source, $target, $id);
    }

    public function setIdentifier(FNIdentifiable $id) {
        if (cstring($this->identifier)) unset(self::$conversions[cstring($this->identifier)]);
        $this->identifier = $id->genericIdentifier();
        self:$conversions[cstring($this->identifier)] = $this;
    }

    public function identifier() {
        return $this->identifier;
    }

    function source() {
        return $this->source;
    }

    function target() {
        return $this->target;
    }

    function convert($value) {
        $converter = $this->converter;
        return $converter($value);
    }

}

class FNConversionGroup extends FNObject {
    private static $groups = array();
    private $data;
    private $identifier;

    protected function __construct(FNArray $conversions, FNIdentifiable $id = NULL) {
        /** @var $convs FNMutableArray */
        $convs = FNMutableArray::init();
        foreach ($conversions as $conv) {
            if ($conv instanceof FNConversion)
                $convs->add($conv);
        }
        $this->data = $convs->immutableCopy();
        if ($id) $this->setIdentifier($id);
    }

    public function setIdentifier(FNIdentifiable $id) {
        if (cstring($this->identifier)) unset(self::$groups[cstring($this->identifier)]);
        $this->identifier = $id->genericIdentifier();
        self:$groups[cstring($this->identifier)] = $this;
    }

    public function identifier() {
        return $this->identifier;
    }


}