<?PHP
//
//!FNStep
//!FNIdentifier.php
//
//!Created by Valentin Knabel on 27.02.13
//!Copyright © 2013 Valentin Knabel. All rights reserved.
//
	
namespace FNFoundation;

abstract class FNIdentifier extends FNObject implements FNIdentifiable {
	use FNDefaultIdentifiable;
	private $id;
	
	protected function __construct(FNIdentifiable $id) {
		$this-> id = $id;
	}
	
	//raises an exception if FNContainer::initWith($id) returns not an instance of FNIdentifiable
	static function initWith($id) {
		$container = FNContainer::initWith($id);
		if($container instanceof FNIdentifiable)
			return static::initWithId(FNContainer::initWith($id));
		else throw new FNTypeException($container instanceof object ? $container::cls() : gettype($container));
	}
	
	static function initWithId(FNIdentifiable $id) {
		
	}
	
	function __toString() {
		return cstring($this-> id());
	}
	
	//!FNIdentifiable
	function id() {
		return $this-> id;
	}
	
}

?>
						