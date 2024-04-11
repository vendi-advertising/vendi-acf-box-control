<?php
/**
 * Plugin Name: Vendi ACF Box Control
 * Contributors: chrisvendiadvertisingcom
 * Tags: acf, field,
 * Requires at least: 6.0
 * Requires PHP: 8.0
 * Tested up to: 6.5
 * Stable tag: 1.0.0
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// Define.
const VENDI_ACF_BOX_CONTROL_VERSION = '1.0.0';
define('VENDI_ACF_BOX_CONTROL_BASENAME', basename(__DIR__));
define('VENDI_ACF_BOX_CONTROL_DIR', rtrim(plugin_dir_path(__FILE__), '/'));
define('VENDI_ACF_BOX_CONTROL_URL', rtrim(plugin_dir_url(__FILE__), '/'));

add_action(
    'acf/include_field_types',
    static function () {
        load_plugin_textdomain('vendi-acf-box-control');

        require_once VENDI_ACF_BOX_CONTROL_DIR.'/fields/class-vendi-acf-field-boxControl-v5.php';

        $settings = array(
            'version' => VENDI_ACF_BOX_CONTROL_VERSION,
            'url' => plugin_dir_url(__FILE__),
            'path' => plugin_dir_path(__FILE__),
        );

        new Vendi_ACF_Field_Box_Control($settings);
    }
);
