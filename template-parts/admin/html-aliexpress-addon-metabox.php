<label for="aliexpress-product-id">Aliexpress Product ID</label>
<input type="text" name="aliexpress-product-id" id="aliexpress-product-id"
       value="<?php echo get_post_meta($post->ID, '_vi_wad_aliexpress_product_id', true) ?? ''; ?>">