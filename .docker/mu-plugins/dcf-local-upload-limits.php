<?php
/**
 * Plugin Name: DCF Local Upload Limits
 * Description: Local-only upload limit helper for large migration backups.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'DCF_LOCAL_UPLOAD_LIMIT' ) ) {
	define( 'DCF_LOCAL_UPLOAD_LIMIT', 10 * GB_IN_BYTES );
}

add_filter( 'upload_size_limit', function() {
	return DCF_LOCAL_UPLOAD_LIMIT;
}, 999 );

add_filter( 'admin_memory_limit', function() {
	return '2048M';
}, 999 );

add_filter( 'ai1wm_max_file_size', function() {
	return DCF_LOCAL_UPLOAD_LIMIT;
}, 999 );
