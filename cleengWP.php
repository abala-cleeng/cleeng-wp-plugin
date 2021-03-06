<?php
/*
  Plugin Name: Cleeng for WordPress
  Plugin URI: http://cleeng.com/?utm_source=WP&utm_medium=Link&utm_campaign=setting_page
  Version: 2.2.9
  Description: Cleeng helps you to make money with your WordPress content. The Cleeng plugin offers a single-click pay as you go solution to your website visitors; it avoids the hassle of multiple subscriptions. When publishing a post or page you as the publisher can define for which part of your content visitors need to pay (in between 0.14 and 19.99$/€). 1. <a href="http://cleeng.com/us/publisher-registration">Activate your account</a> and 2. See examples on how to best use Cleeng.
  Author: Cleeng
  Author URI: http://cleeng.com/?utm_source=WP&utm_medium=Link&utm_campaign=setting_page
  License: New BSD License (http://cleeng.com/license/new-bsd.txt)
 */

/**
 * Plugin bootstrap
 */

// setup URL for assets
if (!defined('CLEENG_PLUGIN_URL')) {
    define('CLEENG_PLUGIN_URL',
            WP_PLUGIN_URL . '/' . str_replace(basename(__FILE__), "", plugin_basename(__FILE__)));
}
//echo CLEENG_PLUGIN_URL; die;
if (!class_exists('Cleeng_Core')) { // check if another instance of Cleeng For WordPress is already activated
    // load translations
    load_plugin_textdomain('cleeng', false, dirname(plugin_basename(__FILE__)) . '/languages/');

    // load and setup Cleeng_Core class,
    require_once dirname(__FILE__) . '/php/classes/Core.php';
    Cleeng_Core::get_instance()->setup();

    // register activation hook - it must be dont inside this file
    register_activation_hook(__FILE__, array('Cleeng_Core', 'activate'));
    register_deactivation_hook(__FILE__, array('Cleeng_Core', 'deactivate'));
} else {
    if (!function_exists('cleeng_multiple_instance_warning')) {
        function cleeng_multiple_instance_warning()
        {
            echo '<div class="updated">';
            echo '<p>Warning: you have multiple instances of Cleeng For WordPress installed. All additional installations will be disabled.</p>';
            echo '</div>';
        }

        add_action('admin_notices', 'cleeng_multiple_instance_warning');
    }
}
