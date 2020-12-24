<?php

/**
 * Plugin Name: Super Easy Stock Manager
 * Description: Stock Management with ease!
 * Version: 1.0
 * Author: Dan's Art
 * Author URI: http://dev.dans-art.ch
 * Text Domain: sesm
 * License: GPLv2 or later
 *
 */


/**
 * Load the classes and tools
 */
require_once('include/tools/sesm-helper.php');
require_once('include/classes/sesm.php');
require_once('include/classes/sesm-ajax.php');
//require_once('include/classes/sesm-admin.php');


$sesm = new Super_Easy_Stock_Manager();