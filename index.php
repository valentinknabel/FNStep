<?php
/**
 * Created by JetBrains PhpStorm.
 * User: valentinknabel
 * Date: 02.11.13
 * Time: 14:07
 * To change this template use File | Settings | File Templates.
 */

require 'fnstep/fnstep.php';

use FNFoundation\FNMutableDictionary;

$dict = FNMutableDictionary::init();
$dict['key0'] = s('a');
$dict[s('key1')] = s('b');

foreach($dict as $key => $value) {
    var_dump($key);
    var_dump($value);
}
