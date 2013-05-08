<?PHP
//
//!FNStep
//!fnstep.php
//
//!Created by Valentin Knabel on 23.02.13
//!Copyright (c) 2013 Valentin Knabel. All rights reserved.
//

use FNFoundation\FNProxy;

date_default_timezone_set('Europe/Berlin');

require('const.php');
require('FNFoundation/functions.php');
require('FNFoundation/FNObject.php');
require('FNFoundation/FNException.php');
require('FNFoundation/FNIdentifier.php');
require('FNFoundation/FNContainer.php');
require('FNFoundation/FNNil.php');
require('FNFoundation/FNObjectContainer.php');
require('FNFoundation/FNResource.php');
require('FNFoundation/FNBoolean.php');
require('FNFoundation/FNNumber.php');
require('FNFoundation/FNString.php');
require('FNFoundation/FNArrayAccess.php');
require('FNFoundation/FNSet.php');
require('FNFoundation/FNArray.php');
require('FNFoundation/FNProxy.php');

//print_r(hash_algos());

class Test {
    public function printType($var) {
        echo gettype($var[0]);
    }
}

$proxy = FNProxy::initWith(new Test());