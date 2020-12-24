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
     * Loads the Javascript and css into the head of the page
     * Modifies the script type to "module"
     *
     * @return void
     * @todo Add support for custom stylesheets in theme folder
     */
    public function enqueueScripts()
    {
        if ($this->scriptsLoaded) {
            return true;
        }
        wp_enqueue_script('sesm-app',  plugins_url('super-easy-stock-manager/scripts/sesm-app.js'), ['jquery']);
        //Set script tag "Module"
        add_filter('script_loader_tag', function ($tag, $handle, $src) {
            if ($handle === 'sesm-app') {
                return '<script type="module" src="' . esc_url($src) . '">';
            } else {
                return $tag;
            }
        }, 10, 3);
        //set the Site URL for JS
        $this->scriptsLoaded = true;
        return;
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
        add_action('wp_loaded', [$this, 'enqueueScripts']);

        //register Ajax
        add_action('wp_ajax_sesm-ajax', [$this, 'sesmAjax']);
        add_action('wp_ajax_nopriv_sesm-ajax', [$this, 'sesmAjax']);
    }
}

//Include a better debugger
require_once 'kint.phar';
