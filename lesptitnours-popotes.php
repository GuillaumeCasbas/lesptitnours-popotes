<?php

/**
 * @package LesptinoursPopotes
 * @author Guillaume Casbas
 * 
 * Plugin Name:       LesPtitnours Popotes
 * Plugin URI:        https://github.com/guillaumecasbas/lesptitnours-popotes
 * Description:       A plugin for managing our recipes
 * Version:           0.1.0
 * Requires at least: 6.7
 * Requires PHP:      8
 * Author:            Guillaume Casbas
 * Author URI:        https://www.guillaumecasbas.fr
 * License:           MIT
 * License URI:       https://opensource.org/license/mit
 * Text Domain:       lesptitbours-popotes
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}

require_once(plugin_dir_path(__FILE__) . 'lib/autoload.php');

if (! class_exists('LesptitnoursPopote')) {
    class LesptinoursPopotes
    {

        public string $version = '0.1.0';

        public array $settings = array();

        public function init()
        {
            // constants if needed
            $this->define('LPNP_VERSION', $this->version);

            register_activation_hook(__FILE__, array($this, 'plugin_activated'));

            $this->settings = array(
                //
            );

            if (is_admin()) {
            }


            add_action('init', array($this, 'register_post_types'));
        }

        public function getSetting(string $name)
        {
            // TODO Implement this
        }

        public function register_post_types()
        {
            $labels = array(
                'name'               => __('Recipe', 'lesptitnours'),
                'singular_name'      => __('Recipies', 'lesptitnours'),
                'add_new'            => __('Add new', 'lesptitnours'),
                'add_new_item'       => __('Add new recipe', 'lesptitnours'),
                'edit_item'          => __('Edit recipe', 'lesptitnours'),
                'new_item'           => __('New recipe', 'lesptitnours'),
                'view_item'          => __('View recipe', 'lesptitnours'),
                'view_items'         => __('View recipies', 'lesptitnours'),
                'search_items'       => __('Search recipies', 'lesptitnours'),
                'not_found'          => __('No recipe found', 'lesptitnours'),
                'not_found_in_trash' => __('No recipe found in trash', 'lesptitnours'),
                'all_items'          => __('All recipies', 'lesptitnours'),
                'archives'           => __('Recipies archive', 'lesptitnours'),
                'attributes'         => __('Recipe attributes', 'lesptitnours'),
                'items_list'         => __('Recipe list', 'lesptitnours'),
                'item_published'     => __('Recipe published', 'lesptitnours'),
                'item_trashed'       => __('Recipe trashed', 'lesptitnours'),
            );
            $args = array(
                'labels'            => $labels,
                'public'            => true,
                'has_archive'       => true,
                'show_in_admin_bar' => true,
                'show_in_rest'      => false,
                'menu_icon'         => 'dashicons-food',
                'menu_position'     => 5,
                'supports'          => ['title', 'editor', 'author', 'thumbnail', 'comments'],
                'taxonomies'        => array( 'category', 'post_tags' ),
                'rewrite'           => ['slug' => 'popote']
            );

            register_post_type('ptitnours_popote', $args);
        }

        public function plugin_activated()
        {
            if (null === get_option('lpnp_first_activated_version', null)) {
                // If acf_version is set, this isn't the first activated version, so leave it unset so it's legacy.
                if (null === get_option('lpnp_version', null)) {
                    update_option('lpnp_first_activated_version', LPNP_VERSION, true);
                }

                update_option('lpnp_version', $this->version);
            }
        }

        private function define($name, $value = true)
        {
            if (! defined($name)) {
                define($name, $value);
            }
        }
    }


    function lpnPopote()
    {
        global $lpnPopote;

        if (! isset($lpnPopote)) {
            $lpnPopote = new LesptinoursPopotes();
            $lpnPopote->init();
        }

        return $lpnPopote;
    }

    lpnPopote();
}
