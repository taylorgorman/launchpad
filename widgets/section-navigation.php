<?php
/*
** Make widget
*/
add_action( 'widgets_init', function() {
	register_widget( 'Section_Navigation' );
} );

class Section_Navigation extends WP_Widget {

	function __construct() {
		parent::__construct(
			false
		, 'Section Navigation'
		,	array(
				'description' => 'Contextually aware menu'
			)
		);
	}

	function widget( $args, $instance ) {

		$list_items = bs_list_contextually();
		if ( empty($list_items) )
			return;

		echo $args['before_widget'];
		echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];

		echo '<ul>'. $list_items .'</ul>';

		echo $args['after_widget'];

	}

	/* Seems like this is really only necessary if you want to manipulate the inputs
	**
	public function update( $new_instance, $old_instance ) {

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['message'] = strip_tags( $new_instance['message'] );

		return $instance;

	}
	*/

	public function form( $instance ) {

		$title  = esc_attr( $instance['title'] );
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><strong>Title</strong></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<?php /*<div style="-webkit-columns:2 12em; columns:2 12em; margin: -1em 0 1em;">*/ ?>
		<p>
			<strong>Posts</strong><br>
			<label><input type="checkbox" checked> Categories</label><br>
			<label><input type="checkbox"> Tags</label>
		</p>
		<p>
			<strong>Other post type</strong><br>
			<label><input type="checkbox" checked disabled> Only one taxonomy</label><br>
		</p>
		<p>
			<strong>Transactions</strong><br>
			<label><input type="checkbox"> Merchant</label><br>
			<label><input type="checkbox"> Category</label><br>
			<label><input type="checkbox"> Account</label><br>
			<label><input type="checkbox"> Envelope</label>
		</p>
		<?php /*</div>*/ ?>
		<p class="description"><em>
			Hierarchical post types will list children of the current post's top ancestor.
			Non-hierarchical post types will list terms of the selected taxonomy of the current post type.
			Taxonomies will list terms in the current taxonomy.
		</em></p>
		<?php
	}

}
