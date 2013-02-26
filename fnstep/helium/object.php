<?PHP
//
//!FNStep
//!object.php
//
//!Created by Valentin Knabel on 26.02.13
//!Copyright © 2013 Valentin Knabel. All rights reserved.
//

namespace FNFoundation;

interface object {
	public static function init();
	public static function super();
	public static function cls();
	public function callMethod($method, $list = NULL /*infinite arguments*/);//is static AND non-static
	public function callMethodWithArray($method, array $array);//is static AND non-static
	public static function callStaticMethod($method, $list = NULL /*infinite arguments*/);
	public static function callStaticMethodWithArray($method, array $array);
	public function isKindOf($type);
	public function isMemberOf($class);
	public function respondsToMethod($method);//is static AND non-static;
	public static function respondsToStaticMethod($method);
	public function description();
	public function __toString();
}
	
?>
						