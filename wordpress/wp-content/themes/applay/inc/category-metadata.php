<?php
/* Category custom field */
add_action( 'category_add_form_fields', 'ia_extra_category_fields', 10 );
add_action ( 'edit_category_form_fields', 'ia_extra_category_fields');
function ia_extra_category_fields( $tag ) {    //check for existing featured ID
    $t_id = $tag->term_id?$tag->term_id:'';
    $cat_layout = get_option( "cat_layout_$t_id")?get_option( "cat_layout_$t_id"):'';
?>
	<tr class="form-field">
		<th scope="row" valign="top">
			<label for="category-layout"><?php _e('Category Layout','leafcolor'); ?></label>
		</th>
		<td>
            <select name="category-layout" id="category-layout">
                <option value=0 <?php if($cat_layout==0){?> selected="selected" <?php }?> ><?php _e('Default','leafcolor') ?></option>
                <option value="video" <?php if($cat_layout=='video'){?> selected="selected" <?php }?>><?php _e('Video listing (Grid)','leafcolor') ?></option>
                <option value="blog" <?php if($cat_layout=='blog'){?> selected="selected" <?php } ?>><?php _e('Blog listing','leafcolor') ?></option>
            </select>
			<p class="description"><?php _e('Choose layout listing for this category page','leafcolor'); ?></p>
		</td>
	</tr>
<?php
if(function_exists('z_taxonomy_image_url')){ //if has category images plugin
	//cat banner
	$cat_header = get_option( "cat_header_$t_id")?get_option( "cat_header_$t_id"):'';
	$cat_height = get_option( "cat_height_$t_id")?get_option( "cat_height_$t_id"):'';
	$cat_link = get_option( "cat_link_$t_id")?get_option( "cat_link_$t_id"):'';
	?>
    <tr class="form-field">
		<th scope="row" valign="top">
			<label for="category-header"><?php _e('Category Header Style','leafcolor'); ?></label>
		</th>
		<td>
            <select name="category-header" id="category-header">
                <option value=0 <?php if($cat_header==0){ ?> selected="selected" <?php } ?> ><?php _e('Default','leafcolor') ?></option>
                <option value="carousel" <?php if($cat_header=='carousel'){?> selected="selected" <?php }?>><?php _e('Carousel','leafcolor') ?></option>
                <option value="banner" <?php if($cat_header=='banner'){?> selected="selected" <?php }?>><?php _e('Banner Image','leafcolor') ?></option>
                <option value="hide" <?php if($cat_header=='hide'){ ?> selected="selected" <?php }?>><?php _e('Do not show','leafcolor') ?></option>
            </select>
			<p class="description"><?php _e('Choose header style for this category page (Need upload image if you use Banner)','leafcolor'); ?></p>
		</td>
	</tr>
    <tr class="form-field">
		<th scope="row" valign="top">
			<label for="category-height"><?php _e('Category Banner Height','leafcolor'); ?></label>
		</th>
		<td>
        	<input type="number" name="category-height" id="category-height" value="<?php echo $cat_height ?>" />
			<p class="description"><?php _e('Enter banner height for this category page (in px, ex: 300)','leafcolor'); ?></p>
		</td>
	</tr>
    <tr class="form-field">
		<th scope="row" valign="top">
			<label for="category-link"><?php _e('Category Banner Link','leafcolor'); ?></label>
		</th>
		<td>
        	<input type="text" name="category-link" id="category-link" value="<?php echo esc_attr($cat_link) ?>" />
			<p class="description"><?php _e('Enter URL for this category banner','leafcolor'); ?></p>
		</td>
	</tr>
    <?php
}//if has category images plugin
}
//save extra category extra fields hook
add_action ( 'edited_category', 'ia_save_extra_category_fileds');
add_action( 'created_category', 'ia_save_extra_category_fileds', 10, 2 );
function ia_save_extra_category_fileds( $term_id ) {
    if ( isset( $_POST['category-layout'] ) ) {
        $cat_layout = $_POST['category-layout'];
        update_option( "cat_layout_$term_id", $cat_layout );
    }
	if ( isset( $_POST['category-header'] ) ) {
        $cat_header = $_POST['category-header'];
        update_option( "cat_header_$term_id", $cat_header );
    }
	if ( isset( $_POST['category-height'] ) ) {
        $cat_height = $_POST['category-height'];
        update_option( "cat_height_$term_id", $cat_height );
    }
	if ( isset( $_POST['category-link'] ) ) {
        $cat_link = $_POST['category-link'];
        update_option( "cat_link_$term_id", $cat_link );
    }
}