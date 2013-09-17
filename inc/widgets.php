<?php
/**
 * Adds the Featured Post Widget.
 *
 * @package  Widgets
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 */

/**
 * Featured Post widget class.
 */
class Feature_Post extends WP_Widget {

	/**
	 * Holds widget settings defaults, populated in constructor.
	 *
	 * @var array
	 */
	protected $defaults;

	/**
	 * Constructor. Set the default widget options and create widget.
	 *
	 */
	function __construct() {

		$this->defaults = array(
			'title'                   => '',
			'posts_cat'               => '',
			'posts_num'               => 1,
			'posts_offset'            => 0,
			'orderby'                 => '',
			'order'                   => '',
			'show_image'              => 0,
			'image_alignment'         => '',
			'image_size'              => '',
			'show_gravatar'           => 0,
			'gravatar_alignment'      => '',
			'gravatar_size'           => '',
			'show_title'              => 0,
			'show_byline'             => 0,
			'post_info'               => '[post_date] ' . __( 'By', 'new-source' ) . ' [post_author_posts_link] [post_comments]',
			'show_content'            => 'excerpt',
			'content_limit'           => '',
			'more_text'               => __( '[Read More…]', 'new-source' ),
			'extra_num'               => '',
			'extra_title'             => '',
			'more_from_category'      => '',
			'more_from_category_text' => __( 'More Posts from this Category', 'new-source' ),
		);

		$widget_ops = array(
			'classname'   => 'featuredpost',
			'description' => __( 'Displays featured posts with thumbnails', 'new-source' ),
		);

		$control_ops = array(
			'id_base' => 'featured-post',
			'width'   => 505,
			'height'  => 350,
		);

		$this->WP_Widget( 'featured-post', __( 'Featured Posts', 'new-source' ), $widget_ops, $control_ops );

	}

	/**
	 * Echo the widget content.
	 *
	 * @since 0.1.8
	 *
	 * @param array $args Display arguments including before_title, after_title, before_widget, and after_widget.
	 * @param array $instance The settings for the particular instance of the widget
	 */
	function widget( $args, $instance ) {

		extract( $args );

		/** Merge with defaults */
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		echo $before_widget;

		/** Set up the author bio */
		if ( ! empty( $instance['title'] ) )
			echo $before_title . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $after_title;

		$query_args = array(
			'post_type' => 'post',
			'cat'       => $instance['posts_cat'],
			'showposts' => $instance['posts_num'],
			'offset'    => $instance['posts_offset'],
			'orderby'   => $instance['orderby'],
			'order'     => $instance['order'],
		);

		$featured_posts = new WP_Query( $query_args );

		if ( $featured_posts->have_posts() ) : while ( $featured_posts->have_posts() ) : $featured_posts->the_post();
			echo '<div class="' . implode( ' ', get_post_class() ) . '">';

			if ( ! empty( $instance['show_image'] ) && $image = new_source_get_image( array( 'format' => 'html', 'size' => $instance['image_size'] ) ) )
				printf( '<a href="%s" title="%s" class="%s">%s</a>', get_permalink(), the_title_attribute( 'echo=0' ), esc_attr( $instance['image_alignment'] ), $image );

			if ( ! empty( $instance['show_gravatar'] ) ) {
				echo '<span class="' . esc_attr( $instance['gravatar_alignment'] ) . '">';
				echo get_avatar( get_the_author_meta( 'ID' ), $instance['gravatar_size'] );
				echo '</span>';
			}

			if ( ! empty( $instance['show_title'] ) )
				printf( '<h2><a href="%s" title="%s">%s</a></h2>', get_permalink(), the_title_attribute( 'echo=0' ), get_the_title() );

			if ( ! empty( $instance['show_byline'] ) && ! empty( $instance['post_info'] ) )
				printf( '<p class="byline post-info">%s</p>', do_shortcode( $instance['post_info'] ) );

			if ( ! empty( $instance['show_content'] ) ) {
				if ( 'excerpt' == $instance['show_content'] )
					the_excerpt();
				elseif ( 'content-limit' == $instance['show_content'] )
					the_content_limit( (int) $instance['content_limit'], esc_html( $instance['more_text'] ) );
				else
					the_content( esc_html( $instance['more_text'] ) );
			}

			echo '</div><!--end post_class()-->'."\n\n";

		endwhile; endif;

		/** The EXTRA Posts (list) */
		if ( ! empty( $instance['extra_num'] ) ) {
			if ( ! empty( $instance['extra_title'] ) )
				echo $before_title . esc_html( $instance['extra_title'] ) . $after_title;

			$offset = intval( $instance['posts_num'] ) + intval( $instance['posts_offset'] );

			$query_args = array(
				'cat'       => $instance['posts_cat'],
				'showposts' => $instance['extra_num'],
				'offset'    => $offset,
			);
			$extra_posts = new WP_Query( $query_args );

			$listitems = '';

			if ( $extra_posts->have_posts() ) {
				while ( $extra_posts->have_posts() ) {
					$extra_posts->the_post();
					$listitems .= sprintf( '<li><a href="%s" title="%s">%s</a></li>', get_permalink(), the_title_attribute( 'echo=0' ), get_the_title() );
				}

				if ( strlen( $listitems ) > 0 )
					printf( '<ul>%s</ul>', $listitems );
			}
		}

		if ( ! empty( $instance['more_from_category'] ) && ! empty( $instance['posts_cat'] ) )
			printf(
				'<p class="more-from-category"><a href="%1$s" title="%2$s">%3$s</a></p>',
				esc_url( get_category_link( $instance['posts_cat'] ) ),
				esc_attr( get_cat_name( $instance['posts_cat'] ) ),
				esc_html( $instance['more_from_category_text'] )
			);

		echo $after_widget;
		wp_reset_query();

	}

