<?PHP
//
//!FNStep
//!FNNumber.php
//
//!Created by Valentin Knabel on 26.02.13
//!Copyright © 2013 Valentin Knabel. All rights reserved.
//

namespace FNFoundation;

class FNNumber extends FNContainer implements FNCountable {
    use FNDefaultCountable;
    
    const ROUND_HALF_UP = PHP_ROUND_HALF_UP;
    const ROUND_HALF_DOWN = PHP_ROUND_HALF_DOWN;
    const ROUND_HALF_EVEN = PHP_ROUND_HALF_EVEN;
    const ROUND_HALF_ODD = PHP_ROUND_HALF_ODD;
    
    /**	@static pi
     * 	@return FNNumber 3.14159265358979323846
     * 	@link http://cn.php.net/manual/en/math.constants.php
     */
    static function pi() {
    	return static::initWith(pi());
    }
    /**	@static e
     * 	@return FNNumer 2.7182818284590452354
     * 	@link http://cn.php.net/manual/en/math.constants.php
     */
    static function e() {
    	return static::initWith(M_E);
    }
    /**
     * @static initRandom
     * @return a random FNNumber
     * @link http://de2.php.net/manual/en/function.rand.php
     */
    static function initRandom() {
    	return static::initWith(rand());
    }
    /**
     * @static initRandomBetween
     * @param FNNumber $minimum
     * @param FNNumber $maximum
     * @return $minimum <= random FNNumber <= $maximum 
     * @link http://de2.php.net/manual/en/function.rand.php
     */
    static function initRandomBetween(FNNumber $minimum,FNNumber $maximum) {
    	return static::initWith(rand($minimum->value, $maximum->value));
    }
    /**
     * Returns a FNNumber
     * @param FNString $string
     * @return FNNumber
     */
    static function initWithString(FNString $string) {
    	return static::initWith($string->value());
    }
    /**
     * @static zero
     * @return FNNumber 0
     */
    static function zero() {
    	return static::initWith(0); 
    }
    
    static function initIntegerWith($value, $round = FNNumber::ROUND_HALF_UP) {
    	return static::initWith($value)->round(FNNumber::zero(),$round);
    }
    
    /**
     * @static isValidValue
     * @param mixed $value
     * @return boolean
     * 		true: string, int, float
     */
    static function isValidValue($value) {
    	/* '1.0' ist auch numerisch! */
    	if($value instanceof FNContainer) return true;
    	if(is_numeric($value)) return true;
    	else return false;
    }
    /**
     * @static convertValue
     * @param mixed $value
     * @return numeric
     */
    static function convertValue($value) {
    	if($value instanceof FNContainer) $value = $value->value();
    	switch(gettype($value)) {
    		case gettype(''):
    			if((int)$value ==(float)$value) return(int)$value;
    			elseif(is_numeric($value))(float)$value;
    			else return 0;
    			break;
    		case gettype(0):
    			return $value;
    			break;
    		case gettype(0.0):
    			return $value;
    			break;
    		case gettype(NULL):
    			return NULL;
    			break;
    		default:
    			return 0;
    	}
    }
    
    //@MODIFIED
    
    function count() {
    	return $this-> floor()-> value();
    }
    
    /**
     * @method mutableCopy
     * @return FNContainer OR boolean
     * 		false
     */
    function mutableCopy() {
    	return clone $this;
    }
    
