<?PHP

namespace FNFoundation;

function FNTodo($message = 'undefined') {
	echo "TODO: '$message'";
}

//!STATIC FUNCTIONS
/**
 * Creates a FNString
 * @param nativeType $t
 * @return FNString
 */
function s($t) {
	return call_user_func_array(array('FNString','initWithList'), func_get_args());
}

/**
 * Creates a FNMutableString
 * @param nativeType $t
 * @return FNMutableString
 */
function sm($t) {
    return call_user_func_array(array('FNMutableString','initWithList'), func_get_args());
}

/**
 * Creates a FNNumber
 * @param nativeType $t
 * @return FNNumber
 */
function n($t) {
    return FNNumber::initWith($t);
}

/**
 * Creates a FNArray(infinite parameters)
 * @param FNInitializable $obj1
 * @param FNInitializable $obj2
 * @return FNArray
 */
function a(FNInitializable $obj1, FNInitializable $obj2=NULL) {
    return call_user_func(array('FNArray','initWithList'),func_get_args());
}

/**
 * Creates a FNMutableArray(infinite parameters)
 * @param FNInitializable $obj1
 * @param FNInitializable $obj2
 * @return FNMutableArray
 */
function am(FNInitializable $obj1, FNInitializable $obj2=NULL) {
    return call_user_func(array('FNMutableArray','initWithList'),func_get_args());
}

/**
 * Creates a FNDictionary(infinite parameters, key-value pairs)
 * @param FNInitializable $key
 * @param FNInitializable $value
 * @return FNDictionary
 */
function d(FNInitializable $key, FNInitializable $value=NULL) {
    return call_user_func(array('FNDictionary','initWithList'),func_get_args());
}

/**
 * Creates a FNMutableDictionary(infinite parameters, key-value pairs)
 * @param FNInitializable $key
 * @param FNInitializable $value
 * @return FNMutableDictionary
 */
function dm(FNInitializable $key, FNInitializable $value=NULL) {
    return call_user_func(array('FNDictionary','initWithList'),func_get_args());
}

//!ADDITIONS
//NOTE: cstring() won't terminate by calling structures like $array = array();$array[] = $array; cstring($array);
function cstring($value) {
    switch(gettype($value)) {
    	case STRING:
    		return $value;
    	case INTEGER:
    		return strval($value);
    	case FLOAT:
    		return strval($value);
    	case CARRAY:
    		$array = array();
    		foreach($value as $key=>$val) {
	    		$array[$key] = cstring($val);
    		}
    		return implode('', $array);
    	case RESOURCE:
    		return strval($value);
    	case OBJECT:
    		if($value instanceof FNObject) {
	    		if($value-> respondsToMethod('__toString')) {
		    		return $value->__toString();
	    		} else throw new NFTypeException($value::cls().' cannot be concatenated.');
    		} else {
	    		if(function_exists(array($value, '__toString'))) {
		    		return $value->__toString();
	    		} else throw new NFTypeException(get_class($value).' cannot be concatenated.');
    		}
    	default:
    		throw new NFTypeException('unknown type '.gettype($value));
    		
    }
}

function carray($value) {
    switch(gettype($value)) {
    	case STRING:
    		return array($value);
    	case INTEGER:
    		return array($value);
    	case FLOAT:
    		return array($value);
    	case CARRAY:
    		return $value;
    	case RESOURCE:
    		return array($value);
    	case OBJECT:
    		if($value instanceof FNObject) {
	    		if($value-> respondsToMethod('carray')) { 
	    			return $value->carray(); 
	    		} else throw new NFTypeException($value::cls().' cannot be converted to an array.');
    		} else {
	    		throw new NFTypeException(get_class($value).' cannot be converted to an array.');
    		}
    	default:
    		throw new NFTypeException('unknown type '.gettype($value));
    		
    }
}

function cnumber($value) {
    switch(gettype($value)) {
    	case STRING:
    		return count($value);
    	case INTEGER:
    		return $value;
    	case FLOAT:
    		return $value;
    	case CARRAY:
    		return count($value);
    	case RESOURCE:
    		return intval($value);
    	case OBJECT:
    		if($value instanceof FNObject) {
	    		if($value instanceof FNNumber) return $value-> value();
	    		if($value-> respondsToMethod('count')) {
		    		return $value->count();
	    		} else throw new NFTypeException($value::cls().' cannot be counted.');
    		} else {
	    		if(function_exists(array($value, 'count'))) {
		    		return $value->count();
	    		} else throw new NFTypeException('object cannot be counted.');
    		}
    	default:
    		throw new NFTypeException('unknown type '.gettype($value));
    		
    }
}

function cint($value) {
	return intval(cnumber($value));
}

function cfloat($value) {
	return floatval(cnumber($value));
}

?>