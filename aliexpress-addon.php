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

    private function __construct()
    {
        add_action('add_meta_boxes', [$this, 'add_meta_boxes']);
        add_action('save_post_product', [$this, 'save_post_product'], 10, 3);
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

    public function save_post_product($post_id, $post, $update){
        if (empty($_POST['aliexpress-product-id'])) {
            delete_post_meta($post_id, '_vi_wad_aliexpress_product_id');
        } else {
            update_post_meta($post_id, '_vi_wad_aliexpress_product_id', $_POST['aliexpress-product-id']);
        }
    }

    public function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}

$GLOBALS['Aliexpress_Addon'] = Aliexpress_Addon::getInstance();