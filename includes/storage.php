<?php
/**
 * Theme storage manipulations
 *
 * @package WordPress
 * @subpackage SOLENG
 * @since SOLENG 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Get theme variable
if (!function_exists('soleng_storage_get')) {
	function soleng_storage_get($var_name, $default='') {
		global $SOLENG_STORAGE;
		return isset($SOLENG_STORAGE[$var_name]) ? $SOLENG_STORAGE[$var_name] : $default;
	}
}

// Set theme variable
if (!function_exists('soleng_storage_set')) {
	function soleng_storage_set($var_name, $value) {
		global $SOLENG_STORAGE;
		$SOLENG_STORAGE[$var_name] = $value;
	}
}

// Check if theme variable is empty
if (!function_exists('soleng_storage_empty')) {
	function soleng_storage_empty($var_name, $key='', $key2='') {
		global $SOLENG_STORAGE;
		if (!empty($key) && !empty($key2))
			return empty($SOLENG_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return empty($SOLENG_STORAGE[$var_name][$key]);
		else
			return empty($SOLENG_STORAGE[$var_name]);
	}
}

// Check if theme variable is set
if (!function_exists('soleng_storage_isset')) {
	function soleng_storage_isset($var_name, $key='', $key2='') {
		global $SOLENG_STORAGE;
		if (!empty($key) && !empty($key2))
			return isset($SOLENG_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return isset($SOLENG_STORAGE[$var_name][$key]);
		else
			return isset($SOLENG_STORAGE[$var_name]);
	}
}

// Inc/Dec theme variable with specified value
if (!function_exists('soleng_storage_inc')) {
	function soleng_storage_inc($var_name, $value=1) {
		global $SOLENG_STORAGE;
		if (empty($SOLENG_STORAGE[$var_name])) $SOLENG_STORAGE[$var_name] = 0;
		$SOLENG_STORAGE[$var_name] += $value;
	}
}

// Concatenate theme variable with specified value
if (!function_exists('soleng_storage_concat')) {
	function soleng_storage_concat($var_name, $value) {
		global $SOLENG_STORAGE;
		if (empty($SOLENG_STORAGE[$var_name])) $SOLENG_STORAGE[$var_name] = '';
		$SOLENG_STORAGE[$var_name] .= $value;
	}
}

// Get array (one or two dim) element
if (!function_exists('soleng_storage_get_array')) {
	function soleng_storage_get_array($var_name, $key, $key2='', $default='') {
		global $SOLENG_STORAGE;
		if (empty($key2))
			return !empty($var_name) && !empty($key) && isset($SOLENG_STORAGE[$var_name][$key]) ? $SOLENG_STORAGE[$var_name][$key] : $default;
		else
			return !empty($var_name) && !empty($key) && isset($SOLENG_STORAGE[$var_name][$key][$key2]) ? $SOLENG_STORAGE[$var_name][$key][$key2] : $default;
	}
}

// Set array element
if (!function_exists('soleng_storage_set_array')) {
	function soleng_storage_set_array($var_name, $key, $value) {
		global $SOLENG_STORAGE;
		if (!isset($SOLENG_STORAGE[$var_name])) $SOLENG_STORAGE[$var_name] = array();
		if ($key==='')
			$SOLENG_STORAGE[$var_name][] = $value;
		else
			$SOLENG_STORAGE[$var_name][$key] = $value;
	}
}

// Set two-dim array element
if (!function_exists('soleng_storage_set_array2')) {
	function soleng_storage_set_array2($var_name, $key, $key2, $value) {
		global $SOLENG_STORAGE;
		if (!isset($SOLENG_STORAGE[$var_name])) $SOLENG_STORAGE[$var_name] = array();
		if (!isset($SOLENG_STORAGE[$var_name][$key])) $SOLENG_STORAGE[$var_name][$key] = array();
		if ($key2==='')
			$SOLENG_STORAGE[$var_name][$key][] = $value;
		else
			$SOLENG_STORAGE[$var_name][$key][$key2] = $value;
	}
}

// Merge array elements
if (!function_exists('soleng_storage_merge_array')) {
	function soleng_storage_merge_array($var_name, $key, $value) {
		global $SOLENG_STORAGE;
		if (!isset($SOLENG_STORAGE[$var_name])) $SOLENG_STORAGE[$var_name] = array();
		if ($key==='')
			$SOLENG_STORAGE[$var_name] = array_merge($SOLENG_STORAGE[$var_name], $value);
		else
			$SOLENG_STORAGE[$var_name][$key] = array_merge($SOLENG_STORAGE[$var_name][$key], $value);
	}
}

// Add array element after the key
if (!function_exists('soleng_storage_set_array_after')) {
	function soleng_storage_set_array_after($var_name, $after, $key, $value='') {
		global $SOLENG_STORAGE;
		if (!isset($SOLENG_STORAGE[$var_name])) $SOLENG_STORAGE[$var_name] = array();
		if (is_array($key))
			soleng_array_insert_after($SOLENG_STORAGE[$var_name], $after, $key);
		else
			soleng_array_insert_after($SOLENG_STORAGE[$var_name], $after, array($key=>$value));
	}
}

// Add array element before the key
if (!function_exists('soleng_storage_set_array_before')) {
	function soleng_storage_set_array_before($var_name, $before, $key, $value='') {
		global $SOLENG_STORAGE;
		if (!isset($SOLENG_STORAGE[$var_name])) $SOLENG_STORAGE[$var_name] = array();
		if (is_array($key))
			soleng_array_insert_before($SOLENG_STORAGE[$var_name], $before, $key);
		else
			soleng_array_insert_before($SOLENG_STORAGE[$var_name], $before, array($key=>$value));
	}
}

// Push element into array
if (!function_exists('soleng_storage_push_array')) {
	function soleng_storage_push_array($var_name, $key, $value) {
		global $SOLENG_STORAGE;
		if (!isset($SOLENG_STORAGE[$var_name])) $SOLENG_STORAGE[$var_name] = array();
		if ($key==='')
			array_push($SOLENG_STORAGE[$var_name], $value);
		else {
			if (!isset($SOLENG_STORAGE[$var_name][$key])) $SOLENG_STORAGE[$var_name][$key] = array();
			array_push($SOLENG_STORAGE[$var_name][$key], $value);
		}
	}
}

// Pop element from array
if (!function_exists('soleng_storage_pop_array')) {
	function soleng_storage_pop_array($var_name, $key='', $defa='') {
		global $SOLENG_STORAGE;
		$rez = $defa;
		if ($key==='') {
			if (isset($SOLENG_STORAGE[$var_name]) && is_array($SOLENG_STORAGE[$var_name]) && count($SOLENG_STORAGE[$var_name]) > 0) 
				$rez = array_pop($SOLENG_STORAGE[$var_name]);
		} else {
			if (isset($SOLENG_STORAGE[$var_name][$key]) && is_array($SOLENG_STORAGE[$var_name][$key]) && count($SOLENG_STORAGE[$var_name][$key]) > 0) 
				$rez = array_pop($SOLENG_STORAGE[$var_name][$key]);
		}
		return $rez;
	}
}

// Inc/Dec array element with specified value
if (!function_exists('soleng_storage_inc_array')) {
	function soleng_storage_inc_array($var_name, $key, $value=1) {
		global $SOLENG_STORAGE;
		if (!isset($SOLENG_STORAGE[$var_name])) $SOLENG_STORAGE[$var_name] = array();
		if (empty($SOLENG_STORAGE[$var_name][$key])) $SOLENG_STORAGE[$var_name][$key] = 0;
		$SOLENG_STORAGE[$var_name][$key] += $value;
	}
}

// Concatenate array element with specified value
if (!function_exists('soleng_storage_concat_array')) {
	function soleng_storage_concat_array($var_name, $key, $value) {
		global $SOLENG_STORAGE;
		if (!isset($SOLENG_STORAGE[$var_name])) $SOLENG_STORAGE[$var_name] = array();
		if (empty($SOLENG_STORAGE[$var_name][$key])) $SOLENG_STORAGE[$var_name][$key] = '';
		$SOLENG_STORAGE[$var_name][$key] .= $value;
	}
}

// Call object's method
if (!function_exists('soleng_storage_call_obj_method')) {
	function soleng_storage_call_obj_method($var_name, $method, $param=null) {
		global $SOLENG_STORAGE;
		if ($param===null)
			return !empty($var_name) && !empty($method) && isset($SOLENG_STORAGE[$var_name]) ? $SOLENG_STORAGE[$var_name]->$method(): '';
		else
			return !empty($var_name) && !empty($method) && isset($SOLENG_STORAGE[$var_name]) ? $SOLENG_STORAGE[$var_name]->$method($param): '';
	}
}

// Get object's property
if (!function_exists('soleng_storage_get_obj_property')) {
	function soleng_storage_get_obj_property($var_name, $prop, $default='') {
		global $SOLENG_STORAGE;
		return !empty($var_name) && !empty($prop) && isset($SOLENG_STORAGE[$var_name]->$prop) ? $SOLENG_STORAGE[$var_name]->$prop : $default;
	}
}
?>