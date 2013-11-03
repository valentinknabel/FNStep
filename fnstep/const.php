<?PHP
//
//!FNStep
//!const.php
//
//!Created by Valentin Knabel on 25.02.13
//!Copyright © 2013 Valentin Knabel. All rights reserved.
//

namespace FNFoundation;

use Closure;

define('YES', TRUE, TRUE);
define('NO', FALSE, TRUE);

define('STRING', gettype(''));
define('ARRAY', gettype(array()));
define('INTEGER', gettype(0));
define('FLOAT', gettype(0.0));
define('RESOURCE', 'resource');
define('OBJECT', 'object');

define('DEBUG', in_array('--debug', $argv) || in_array('--debug=1', $argv));
define('HTML_DISABLED', in_array('--html=0', $argv));

//TODO or based on bool
function __debug(Closure $closure) {
    if (DEBUG) {
        return $closure();
    }
}
