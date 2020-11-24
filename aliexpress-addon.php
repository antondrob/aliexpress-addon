<?php
/**
 * Plugin Name:       Aliexpress Addon
 * Description:       Connect existing WooCommerce products with Aliexpress products
 * Version:           1.0.0
 * Requires at least: 5.0
 * Requires PHP:      7.0
 * Author:            Anton Drobyshev
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       my-basics-plugin
 * Domain Path:       /languages
 */

namespace Aliexpress_Addon;
class Aliexpress_Addon
{
    private static $instance = null;

    public static $plugin_url;

    public static $plugin_path;

    private function __construct()
    {
        self::$plugin_url = plugin_dir_url(__FILE__);
        self::$plugin_path = plugin_dir_path(__FILE__);

        add_action('add_meta_boxes', [$this, 'add_meta_boxes']);
        add_action('save_post_product', [$this, 'save_post_product'], 10, 3);
        add_action('woocommerce_variation_options', [$this, 'woocommerce_variation_options'], 10, 3);
        add_action('woocommerce_save_product_variation', [$this, 'woocommerce_save_product_variation'], 10, 2);
        add_action('admin_enqueue_scripts', [$this, 'admin_enqueue_scripts']);
    }

    private function __clone()
    {

    }

    private function __wakeup()
    {

    }

    public function add_meta_boxes()
    {
        add_meta_box('aliexpress-product-id', 'Aliexpress Addon', [$this, 'aliexpress_addon_callback'], ['product'], 'side', 'core');
    }

    public function aliexpress_addon_callback($post, $meta)
    {
        include_once 'template-parts/admin/html-aliexpress-addon-metabox.php';
    }

    public function save_post_product($post_id, $post, $update)
    {
        if (empty($_POST['aliexpress-product-id']))
            delete_post_meta($post_id, '_vi_wad_aliexpress_product_id');
        else
            update_post_meta($post_id, '_vi_wad_aliexpress_product_id', $_POST['aliexpress-product-id']);
        if (empty($_POST['parent_aliexpress_variation_id']))
            delete_post_meta($post_id, '_vi_wad_aliexpress_variation_id');
        else
            update_post_meta($post_id, '_vi_wad_aliexpress_variation_id', $_POST['parent_aliexpress_variation_id']);
        if (empty($_POST['parent_aliexpress_variation_attr']))
            delete_post_meta($post_id, '_vi_wad_aliexpress_variation_attr');
        else
            update_post_meta($post_id, '_vi_wad_aliexpress_variation_attr', $_POST['parent_aliexpress_variation_attr']);
    }

    public function woocommerce_variation_options($loop, $variation_data, $variation)
    {
        woocommerce_wp_text_input(array(
            'id' => '_vi_wad_aliexpress_variation_id[' . $loop . ']',
            'class' => 'short',
            'wrapper_class' => 'form-row form-row-first',
            'label' => __('Aliexpress Variation ID', 'woocommerce'),
            'value' => get_post_meta($variation->ID, '_vi_wad_aliexpress_variation_id', true)
        ));
        woocommerce_wp_text_input(array(
            'id' => '_vi_wad_aliexpress_variation_attr[' . $loop . ']',
            'class' => 'short',
            'wrapper_class' => 'form-row form-row-last',
            'label' => __('Aliexpress Variation Attribute', 'woocommerce'),
            'value' => get_post_meta($variation->ID, '_vi_wad_aliexpress_variation_attr', true)
        ));
    }

    public function woocommerce_save_product_variation($variation_id, $i)
    {
        $_vi_wad_aliexpress_variation_id = $_POST['_vi_wad_aliexpress_variation_id'][$i];
        if (!empty($_vi_wad_aliexpress_variation_id)) {
            update_post_meta($variation_id, '_vi_wad_aliexpress_variation_id', esc_attr($_vi_wad_aliexpress_variation_id));
        } else delete_post_meta($variation_id, '_vi_wad_aliexpress_variation_id');

        $_vi_wad_aliexpress_variation_attr = $_POST['_vi_wad_aliexpress_variation_attr'][$i];
        if (!empty($_vi_wad_aliexpress_variation_attr)) {
            update_post_meta($variation_id, '_vi_wad_aliexpress_variation_attr', esc_attr($_vi_wad_aliexpress_variation_attr));
        } else delete_post_meta($variation_id, '_vi_wad_aliexpress_variation_attr');
    }

    public function admin_enqueue_scripts()
    {
        wp_enqueue_script('op-dev-product', self::$plugin_url . 'assets/js/admin/product.js', ['jquery'], filemtime(self::$plugin_path . 'assets/js/admin/product.js'), true);
        wp_enqueue_style('op-dev-product', self::$plugin_url . 'assets/css/admin/product.css', [], filemtime(self::$plugin_path . 'assets/js/admin/product.js'));
        wp_localize_script('op-dev-product', 'ali', [
            'ajaxUrl' => admin_url('admin-ajax.php')
        ]);
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}

$GLOBALS['Aliexpress_Addon'] = Aliexpress_Addon::getInstance();