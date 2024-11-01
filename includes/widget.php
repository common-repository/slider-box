<?php
/*
 * Author: http://photoboxone.com/
 */
defined('ABSPATH') or die('<meta http-equiv="refresh" content="0;url='.WP_SB_URL_AUTHOR.'">');

class Slider_Box_Widget extends WP_Widget {
	
	public function __construct() {
		parent::__construct( 'slider_box_widget', 'Slider Box', $widget_options = array(
			'classname'   => 'slider_box_widgets',
			'description' => "Show an slider inside of a widget."
		));
	}

	public function widget( $args, $instance ) {
		
		$title  	= apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$show_title = empty( $instance['show_title'] ) ? 0 : absint( $instance['show_title'] );
		$category 	= absint($instance['category']);		
		if( $category>0 && function_exists('pll_current_language') ){
			$translated_category = (int)pll_get_term($category, pll_current_language());
			if( $translated_category>0 ){
				$category = $translated_category;
			}
		}
		$displays 	= absint($instance['displays']);
		$width 		= empty( $instance['width'] ) ? '100%' : $instance['width'];
		$height 	= empty( $instance['height'] ) ? '200px' : $instance['height'];
		
		
		echo $args['before_widget'];
		
		if ( $title != '' && $show_title ) :
			echo $args['before_title'].$title.$args['after_title'];
		endif;
		
		$posts = get_posts(array(
			'category' 		=> $category,
			'posts_per_page' => $displays,
			'offset' => 0,
		));
		
		if( $count = count($posts) ):
			/*<div class="list-posts" data-options="'speed':400,'width':'<?php echo $width;?>','height':'<?php echo $height;?>'">*/
		?>
		<div class="jslider clearfix">
			<div class="list-posts clearfix">
				<ul class="list-posts-content clearfix"><?php
					foreach($posts as $_i => $p) : 
						
					?><li class="item-<?php echo $_i+1;?>">
						<a href="<?php echo get_the_permalink($p->ID); ?>" rel="bookmark">
							<span class="post-image"><?php echo wp_get_attachment_image( get_post_thumbnail_id($p->ID), $size == 'thumbnail', $icon = null, $attr = array('alt' => $p->post_title ) ) ;?></span>
							<span class="post-title"><?php echo get_the_title($p->ID); ?></span>
						</a>
					</li><?php
					endforeach;
				?></ul>
			</div>
			<div class="arrow-navi">
				<ul class="clearfix">
					<li class="arrow-left arrow">
						<a href="#"><i class="fa fa-angle-left"></i></a>
					</li>
					<li class="arrow-right arrow">
						<a href="#"><i class="fa fa-angle-right"></i></a>
					</li>
				</ul>
			</div>
		</div>
		<?php
		endif;
		
		echo $args['after_widget'];
		
	}
	
	function update( $new_instance, $instance ) {
		$instance['title']  	= strip_tags( $new_instance['title'] );
		$instance['show_title'] = empty( $new_instance['show_title'] ) ? 0 : absint($new_instance['show_title']);
		$instance['before'] 	= empty( $new_instance['before'] ) ? '' : $new_instance['before'];
		$instance['after'] 		= empty( $new_instance['after'] ) ? '' : $new_instance['after'];
		$instance['width'] 		= empty( $new_instance['width'] ) ? '' : $new_instance['width'];
		$instance['height'] 	= empty( $new_instance['height'] ) ? '' : $new_instance['height'];
		$instance['category']  	= absint($new_instance['category']);
		$instance['displays']  	= absint($new_instance['displays']);
		
		return $instance;
	}

	function form( $instance ) {
		$title  	= apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$show_title = empty( $instance['show_title'] ) ? 0 : absint( $instance['show_title'] );
		$before 	= empty( $instance['before']) ? '' : $instance['before'];
		$after 		= empty( $instance['after']) ? '' : $instance['after'];
		$category 	= absint($instance['category']);
		$displays	= empty( $instance['displays'] ) ? 3 : absint( $instance['displays'] );
		$width 		= empty( $instance['width'] ) ? '100%' : $instance['width'];
		$height 	= empty( $instance['height'] ) ? '200px' : $instance['height'];
		
		?>
			<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:' ); ?></label></p>
			<p><input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>" /></p>
			<p><input type="checkbox" value="1" id="<?php echo esc_attr( $this->get_field_id( 'show_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_title' ) ); ?>" <?php echo $show_title?'checked':'';?> /><label for="<?php echo esc_attr( $this->get_field_id( 'show_title' ) ); ?>"><?php _e( 'Show Title' ); ?></label></p>
			
			<p><label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"><?php _e( 'Category:' ); ?></label>
			<p><select id="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>" class="jchosen" name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>">
			<?php $items = get_categories(array('hide_empty'=>0));
			foreach($items as $item):?>
				<option value="<?php echo $item->term_id;?>" <?php selected( $item->term_id, $category);?>><?php echo $item->cat_name;?></option>
			<?php endforeach;?>
			</select></p>
			<p><label for="<?php echo $this->get_field_id( 'displays' ); ?>"><?php _e( 'Display' ); ?>:</label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'displays' ); ?>" name="<?php echo $this->get_field_name( 'displays' ); ?>" type="text" value="<?php echo $displays; ?>"  style="width:70px;"/></p>
			<p><label for="<?php echo $this->get_field_id( 'width' ); ?>"><?php _e( 'Width' ); ?>:</label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" type="text" value="<?php echo $width; ?>"  style="width:70px;"/></p>
			<p><label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php _e( 'Height' ); ?>:</label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" type="text" value="<?php echo $height; ?>"  style="width:70px;"/></p>
		<?php
		
	}
	
}

// setup widget
add_action( 'widgets_init', function(){
	register_widget( 'Slider_Box_Widget' );
});