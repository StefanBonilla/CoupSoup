<?php

/**
 * Adds Mediaphase_Team_Member_Widget widget.
 */
class Mediaphase_Team_Member_Widget extends WP_Widget
{

	public function __construct()
	{
		parent::__construct(
			'mediaphase-team-member-widget',
			'Team Member widget',
			array(
				'description' => 'Team member widget'
			)
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance )
	{
		$social = array( $instance['social_twitter'], $instance['social_facebook'], $instance['social_linkedin'], $instance['social_dribbble'], $instance['social_gplus'] );

		echo $args['before_widget'];
		echo '<img src="' . esc_url( $instance['image_url'] ) . '" class="memberphoto">';
		echo $args['before_title'] . esc_html( $instance['title'] ) . $args['after_title'];
		echo '<p>' . strip_tags( $instance['textbox'], '<a><span><i><em><strong><b><ul><ol><li><br>' ) . '</p>';

		if ( !empty( $social[0] ) || !empty( $social[1] ) || !empty( $social[2] ) || !empty( $social[3] ) || !empty( $social[4] ) ) {
			echo '<div class="teamsocial">';
			foreach ( $social as $url ) {
				if ( !empty( $url ) ) {
					echo '<a href="' . esc_url( $url ) . '"><span class="screen-reader-text">' . esc_html( $url ) . '</span></a>';
				}
			}
			echo '</div>';
		}

		echo $args['after_widget'];

	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance )
	{
		$instance = array();
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['textbox'] = strip_tags( $new_instance['textbox'], '<a><span><i><em><strong><b><ul><ol><li><br>' );
		$instance['image_url'] = esc_url( $new_instance['image_url'] );
		$instance['social_twitter'] = esc_url( $new_instance['social_twitter'] );
		$instance['social_facebook'] = esc_url( $new_instance['social_facebook'] );
		$instance['social_dribbble'] = esc_url( $new_instance['social_dribbble'] );
		$instance['social_linkedin'] = esc_url( $new_instance['social_linkedin'] );
		$instance['social_gplus'] = esc_url( $new_instance['social_gplus'] );

		return $instance;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance )
	{

		$title = ( isset( $instance['title'] ) ) ? $instance['title'] : 'Title';
		$textbox = ( isset( $instance['textbox'] ) ) ? $instance['textbox'] : 'Enter your text here';
		$image_url = ( isset ( $instance['image_url'] ) ) ? $instance['image_url'] : get_template_directory_uri() . '/img/staff1.jpg';
		$social_twitter = ( isset ( $instance['social_twitter'] ) ) ? $instance['social_twitter'] : '';
		$social_facebook = ( isset ( $instance['social_facebook'] ) ) ? $instance['social_facebook'] : '';
		$social_dribbble = ( isset ( $instance['social_dribbble'] ) ) ? $instance['social_dribbble'] : '';
		$social_linkedin = ( isset ( $instance['social_linkedin'] ) ) ? $instance['social_linkedin'] : '';
		$social_gplus = ( isset ( $instance['social_gplus'] ) ) ? $instance['social_gplus'] : '';


		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'mediaphase-lite' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
				   name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"
				   value="<?php echo esc_attr( $title ); ?>"/>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'textbox' ); ?>"><?php _e( 'Text:', 'mediaphase-lite' ); ?></label>
			<textarea class="widefat" id="<?php echo $this->get_field_id( 'textbox' ); ?>"
					  name="<?php echo $this->get_field_name( 'textbox' ); ?>"><?php echo esc_attr( $textbox ); ?></textarea>
		</p>

		<p>
			<label
				for="<?php echo $this->get_field_id( 'social_twitter' ); ?>"><?php _e( 'Twitter url', 'mediaphase-lite' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'social_twitter' ); ?>"
				   name="<?php echo $this->get_field_name( 'social_twitter' ); ?>" type="text"
				   value="<?php echo esc_attr( $social_twitter ); ?>"/>

			<label
				for="<?php echo $this->get_field_id( 'social_facebook' ); ?>"><?php _e( 'Facebook url', 'mediaphase-lite' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'social_facebook' ); ?>"
				   name="<?php echo $this->get_field_name( 'social_facebook' ); ?>" type="text"
				   value="<?php echo esc_attr( $social_facebook ); ?>"/>

			<label
				for="<?php echo $this->get_field_id( 'social_dribbble' ); ?>"><?php _e( 'Dribbble url', 'mediaphase-lite' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'social_dribbble' ); ?>"
				   name="<?php echo $this->get_field_name( 'social_dribbble' ); ?>" type="text"
				   value="<?php echo esc_attr( $social_dribbble ); ?>"/>

			<label
				for="<?php echo $this->get_field_id( 'social_linkedin' ); ?>"><?php _e( 'Linkedin url', 'mediaphase-lite' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'social_linkedin' ); ?>"
				   name="<?php echo $this->get_field_name( 'social_linkedin' ); ?>" type="text"
				   value="<?php echo esc_attr( $social_linkedin ); ?>"/>

			<label
				for="<?php echo $this->get_field_id( 'social_gplus' ); ?>"><?php _e( 'Google+ url', 'mediaphase-lite' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'social_gplus' ); ?>"
				   name="<?php echo $this->get_field_name( 'social_gplus' ); ?>" type="text"
				   value="<?php echo esc_attr( $social_gplus ); ?>"/>
		</p>

		<p>
			<label
				for="<?php echo $this->get_field_id( 'image_url' ); ?>"><?php _e( 'Image:', 'mediaphase-lite' ); ?></label><br/>
			<input type="text" class="img" name="<?php echo $this->get_field_name( 'image_url' ); ?>"
				   id="<?php echo $this->get_field_id( 'image_url' ); ?>"
				   value="<?php echo esc_attr( $image_url ); ?>"/>
			<input type="button" class="mediaphase-select-img" value="<?php _e( 'Select Image', 'mediaphase-lite' ); ?>"/>
		</p>
	<?php
	}


}

// init the widget
function mediaphase_register_team_member_widget()
{
	register_widget( 'Mediaphase_Team_Member_Widget' );
}

add_action( 'widgets_init', 'mediaphase_register_team_member_widget' );

// queue up the necessary js
function mediaphase_team_member_widget_script_enqueue()
{
	wp_enqueue_style( 'thickbox' );
	wp_enqueue_script( 'media-upload' );
	wp_enqueue_script( 'thickbox' );
	// moved the js to an external file, you may want to change the path
	wp_enqueue_script( 'mediaphase_team_member_widget_js', get_template_directory_uri() . '/inc/js/widget-team-member.js', null, null, true );
}

add_action( 'admin_enqueue_scripts', 'mediaphase_team_member_widget_script_enqueue' );