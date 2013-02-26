<?PHP
	
	namespace FNFoundation;
	//!CLASSES OF FNSCRIPT\COREFOUNDFNION
	
	/**
	 * aadtler
	 * Valentin Knabel
	 * 20.09.12
	 *
	 * Implement this interface to show that instances of the class are mutable
	 */
	interface FNMutable {} //@MODIFIED - new interface
	
	interface FNCountable {
		/**
		 * Counts the elements
		 * @return FNNumber
		 */
		public function count();
	}
	
	abstract class FNContainer extends FNObject {
		protected $_value;
		static private $_classes;//@MODIFIED - new property
		
		/**
		 * @abstract @static isValidValue
		 * @param mixed $value
		 * @return boolean
		 */
		static function isValidValue($value) { //@MODIFIED - not abstract(warning)
			throw new FNUnimplementedMethodError();
		}
		
		/**
		 * @abstract @static convertValue
		 * @param mixed $value
		 * @return mixed
		 */
		static function convertValue($value) { //@MODIFIED - not abstract(warning)
			throw new FNUnimplementedMethodError();
		}
		
		/**
		 * @abstract isMutable
		 * @return boolean
		 */
		public function isMutable() {//@MODIEFIED - not abstract
			return $this instanceof FNMutable;
		}
		
		/**
		 * @abstract mutableCopy
		 * @return FNContainer
		 */
		abstract public function mutableCopy();
		/**
		 * @return FNContainer
		 */
		abstract public function immutableCopy();
		
		/**
		 * @method __construct
		 * @param mixed $value
		 */
		public function __construct($value = NULL) {
			if(static::isValidValue($value)) {
				$this->_value = static::convertValue($value);
				
				//@MODIFIED - save if immutable
				if($this-> isMutable()) {
					if(!self:: $_classes) self:: $_classes = array();
					if(!isset(self:: $_classes[get_class($this)])) self:: $_classes[get_class($this)] = array('values'=>array(), 'objects'=>array());
					$length = count(self:: $_classes[get_class($this)]['values']);
					self:: $_classes[get_class($this)]['values'][$length] = $this-> value();
					self:: $_classes[get_class($this)]['objects'][$length] = $this;
				}
				//@MODEND
			}
		}
		/**
		 * @static initWith
		 * @param $value
		 * @return FNContainer; NULL on failure
		 */
		static function initWith($value) {
			//@MODIFIED - return if not saved
			if(!isset(self:: $_classes)) self:: $_classes = array();
			if(!isset(self:: $_classes[get_called_class()])) self:: $_classes[get_called_class()] = array('values'=>array(), 'objects'=>array());
			
			$index = array_search($value, self:: $_classes[get_called_class()]['values']);
			if($index !== FALSE)
				return self:: $_classes[get_called_class()]['objects'][$index];
			//@MODEND
			if(static::isValidValue($value)) {
				return new static($value);
			} else return NULL;
		}
		/**
		 * @method __get
		 * @param string $prop
		 * @return mixed
		 */
		function __get($prop) {
			if($prop === 'value')
				return $this->_value;
			else return parent::__get($prop);
		}
		/**
		 * @method value
		 * @return mixed
		 */
		function value() {
			return $this->_value;
		}
		/**
		 * @method returnObjectWith
		 * @param mixed $value
		 * @return FNContainer
		 * 		if the FNContainer isMutable, it's value will be set;
		 * 		else a new FNContainer will be returned
		 */
 		protected function returnObjectWith($value) {
 			if($this->isMutable()) {
				$this->_value = static::convertValue($value);
				return $this; 
			} else return static::initWith($value);
		}
		/**
		 * @method isEqualTo
		 * @param FNContainer $container
		 * @param boolean $strict
		 * @return boolean
		 */
		function isEqualTo(FNContainer $container, $strict = FALSE) {
			if($strict) {
				if($this->value() === $container->value()) return true;
				else return false;
			} else {
				if ($this->value() == $container->value()) {
					return true;
				}
				else return false;
			}
		}
		function isEmpty() {
			$tmp = $this->value();
			if(empty($tmp)) return true;
			else return false;
		}
		function valueIsSet() {
			$tmp = $this->value();
			if(isset($tmp)) return true;
			else return false;
		}
	}

?>