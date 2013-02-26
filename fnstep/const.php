<?PHP
//
//!FNStep
//!const.php
//
//!Created by Valentin Knabel on 25.02.13
//!Copyright © 2013 Valentin Knabel. All rights reserved.
//

namespace FNFoundation;

define('FN_PROTON', '1.0dev');
define('FN_HYDROGEN', '1.0');
define('FN_HELIUM', '2.0dev');
define('FN_LATEST_VERSION', FN_HELIUM);

$runningVersion = FN_PROTON;
foreach(array('5.2.17'=>FN_HYDROGEN, '5.4'=>FN_HELIUM) as $phpVersion => $fnVersion) {
	if(version_compare(PHP_VERSION, $phpVersion, '>=')) {
		$runningVersion = $fnVersion;
	}
	else break;
}
define('FN_VERSION', $runningVersion);
unset($runningVersion);

function FN_PROTON() { return FN_VERSION == FN_PROTON; }
function FN_HYDROGEN() { return FN_VERSION == FN_HYDROGEN; }
function FN_HELIUM() { return FN_VERSION == FN_HELIUM; }
function FN_LATEST() { return FN_VERSION == FN_LATEST; }

define('STRING', gettype(''));
define('CARRAY', gettype(array()));
define('INTEGER', gettype(0));
define('FLOAT', gettype(0.0));
define('RESOURCE', 'resource');
define('OBJECT', 'object');

?>
