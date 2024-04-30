<?php
/**
 * @package Gather Community
 * 
 */

 /*
Plugin Name: Gather Community
Plugin URI: https://nodomain.com
Description: Does not have any description right now
Version: 1.0.0
Author: Sapere Marketing
Author URI: https://saperemarketing.com
License: GPLv2 or later
Text Domain: gather-community-plugin
*/

defined( 'ABSPATH' ) or die('You are not authorize to access this page.');

if( file_exists( dirname(__FILE__) ) . '/vendor/autoload.php') {
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}

use Includes\Base\GatherActivate;
use Includes\Base\GatherDeactivate;

defined( 'ABSPATH' ) or die('You are not authorize to access this page.');

if( file_exists( dirname(__FILE__) ) . '/vendor/autoload.php') {
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}

function activate_gather() {
    GatherActivate::activate();
}

function deactivate_gather() {
    GatherDeactivate::deactivate();
}

register_activation_hook( __FILE__ , 'activate_gather' );
register_deactivation_hook( __FILE__ , 'deactivate_gather' );

if( class_exists( 'Includes\\Init' ) ) {
    Includes\Init::register_services();
}