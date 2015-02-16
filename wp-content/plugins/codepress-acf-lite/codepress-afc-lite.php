<?php
/*
Plugin Name: 		Codepress ACF Lite
Version: 			1.0.0
Description: 		Loads ACF fieldgroups and fields using PHP declaration
Author: 			Codepress
Author URI: 		http://www.codepress.nl
Plugin URI: 		http://www.codepress.nl
*/

if ( ! defined( 'ACF_LITE' ) ) {
    define( 'ACF_LITE', true );
}

require_once 'fields.php';