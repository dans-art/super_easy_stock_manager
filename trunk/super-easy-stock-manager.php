<?php

/**
 * Plugin Name: Super Easy Stock Manager
 * Description: Stock Management with ease!
 * Version: 0.1
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
require_once('include/classes/sesm-admin.php');


add_action('wp_loaded', 'sesmRun');

/**
 * Runs the Plugin
 */
function sesmRun()
{
    $sesm = new Super_Easy_Stock_Manager();
    //$sesm->sesm_admin_init();
}
