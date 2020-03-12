<?php namespace WSUWP\Theme\COVID;

class Email_Shortcodes {


	public function init() {

	}


	public static function add_shortcodes() {

		add_shortcode( 'e_post_title', __CLASS__ . '::do_shortcode_post_title' );
		add_shortcode( 'e_post_link', __CLASS__ . '::do_shortcode_post_link' );
		add_shortcode( 'e_post_content', __CLASS__ . '::do_shortcode_post_content' );
		add_shortcode( 'e_post_excerpt', __CLASS__ . '::do_shortcode_post_excerpt' );
		add_shortcode( 'e_post_feed', __CLASS__ . '::do_shortcode_post_feed' );
		add_shortcode( 'e_has_posts', __CLASS__ . '::do_shortcode_has_posts' );
		add_shortcode( 'e_date', __CLASS__ . '::do_shortcode_date' );
		add_shortcode( 'e_date_month', __CLASS__ . '::do_shortcode_date' );
		add_shortcode( 'e_date_day', __CLASS__ . '::do_shortcode_date' );
		add_shortcode( 'e_date_day_name', __CLASS__ . '::do_shortcode_date' );

	}


	public static function do_shortcode_post_title( $atts ) {

		return get_the_title();

	}

	public static function do_shortcode_post_link( $atts ) {

		return get_the_permalink();

	}

	public static function do_shortcode_post_content( $atts ) {

		ob_start();

		the_content();

		return ob_get_clean();

	}

	public static function do_shortcode_post_excerpt( $atts ) {

		$default_atts = array(
			'trim_words' => 35,
		);

		$atts = shortcode_atts( $default_atts, $atts );

		return wp_trim_words( wp_strip_all_tags( get_the_excerpt() ), $atts['trim_words'] );

	}

	public static function do_shortcode_post_feed( $atts, $template ) {

		$content = '';
		
		$query = self::get_query( $atts );

		$the_query = new \WP_Query( $query );

		if ( $the_query->have_posts() ) {


			while ( $the_query->have_posts() ) {

				ob_start();

				$the_query->the_post();

				$content .= do_shortcode( $template );

			}
		}

		wp_reset_postdata();

		return $content;

	}


	public static function do_shortcode_has_posts( $atts, $template ) {

		$content = '';
		
		$query = self::get_query( $atts );

		$the_query = new \WP_Query( $query );

		if ( $the_query->have_posts() ) {

			$content = do_shortcode( $template );

		}

		wp_reset_postdata();

		return $content;

	}


	public static function do_shortcode_date( $atts, $content, $tag ) {

		$default_atts = array(
			'format' => 'F',
		);

		switch ( $tag ) {
			case 'e_date_month':
				$default_atts['format'] = 'F';
				break;
			case 'e_date_day':
				$default_atts['format'] = 'j';
				break;
			case 'e_date_day_name':
				$default_atts['format'] = 'F';
				break;
		}

		$atts = shortcode_atts( $default_atts, $atts );

		return current_time( $atts['format'] );

	}


	protected static function get_query( $atts ) {

		$default_atts = array(
			'categories' => '',
			'exclude'    => '',
			'orderby'    => 'date',
			'order'      => 'DESC',
			'count'      => '20',
			'by_time'    => '',
		);

		$atts = shortcode_atts( $default_atts, $atts );

		$args = array(
			'post_type' => 'post',
			'posts_per_page' => '10',
			'orderby'        => $atts['orderby'],
			'order'          => $atts['order'],
			'posts_per_page' => $atts['count'],
		);

		if ( ! empty( $atts['by_time'] ) ) {

			$args['date_query'] = array(
				array(
					'after' => $atts['by_time'],
				),
			);

		}

		if ( ! empty( $atts['exclude'] ) ) {

			$args['category__not_in'] = explode( ',', $atts['exclude'] );

		}

		if ( ! empty( $atts['categories'] ) ) {

			$args['cat'] = $atts['categories'];

		}

		if ( ! empty( $_REQUEST['demo_content'] ) ) {

			unset( $args['cat'] );
			unset( $args['date_query'] );
			unset( $args['category__not_in'] );

			$args['posts_per_page'] = 3;

		}

		return $args;

	}

}

(new Email_Shortcodes )->init();
