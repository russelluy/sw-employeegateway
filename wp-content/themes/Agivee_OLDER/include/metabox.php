<?php

function agivee_post_meta_boxes() {

  $meta_boxes = array(
    "image_thumbnail" => array(
      "name" => "_image_thumbnail",
      "title" => "Image thumbnail",
      "description" => "Add thumbnail image url for your post, will be use for Blog and Portfolio Category.",
      "type" => "text"
    ),
    "portfolio_link" => array(
      "name" => "_portfolio_link",
      "title" => "Detail link",
      "description" => "please enter image or video url here, will be used for  pop up lightbox and single page.<br/>Images : <br />http://wp-demo.indonez.com/Agivee/wp-content/uploads/2010/07/image.jpg<br/> Video : <br />
      http://www.youtube.com/watch?v=tESK9RcyexU<br />
      http://vimeo.com/12816548<br />
      http://wp-demo.indonez.com/Agivee/wp-content/uploads/2010/07/sample.3gp<br />
      http://wp-demo.indonez.com/Agivee/wp-content/uploads/2010/07/sample.mp4<br />
      http://wp-demo.indonez.com/Agivee/wp-content/uploads/2010/07/sample.mov<br />
      http://www.adobe.com/jp/events/cs3_web_edition_tour/swfs/perform.swf?width=680&height=405<br />
      Note : for swf movie, you need to specify the width and height for movie, as above example",
      "type" => "text"
    )      
  );

	return apply_filters( 'agivee_post_meta_boxes', $meta_boxes );
}

function agivee_page_meta_boxes() {

  $meta_boxes = array(
    "page_thumbnail_image" => array(
      "name" => "_page_thumbnail_image",
      "title" => "Thumbnail Image",
      "description" => "Add thumbnail image url, will be use for your page thumbnail, for example in Services child pages list.",
      "type" => "text"
    ),
    "short_desc" => array(
      "name" => "_short_desc",
      "title" => "Short Description",
      "description" => "Add short description to your pages.",
      "type" => "textarea"
    )    
  );

	return apply_filters( 'agivee_page_meta_boxes', $meta_boxes );
}

function post_meta_boxes() {
	global $post;
	$meta_boxes = agivee_post_meta_boxes(); ?>

	<table class="form-table">
	<?php foreach ( $meta_boxes as $meta ) :

		$value = get_post_meta( $post->ID, $meta['name'], true );

		if ( $meta['type'] == 'text' )
			get_meta_text_input( $meta, $value );
		elseif ( $meta['type'] == 'textarea' )
			get_meta_textarea( $meta, $value );
		elseif ( $meta['type'] == 'select' )
			get_meta_select( $meta, $value );

	endforeach; ?>
	</table>
<?php
}

function page_meta_boxes() {
	global $post;
	$meta_boxes = agivee_page_meta_boxes(); ?>

	<table class="form-table">
	<?php foreach ( $meta_boxes as $meta ) :

		$value = stripslashes( get_post_meta( $post->ID, $meta['name'], true ) );

		if ( $meta['type'] == 'text' )
			get_meta_text_input( $meta, $value );
		elseif ( $meta['type'] == 'textarea' )
			get_meta_textarea( $meta, $value );
		elseif ( $meta['type'] == 'select' )
			get_meta_select( $meta, $value );

	endforeach; ?>
	</table>
<?php
}

function get_meta_text_input( $args = array(), $value = false ) {

	extract( $args ); ?>

	<tr>
		<th style="width:10%;">
			<label for="<?php echo $name; ?>"><?php echo $title; ?></label>
		</th>
		<td>
			<input type="text" name="<?php echo $name; ?>" id="<?php echo $name; ?>" value="<?php echo wp_specialchars( $value, 1 ); ?>" size="30" tabindex="30" style="width: 97%;" /><br /><small><?php echo $args['description']; ?></small>
			<input type="hidden" name="<?php echo $name; ?>_noncename" id="<?php echo $name; ?>_noncename" value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>" />
		</td>
	</tr>
	<?php
}

function get_meta_select( $args = array(), $value = false ) {

	extract( $args ); ?>

	<tr>
		<th style="width:10%;">
			<label for="<?php echo $name; ?>"><?php echo $title; ?></label>
		</th>
		<td>
			<select name="<?php echo $name; ?>" id="<?php echo $name; ?>">
			<?php foreach ( $options as $option ) : ?>
				<option <?php if ( htmlentities( $value, ENT_QUOTES ) == $option ) echo ' selected="selected"'; ?>>
					<?php echo $option; ?>
				</option>
			<?php endforeach; ?>
			</select><br /><small><?php echo $args['description']; ?></small>
			<input type="hidden" name="<?php echo $name; ?>_noncename" id="<?php echo $name; ?>_noncename" value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>" />
		</td>
	</tr>
	<?php
}


function get_meta_textarea( $args = array(), $value = false ) {

	extract( $args ); ?>

	<tr>
		<th style="width:10%;">
			<label for="<?php echo $name; ?>"><?php echo $title; ?></label>
		</th>
		<td>
			<textarea name="<?php echo $name; ?>" id="<?php echo $name; ?>" cols="60" rows="4" tabindex="30" style="width: 97%;"><?php echo wp_specialchars( $value, 1 ); ?></textarea><br /><small><?php echo $args['description']; ?></small>
			<input type="hidden" name="<?php echo $name; ?>_noncename" id="<?php echo $name; ?>_noncename" value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>" />
		</td>
	</tr>
	<?php
}

function agivee_create_meta_box() {
	global $theme_name;

	add_meta_box( 'post-meta-boxes', __('Post options'), 'post_meta_boxes', 'post', 'normal', 'high' );
	add_meta_box( 'page-meta-boxes', __('Page options'), 'page_meta_boxes', 'page', 'normal', 'high' );
}

function agivee_save_meta_data( $post_id ) {
	global $post;

	if ( 'page' == $_POST['post_type'] )
		$meta_boxes = array_merge( agivee_page_meta_boxes() );
	else
		$meta_boxes = array_merge( agivee_post_meta_boxes() );
		
	foreach ( $meta_boxes as $meta_box ) :

		if ( !wp_verify_nonce( $_POST[$meta_box['name'] . '_noncename'], plugin_basename( __FILE__ ) ) )
			return $post_id;

		if ( 'page' == $_POST['post_type'] && !current_user_can( 'edit_page', $post_id ) )
			return $post_id;

		elseif ( 'post' == $_POST['post_type'] && !current_user_can( 'edit_post', $post_id ) )
			return $post_id;

		$data = stripslashes( $_POST[$meta_box['name']] );

		if ( get_post_meta( $post_id, $meta_box['name'] ) == '' )
			add_post_meta( $post_id, $meta_box['name'], $data, true );

		elseif ( $data != get_post_meta( $post_id, $meta_box['name'], true ) )
			update_post_meta( $post_id, $meta_box['name'], $data );

		elseif ( $data == '' )
			delete_post_meta( $post_id, $meta_box['name'], get_post_meta( $post_id, $meta_box['name'], true ) );

	endforeach;
}



/* Add a new meta box to the admin menu. */
	add_action( 'admin_menu', 'agivee_create_meta_box' );

/* Saves the meta box data. */
	add_action( 'save_post', 'agivee_save_meta_data' );

?>