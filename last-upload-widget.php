<?php
/*
Plugin Name: Last Uploaded Images Widget
Plugin URI: http://wpgears.com/last-uploaded-images-widget/
Description: Show icons of last uploaded images on your blogs sidebar.
Author: WP Gears
Author URI: http://wpgears.com/
Version: 1.0
*/
?>
<?php
add_action('widgets_init', create_function('', 'return register_widget("attachment_widget");'));
$url = plugins_url('last-upload-widget/attach-widget-style.css');
wp_register_style('wp-attach-widget',$url);
wp_enqueue_style('wp-attach-widget');

class attachment_widget extends WP_Widget {
	function attachment_widget() {
		 parent::WP_Widget(false, $name = 'Last Uploaded Images');
	}

	function form($instance) {
		 $title = esc_attr($instance['title']);
		 $count = esc_attr($instance['count']);
		 $width = esc_attr($instance['width']);
		 $height = esc_attr($instance['height']);
        ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Items shown:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $count; ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Item width (px):'); ?> <input class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo $width; ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Item height (px):'); ?> <input class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo $height; ?>" /></label></p>
			
        <?php 
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['count'] = strip_tags($new_instance['count']);
		$instance['width'] = strip_tags($new_instance['width']);
		$instance['height'] = strip_tags($new_instance['height']);
		return $instance;
	}

	function widget($args, $instance) {		
		extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
		$count = $instance['count'];
		$width = $instance['width'];
		$height = $instance['height'];
		
		if($width == "") $width = 50;	//default values-
		if($height == "") $height = 50;
        ?>
                <?php echo $before_widget. $before_title . $title . $after_title; ?>
				<?php
					$args = array( 'post_type' => 'attachment', 'numberposts' => $count, 'post_status' => null, 'post_mime_type' => 'image' ); 
					$attachments = get_posts($args);
					if ($attachments) {
							?>
								<div class="attachment-widget-container">
							<?php
							
							foreach($attachments as $attach) {
								$image = wp_get_attachment_link($attach->ID,array($width,$height));
								echo $image;
							}
							
							?>
								</div>
							<?php
					}
				?>
				<?php echo $after_widget; ?>
        <?php
	}
}
?>