	/**
	 * Update a particular instance.
	 *
	 * This function should check that $new_instance is set correctly.
	 * The newly calculated value of $instance should be returned.
	 * If "false" is returned, the instance won't be saved/updated.
	 *
	 * @since 0.1.8
	 *
	 * @param array $new_instance New settings for this instance as input by the user via form()
	 * @param array $old_instance Old settings for this instance
	 * @return array Settings to save or bool false to cancel saving
	 */
	function update( $new_instance, $old_instance ) {

		$new_instance['title']     = strip_tags( $new_instance['title'] );
		$new_instance['more_text'] = strip_tags( $new_instance['more_text'] );
		$new_instance['post_info'] = wp_kses_post( $new_instance['post_info'] );
		return $new_instance;

	}

	/**
	 * Echo the settings update form.
	 *
	 * @since 0.1.8
	 *
	 * @param array $instance Current settings
	 */
	function form( $instance ) {

		/** Merge with defaults */
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'new-source' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
		</p>

		<div class="genesis-widget-column">

			<div class="genesis-widget-column-box genesis-widget-column-box-top">

				<p>
					<label for="<?php echo $this->get_field_id( 'posts_cat' ); ?>"><?php _e( 'Category', 'new-source' ); ?>:</label>
					<?php
					$categories_args = array(
						'name'            => $this->get_field_name( 'posts_cat' ),
						'selected'        => $instance['posts_cat'],
						'orderby'         => 'Name',
						'hierarchical'    => 1,
						'show_option_all' => __( 'All Categories', 'new-source' ),
						'hide_empty'      => '0',
					);
					wp_dropdown_categories( $categories_args ); ?>
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'posts_num' ); ?>"><?php _e( 'Number of Posts to Show', 'new-source' ); ?>:</label>
					<input type="text" id="<?php echo $this->get_field_id( 'posts_num' ); ?>" name="<?php echo $this->get_field_name( 'posts_num' ); ?>" value="<?php echo esc_attr( $instance['posts_num'] ); ?>" size="2" />
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'posts_offset' ); ?>"><?php _e( 'Number of Posts to Offset', 'new-source' ); ?>:</label>
					<input type="text" id="<?php echo $this->get_field_id( 'posts_offset' ); ?>" name="<?php echo $this->get_field_name( 'posts_offset' ); ?>" value="<?php echo esc_attr( $instance['posts_offset'] ); ?>" size="2" />
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e( 'Order By', 'new-source' ); ?>:</label>
					<select id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>">
						<option value="date" <?php selected( 'date', $instance['orderby'] ); ?>><?php _e( 'Date', 'new-source' ); ?></option>
						<option value="title" <?php selected( 'title', $instance['orderby'] ); ?>><?php _e( 'Title', 'new-source' ); ?></option>
						<option value="parent" <?php selected( 'parent', $instance['orderby'] ); ?>><?php _e( 'Parent', 'new-source' ); ?></option>
						<option value="ID" <?php selected( 'ID', $instance['orderby'] ); ?>><?php _e( 'ID', 'new-source' ); ?></option>
						<option value="comment_count" <?php selected( 'comment_count', $instance['orderby'] ); ?>><?php _e( 'Comment Count', 'new-source' ); ?></option>
						<option value="rand" <?php selected( 'rand', $instance['orderby'] ); ?>><?php _e( 'Random', 'new-source' ); ?></option>
					</select>
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e( 'Sort Order', 'new-source' ); ?>:</label>
					<select id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>">
						<option value="DESC" <?php selected( 'DESC', $instance['order'] ); ?>><?php _e( 'Descending (3, 2, 1)', 'new-source' ); ?></option>
						<option value="ASC" <?php selected( 'ASC', $instance['order'] ); ?>><?php _e( 'Ascending (1, 2, 3)', 'new-source' ); ?></option>
					</select>
				</p>

			</div>

			<div class="genesis-widget-column-box">

				<p>
					<input id="<?php echo $this->get_field_id( 'show_gravatar' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'show_gravatar' ); ?>" value="1" <?php checked( $instance['show_gravatar'] ); ?>/>
					<label for="<?php echo $this->get_field_id( 'show_gravatar' ); ?>"><?php _e( 'Show Author Gravatar', 'new-source' ); ?></label>
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'gravatar_size' ); ?>"><?php _e( 'Gravatar Size', 'new-source' ); ?>:</label>
					<select id="<?php echo $this->get_field_id( 'gravatar_size' ); ?>" name="<?php echo $this->get_field_name( 'gravatar_size' ); ?>">
						<option value="45" <?php selected( 45, $instance['gravatar_size'] ); ?>><?php _e( 'Small (45px)', 'new-source' ); ?></option>
						<option value="65" <?php selected( 65, $instance['gravatar_size'] ); ?>><?php _e( 'Medium (65px)', 'new-source' ); ?></option>
						<option value="85" <?php selected( 85, $instance['gravatar_size'] ); ?>><?php _e( 'Large (85px)', 'new-source' ); ?></option>
						<option value="125" <?php selected( 105, $instance['gravatar_size'] ); ?>><?php _e( 'Extra Large (125px)', 'new-source' ); ?></option>
					</select>
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'gravatar_alignment' ); ?>"><?php _e( 'Gravatar Alignment', 'new-source' ); ?>:</label>
					<select id="<?php echo $this->get_field_id( 'gravatar_alignment' ); ?>" name="<?php echo $this->get_field_name( 'gravatar_alignment' ); ?>">
						<option value="alignnone">- <?php _e( 'None', 'new-source' ); ?> -</option>
						<option value="alignleft" <?php selected( 'alignleft', $instance['gravatar_alignment'] ); ?>><?php _e( 'Left', 'new-source' ); ?></option>
						<option value="alignright" <?php selected( 'alignright', $instance['gravatar_alignment'] ); ?>><?php _e( 'Right', 'new-source' ); ?></option>
					</select>
				</p>

			</div>

			<div class="genesis-widget-column-box">

				<p>
					<input id="<?php echo $this->get_field_id( 'show_image' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'show_image' ); ?>" value="1" <?php checked( $instance['show_image'] ); ?>/>
					<label for="<?php echo $this->get_field_id( 'show_image' ); ?>"><?php _e( 'Show Featured Image', 'new-source' ); ?></label>
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'image_size' ); ?>"><?php _e( 'Image Size', 'new-source' ); ?>:</label>
					<select id="<?php echo $this->get_field_id( 'image_size' ); ?>" class="genesis-image-size-selector" name="<?php echo $this->get_field_name( 'image_size' ); ?>">
						<option value="thumbnail">thumbnail (<?php echo get_option( 'thumbnail_size_w' ); ?>x<?php echo get_option( 'thumbnail_size_h' ); ?>)</option>
						<?php
						$sizes = genesis_get_additional_image_sizes();
						foreach( (array) $sizes as $name => $size )
							echo '<option value="'.esc_attr( $name ).'" '.selected( $name, $instance['image_size'], FALSE ).'>'.esc_html( $name ).' ( '.$size['width'].'x'.$size['height'].' )</option>';
						?>
					</select>
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'image_alignment' ); ?>"><?php _e( 'Image Alignment', 'new-source' ); ?>:</label>
					<select id="<?php echo $this->get_field_id( 'image_alignment' ); ?>" name="<?php echo $this->get_field_name( 'image_alignment' ); ?>">
						<option value="alignnone">- <?php _e( 'None', 'new-source' ); ?> -</option>
						<option value="alignleft" <?php selected( 'alignleft', $instance['image_alignment'] ); ?>><?php _e( 'Left', 'new-source' ); ?></option>
						<option value="alignright" <?php selected( 'alignright', $instance['image_alignment'] ); ?>><?php _e( 'Right', 'new-source' ); ?></option>
					</select>
				</p>

			</div>

		</div>

		<div class="genesis-widget-column genesis-widget-column-right">

			<div class="genesis-widget-column-box genesis-widget-column-box-top">

				<p>
					<input id="<?php echo $this->get_field_id( 'show_title' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'show_title' ); ?>" value="1" <?php checked( $instance['show_title'] ); ?>/>
					<label for="<?php echo $this->get_field_id( 'show_title' ); ?>"><?php _e( 'Show Post Title', 'new-source' ); ?></label>
				</p>

				<p>
					<input id="<?php echo $this->get_field_id( 'show_byline' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'show_byline' ); ?>" value="1" <?php checked( $instance['show_byline'] ); ?>/>
					<label for="<?php echo $this->get_field_id( 'show_byline' ); ?>"><?php _e( 'Show Post Info', 'new-source' ); ?></label>
					<input type="text" id="<?php echo $this->get_field_id( 'post_info' ); ?>" name="<?php echo $this->get_field_name( 'post_info' ); ?>" value="<?php echo esc_attr( $instance['post_info'] ); ?>" class="widefat" />
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'show_content' ); ?>"><?php _e( 'Content Type', 'new-source' ); ?>:</label>
					<select id="<?php echo $this->get_field_id( 'show_content' ); ?>" name="<?php echo $this->get_field_name( 'show_content' ); ?>">
						<option value="content" <?php selected( 'content' , $instance['show_content'] ); ?>><?php _e( 'Show Content', 'new-source' ); ?></option>
						<option value="excerpt" <?php selected( 'excerpt' , $instance['show_content'] ); ?>><?php _e( 'Show Excerpt', 'new-source' ); ?></option>
						<option value="content-limit" <?php selected( 'content-limit' , $instance['show_content'] ); ?>><?php _e( 'Show Content Limit', 'new-source' ); ?></option>
						<option value="" <?php selected( '' , $instance['show_content'] ); ?>><?php _e( 'No Content', 'new-source' ); ?></option>
					</select>
					<br />
					<label for="<?php echo $this->get_field_id( 'content_limit' ); ?>"><?php _e( 'Limit content to', 'new-source' ); ?>
						<input type="text" id="<?php echo $this->get_field_id( 'image_alignment' ); ?>" name="<?php echo $this->get_field_name( 'content_limit' ); ?>" value="<?php echo esc_attr( intval( $instance['content_limit'] ) ); ?>" size="3" />
						<?php _e( 'characters', 'new-source' ); ?>
					</label>
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'more_text' ); ?>"><?php _e( 'More Text (if applicable)', 'new-source' ); ?>:</label>
					<input type="text" id="<?php echo $this->get_field_id( 'more_text' ); ?>" name="<?php echo $this->get_field_name( 'more_text' ); ?>" value="<?php echo esc_attr( $instance['more_text'] ); ?>" />
				</p>

			</div>

			<div class="genesis-widget-column-box">

				<p><?php _e( 'To display an unordered list of more posts from this category, please fill out the information below', 'new-source' ); ?>:</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'extra_title' ); ?>"><?php _e( 'Title', 'new-source' ); ?>:</label>
					<input type="text" id="<?php echo $this->get_field_id( 'extra_title' ); ?>" name="<?php echo $this->get_field_name( 'extra_title' ); ?>" value="<?php echo esc_attr( $instance['extra_title'] ); ?>" class="widefat" />
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'extra_num' ); ?>"><?php _e( 'Number of Posts to Show', 'new-source' ); ?>:</label>
					<input type="text" id="<?php echo $this->get_field_id( 'extra_num' ); ?>" name="<?php echo $this->get_field_name( 'extra_num' ); ?>" value="<?php echo esc_attr( $instance['extra_num'] ); ?>" size="2" />
				</p>

			</div>

			<div class="genesis-widget-column-box">

				<p>
					<input id="<?php echo $this->get_field_id( 'more_from_category' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'more_from_category' ); ?>" value="1" <?php checked( $instance['more_from_category'] ); ?>/>
					<label for="<?php echo $this->get_field_id( 'more_from_category' ); ?>"><?php _e( 'Show Category Archive Link', 'new-source' ); ?></label>
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'more_from_category_text' ); ?>"><?php _e( 'Link Text', 'new-source' ); ?>:</label>
					<input type="text" id="<?php echo $this->get_field_id( 'more_from_category_text' ); ?>" name="<?php echo $this->get_field_name( 'more_from_category_text' ); ?>" value="<?php echo esc_attr( $instance['more_from_category_text'] ); ?>" class="widefat" />
				</p>

			</div>

		</div>
		<?php

	}
}


function new_source_register_widgets() {
	register_widget( 'Feature_Post' );
}

add_action( 'widgets_init', 'new_source_register_widgets' );