    function immutableCopy() {
    	return FNNumber::initWith($this->value());
    }
    
##Trigonometry
    //conversions
    //Converts from degrees to radian
    /**
     * @method radian
     * @return radian FNNumber from degree
     * @link http://de2.php.net/manual/en/function.deg2rad.php
     */
    function radian() {
    	return $this->returnObjectWith(deg2rad($this->value));
    }
    /**
     * @method degree
     * @return degree FNNumber from radian
     * @link http://de2.php.net/manual/en/function.rad2deg.php
     */
    function degree() {
    	return $this->returnObjectWith(rad2deg($this->value));
    }
    //triangles
    /**
     * @method hypotenuse
     * @param FNNumber $side
     * @return hypotenuse FNNumber
     * @link http://de2.php.net/manual/en/function.hypot.php
     * 		Calculates the length of the hypotenuse of a right-angle triangle
     */
    function hypotenuse(FNNumber $side) {
    	return $this->returnObjectWith(hypot($this->value, $side->value));
    }
    /**
     * @method sine
     * @return sine FNNumber
     * @link http://de2.php.net/manual/en/function.sin.php
     */
    //sin,cos,tan
    function sine() {
    	return $this->returnObjectWith(sin($this->value));
    }
    /**
     * @method cosine
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.cos.php
     */
    function cosine() {
    	return $this->returnObjectWith(cos($this->value));
    }
    /**
     * @method tangent
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.tan.php
     */
    function tangent() {
    	return $this->returnObjectWith(tan($this->value));
    }
    //hyperbolic
    /**
     * @method hyperbolicSine
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.sinh.php
     */
    function hyperbolicSine() {
    	return $this->returnObjectWith(sinh($this->value));
    }
    /**
     * @method hyperbolicCosine
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.cosh.php
     */
    function hyperbolicCosine() {
    	return $this->returnObjectWith(cosh($this->value));
    }
    /**
     * @method hyperbolicTangent
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.tanh.php
     */
    function hyperbolicTangent() {
    	return $this->returnObjectWith(tanh($this->value));
    }
    //arc
    /**
     * @method arcSine
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.asin.php
     */
    function arcSine() {
    	return $this->returnObjectWith(asin($this->value));
    }
    /**
     * @method arcCosine
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.acos.php
     */
    function arcCosine() {
    	return $this->returnObjectWith(acos($this->value));
    }
    /**
     * @method arcTangent
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.atan.php
     */
    function arcTangent() {
    	return $this->returnObjectWith(atan($this->value));
    }
    /**
     * @method arcDevidedTangent
     * @param FNNumber $divisor
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.atan2.php
     */
    function arcDevidedTangent(FNNumber $divisor) {
    	return $this->returnObjectWith(atan2($this->value, $divisor->value));
    }
    //arc hyperbolic
    /**
     * @method arcHyperbolicSine
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.asinh.php
     */
    function arcHyperbolicSine() {
    	return $this->returnObjectWith(asinh($this->value));
    }
    /**
     * @method arcHyperbolicCosine
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.acosh.php
     */
    function arcHyperbolicCosine() {
    	return $this->returnObjectWith(acosh($this->value));
    }
    /**
     * @method arcHyperBolicTangent
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.atanh.php
     */
    function arcHyperbolicTangent() {
    	return $this->returnObjectWith(atanh($this->value));
    }	
##round
    /**
     * @method ceil
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.ceil.php
     */
    function ceil() {
    	return $this->returnObjectWith((int)ceil($this->value));
    }
    /**
     * @method floor
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.floor.php
     */
    function floor() {
    	return $this->returnObjectWith((int)floor($this->value));
    }
    /**
     * @method round
     * @param FNNumber $precision
     * @param int $mode
     * 		use only FNNumber constants!!!
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.round.php
     */
    function round(FNNumber $precision = NULL, $mode = FNNumber::ROUND_HALF_UP) {
    	if(!$precision) $precision = FNNumber::zero();
    	return $this->returnObjectWith(round($this->value,$precision->value(),$mode));
    }
##string numbers
    /**
     * @method binaryString
     * @return FNString
     * @link http://de2.php.net/manual/en/function.decbin.php
     */
    function binaryString() {
    	return FNString::initWith(decbin($this->value));
    }
    /**
     * @method hexadecimalString
     * @return FNString
     * @link http://de2.php.net/manual/en/function.dechex.php
     */
    function hexadecimalString() {
    	return FNString::initWith(dechex($this->value));
    }
    /**
     * @method octalString
     * @return FNString
     * @link http://de2.php.net/manual/en/function.deoct.php
     */
    function octalString() {
    	return FNString::initWith(decoct($this->value));
    }
    /**
     * @method decimalString
     * @return FNString
     */
    function decimalString() {
    	return FNString::initWith((string)$this->value);
    }
##calculations
    /**
     * @method absolute
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.abs.php
     */
    function absolute() {
    	return $this->returnObjectWith(abs($this->value));
    }
    /**
     * @method sum
     * @param FNNumber $addend
     * @return FNNumber
     */
    function sum(FNNumber $addend) {
    	return $this->returnObjectWith($this->value+$addend->value);
    }
    /**
     * @method difference
     * @param FNNumber $subtrahend
     * @return FNNumber
     */
    function difference(FNNumber $subtrahend) {
    	return $this->returnObjectWith($this->value-$subtrahend->value);
    }
    /**
     * @method product
     * @param FNNumber $factor
     * @return FNNumber
     */
    function product(FNNumber $factor) {
    	return $this->returnObjectWith($this->value*$factor->value);
    }
    /**
     * @method quotient
     * @param FNNumber $divisor
     * @return FNNumber or false 
     */
    function quotient(FNNumber $divisor) {
    	if($divisor->value == 0) return false;
    	else return $this->returnObjectWith($this->value/$divisor->value);
    }
    /**
     * @method power
     * @param FNNumber $exponent
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.power.php
     */
    
