<?php

/**
 * Plugin Name: Super Easy Stock Manager
 * Class description: Various helper methods.
 * Author: Dan's Art
 * Author URI: http://dev.dans-art.ch
 *
 */

class Super_Easy_Stock_Manager_Helper
{
    protected $version = '0.1';
    protected $scriptsLoaded = false;
    //public $admin_notices = array();

    public function __construct()
    {
    }

    /**
     * Loads the translation of the plugin.
     * Located at: plugins/super-easy-stock-manager/languages/
     *
     * @return void
     */
    public function sesm_load_textdomain()
    {
        load_textdomain('sesm', WP_PLUGIN_DIR . '/super-easy-stock-manager/languages/sesm-' . determine_locale() . '.mo');
    }

    /**
     * Gets a file and transport some data to use.
     *
     * @param [type] $file
     * @param array $data
     * @return void
     */
    public function loadTemplate($file, $data = array())
    {
        ob_start();
        require($file);
        return ob_get_clean();
    }

    /**
     * Gets the Plugin Path. From the current Theme (/notify-me/templates/) or from the Plugin
     * Structure is the same for plugin an theme
     *
     * @param  string $name - Name of the template file to load
     * @param  string $path - Path to the templates files. Default: templates/theme/
     * @return false on error, path on success
     */
    public function getTemplate($name, $path = 'templates/theme/')
    {
        return WP_PLUGIN_DIR . '/super-easy-stock-manager/templates/theme/' . $name . '.php';
    }

    /**
     * Adds the Actions to WP to load Textdomain and register ajax
     *
     * @return void
     */
    public function addActions()
    {
        //load language 
        add_action('init', [$this, 'sesm_load_textdomain']);

        //register Ajax
        add_action('wp_ajax_sesm-ajax', [$this, 'sesmAjax']);
        add_action('wp_ajax_nopriv_sesm-ajax', [$this, 'sesmAjax']);

        add_action('template_redirect',  [$this, 'templateRedirect']);
    }

    public function templateRedirect()
    {
        global $wp_query;
        if (isset($wp_query->query_vars['name']) and $wp_query->query_vars['name'] === 'sesm') {
            if (!is_user_logged_in()) {
                auth_redirect();
                die();
            }
            if (!current_user_can('edit_products')) {
                header("HTTP/1.1 200 OK");
                echo __('You are not allowed to edit products!', 'sesm');
                echo '<br/><a href="'.wp_logout_url().'">'.__('Logout', 'sesm').'</a>';
                die();
            }
            header("HTTP/1.1 200 OK");
            include $this->getTemplate('frontend');
        } else {
            return;
        }
        die;
    }
}

//Include a better debugger
require_once 'kint.phar';
