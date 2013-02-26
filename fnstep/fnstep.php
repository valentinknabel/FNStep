<?PHP
//
//!FNStep
//!fnstep.php
//
//!Created by Valentin Knabel on 23.02.13
//!Copyright (c) 2013 Valentin Knabel. All rights reserved.
//

require('const.php');


if(FN_PROTON() || FN_HYDROGEN()):
if(is_dir('hydrogen')):
require('hydrogen/static_functions.php');
require('hydrogen/FNObject.php');
require('hydrogen/FNException.php');
require('hydrogen/FNContainer.php');
require('hydrogen/FNString.php');
require('hydrogen/FNNumber.php');
require('hydrogen/FNSet.php');
require('hydrogen/FNArray.php');
require('hydrogen/FNDictionary.php');
else:
exit('hydrogen not found');
endif;

elseif(FN_HELIUM()):
if(is_dir('helium')):
require('helium/static_functions.php');
require('helium/object.php');
require('helium/FNDefaultObjectImplementation.php');
require('helium/FNException.php');
require('helium/FNObject.php');
require('helium/FNContainer.php');
require('helium/FNString.php');
require('helium/FNNumber.php');
require('helium/FNSet.php');
require('helium/FNArray.php');
require('helium/FNDictionary.php');
else:
exit('helium not found');
endif;


	
?>
						