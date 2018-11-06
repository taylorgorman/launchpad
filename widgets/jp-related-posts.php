<?php
/*
** Make widget
*/
add_action( 'widgets_init', function() {
	register_widget( 'JP_Related_Posts' );
} );

class JP_Related_Posts extends WP_Widget {

	function __construct() {
		parent::__construct(
			false,
			'Related Posts (Jetpack)',
			[
				'description' => 'Show a list of related content'
			]
		);
	}

	function widget( $args, $instance ) {

		$related_posts = get_jetpack_related_posts($instance['numberposts']);

		if ( empty($related_posts) && ! is_user_logged_in() )
			return;

		echo $args['before_widget'];
		echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];

		if ( empty($related_posts) )
			echo '<p>There are no related posts to show (This message is only visible because you are logged in).</p>';
		else {
			echo '<ul>';
			foreach ( $related_posts as $rp )
				echo '<li><a href="'. get_permalink($rp) .'">'. get_the_title($rp) .'</a></li>';
			echo '</ul>';
		}

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

		$numberposts = ! empty($instance['numberposts']) ? $instance['numberposts'] : 4;
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><strong>Title</strong></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('numberposts'); ?>"><strong>Number of posts to show</strong></label>
			<input class="tiny-text" id="<?php echo $this->get_field_id('numberposts'); ?>" name="<?php echo $this->get_field_name('numberposts'); ?>" type="number" step="1" min="1" value="<?php echo $numberposts; ?>" size="3">
		</p>
		<?php
	}

}
