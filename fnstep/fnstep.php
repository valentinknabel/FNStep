<?PHP
//
//!FNStep
//!fnstep.php
//
//!Created by Valentin Knabel on 23.02.13
//!Copyright (c) 2013 Valentin Knabel. All rights reserved.
//

use FNFoundation\FNContainer;

require('FNFoundation/functions.php');
require('FNFoundation/FNObject.php');
require('FNFoundation/FNException.php');
require('FNFoundation/FNIdentifier.php');
require('FNFoundation/FNContainer.php');
require('FNFoundation/FNNil.php');
require('FNFoundation/FNBoolean.php');
require('FNFoundation/FNNumber.php');
require('FNFoundation/FNString.php');
require('FNFoundation/FNArrayAccess.php');
require('FNFoundation/FNSet.php');
require('FNFoundation/FNArray.php');

//print_r(hash_algos());
$var = s();
echo var_dump($var->isKindOf(FNContainer::cls()));


?>