    function absoluteDifference(FNNumber $subtrahend) {//@MODIFIED - D of difference tall
    	return $this->returnObjectWith(abs($this->value() - $subtrahend->value()));
    }
    
    //@MODIFIED - 
    /**
     * aadtler
     * Valentin Knabel
     * 21.09.12
     *
     * @return FNNumber
     */
    public function increase() {
    	return $this->returnObjectWith($this-> sum(n(1)));
    }
    
    /**
     * aadtler
     * Valentin Knabel
     * 21.09.12
     *
     * @return FNNumber
     */
    public function dencrease() {
    	return $this->returnObjectWith($this-> difference(n(1)));
    }
    //@MODEND
    
    function power(FNNumber $exponent) {
    	return $this->returnObjectWith(pow($this->value, $exponent->value));
    }
    /**
     * @method squareRoot
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.sqrt.php
     */
    function squareRoot() {
    	return $this->returnObjectWith(sqrt($this->value));
    }
    /**
     * @method exponentiate10
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.exp10.php
     */
    function exponentiate10() {
    	return $this->returnObjectWith(pow($this->value,10));
    }
    /**
     * @method exponentiateE
     * @return FNNumber
     * FNNumber::e() is the base
     * @link http://de2.php.net/manual/en/function.exp.php
     */
    function exponentiateE() {
    	return $this->returnObjectWith(exp($this->value));
    }
    /**
     * @method exponentiateEMinus1
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.expm1.php
     */
    function exponentiateEMinus1() {
    	return $this->returnObjectWith(expm1($this->value));
    }
    /**
     * @method logarithm10
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.log10.php
     */
    function logarithm10() {
    	return $this->returnObjectWith(log10($this->value));
    }
    /**
     * @method logarithm2
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.log.php
     */
    function logarithm2() {
    	return $this->returnObjectWith(log($this->value,2));
    }
    /**
     * @method logarithmEPlus1
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.log1p.php
     */
    function logarithmEPlus1() {
    	return $this->returnObjectWith(log1p($this->value));
    }
    /**
     * @method logarithmE
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.log.php
     */
    function logarithmE() {
    	return $this->returnObjectWith(log($this->value));
    }
    /**
     * @method logarithmX
     * @param FNNumber $base
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.log.php
     */
    function logarithmX(FNNumber $base) {
    	return $this->returnObjectWith(log($this->value,$base->value));
    }	
##conditions
    /**
     * @method modulo
     * @param FNNumber $divisor
     * @return rest FNNumber
     * @example FNNumber::initWith(10)->modulo(FNNumber::initWith(6)) is FNNumber 4
     * @link http://de2.php.net/manual/en/function.mod.php
     */
    function modulo(FNNumber $divisor) {
    	return $this->returnObjectWith(fmod($this->value,$divisor->value));
    }
    /**
     * @method isFinite
     * @return boolean
     * 		true if $this is finite
     * @example FNNumber::e() is finite
     * @link http://de2.php.net/manual/en/function.is-finite.php
     */
    function isFinite() {
    	return is_finite($this->value);
    }
    /**
     * @method isInfinite
     * @return boolean
     * 		true if $this is infinite 
     * @example FNNumber::initWith(1)->devision(FNNumber::zero()) is infinite
     * @link http://de2.php.net/manual/en/function.is-infinite.php
     */
    function isInfinite() {
    	return is_infinite($this->value);
    }
    /**
     * @method isNotANumber
     * @return boolean
     * 		true if $this is Not-a-Number
     * @example ::cosine(FNNumber::initWith(1.1)) == NaN
     * @link http://de2.php.net/manual/en/function.is-nan.php
     */
    function isNotANumber() {
    	return is_nan($this->value);
    }
    /**
     * @method isLess
     * @param FNNumber $number
     * @return boolean
     * 		true if $this is less
     */
    function isLess(FNNumber $number) {
    	return $this->value < $number->value;
    }
    /**
     * @method isLessOrEqual
     * @param FNNumber $number
     * @return boolean
     * 		true if $number is greater
     */
    function isLessOrEqual(FNNumber $number) {
    	return $this->value <= $number->value;
    }
    /**
     * @method isGreater
     * @param FNNumber $number
     * @return boolean
     * 		true if $this is greater
     */
    function isGreater(FNNumber $number) {
    	return $this->value > $number->value;
    }
    /**
     * @method isGreaterOrEqual
     * @param FNNumber $number
     * @return boolean
     * 		true if $number is less
     */
    function isGreaterOrEqual(FNNumber $number) {
    	return $this->value >= $number->value;
    }
}
	
?>
						