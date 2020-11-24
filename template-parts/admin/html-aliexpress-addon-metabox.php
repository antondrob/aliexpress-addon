<label for="aliexpress-product">Aliexpress Product ID</label>
<input type="text" name="aliexpress-product-id" id="aliexpress-product"
       value="<?php echo get_post_meta($post->ID, '_vi_wad_aliexpress_product_id', true) ?? ''; ?>">
<button type="button" class="button" id="ali-data">Get data</button>
<br>
<label for="aliexpress-product-id">Aliexpress Variation ID</label>
<input type="text" name="_vi_wad_aliexpress_variation_id" id="_vi_wad_aliexpress_variation_id"
       value="<?php echo get_post_meta($post->ID, '_vi_wad_aliexpress_variation_id', true) ?? ''; ?>">
<br>
<label for="aliexpress-product-id">Aliexpress Variation Attribute</label>
<input type="text" name="_vi_wad_aliexpress_variation_attr" id="_vi_wad_aliexpress_variation_attr"
       value="<?php echo get_post_meta($post->ID, '_vi_wad_aliexpress_variation_attr', true) ?? ''; ?>">

<div id="aliexpress-api-data"></div>