<?php namespace WSUWP\Theme\COVID;

class Email_Digest {


	protected static $option_key = 'wsuwp_email_covid';
	protected static $option_defaults = array(
		'send_from'       => 'covid-19@wsu.edu',
		'send_email'      => false,
		'send_to'         => 'noreply@wsu.edu',
		'bcc_to'          => '',
		'bcc_to_alt'      => '',
		'email_template'  => '',
		'reply_to'        => 'noreply@wsu.edu',
		'send_from_title' => 'WSU COVID-19 Communications',
		'subject'         => 'Daily Updates',
		'send_time'       => '',
		'empty_posts'     => '',
	);


	public static function get( $property ) {

		switch ( $property ) {

			case 'option_key':
				return self::$option_key;
			case 'option_defaults':
				return self::$option_defaults;
			default:
				return '';
		}
	}


	public function init() {

		if ( isset( $_REQUEST['preview_wsu_email'] ) ) {

			add_filter( 'template_include', __CLASS__ . '::preview_email_template', 999999999 );

		}

		if ( isset( $_REQUEST['send_test'] ) ) {

			self::send_email( true );

		} elseif ( isset( $_REQUEST['send_manual'] ) ) {

			self::send_email();

		}

		add_action( 'admin_menu', __CLASS__ . '::add_email_options' );

		if ( is_admin() && isset( $_REQUEST['email_options_action'] ) ) {

			$this->save_email_options();

		}

	}


	protected static function send_email( $is_test = false ) {

		$options = self::get_options();

		$headers = array(
			'From: ' . $options['send_from_title'] . ' <' . $options['send_from'] . '>',
			'Content-Type: text/html',
			'Reply-To: ' . $options['reply_to'],
			'Bcc: holly.sitzmann@wsu.edu',
			'Bcc: jbickelhaupt@wsu.edu',
			'Bcc: wassond@wsu.edu',
			'charset=UTF-8',
		);

		$html = self::render_email( false, $options );

		$subject = $options['subject'];

		if ( ! empty( $is_test ) ) {

			if ( ! empty( $_REQUEST['send_to'] ) ) {

				$headers[] = 'Bcc: ' . $_REQUEST['send_to'];

				$to = $options['send_to'];
	
				wp_mail(
					$to,
					$subject,
					$html,
					$headers
				);
			}
		} else {

			$to = $options['send_to'];

			if ( ! empty( $options['bcc_to'] ) ) {

				$headers[] = 'Bcc: ' . $options['bcc_to'];

			}

			if ( ! empty( $options['bcc_to_alt'] ) ) {

				$headers[] = 'Bcc: ' . $options['bcc_to_alt'];

			}

			wp_mail(
				$to,
				$subject,
				$html,
				$headers
			);

		}

	}


	public static function preview_email_template( $template ) {

		return get_stylesheet_directory() . '/email.php';

	}


	public static function add_email_options() {

		add_options_page(
			'Email Options',
			'Email Options',
			'manage_options',
			'email_options',
			__CLASS__ . '::the_options_page'
		);

	}


	public function save_email_options() {

		if ( 'update' === $_REQUEST['email_options_action'] ) {

			// Get existing options
			$options = self::get_options();

			$values = array(
				'send_from'       => isset( $_REQUEST['send_from'] ) ? sanitize_text_field( $_REQUEST['send_from'] ) : '',
				'reply_to'        => isset( $_REQUEST['reply_to'] ) ? sanitize_text_field( $_REQUEST['reply_to'] ) : '',
				'bcc_to'          => isset( $_REQUEST['bcc_to'] ) ? sanitize_text_field( $_REQUEST['bcc_to'] ) : '',
				'bcc_to_alt'      => isset( $_REQUEST['bcc_to_alt'] ) ? sanitize_text_field( $_REQUEST['bcc_to_alt'] ) : '',
				'send_email'      => isset( $_REQUEST['send_email'] ) ? sanitize_text_field( $_REQUEST['send_email'] ) : '0',
				'email_template'  => isset( $_REQUEST['email_template'] ) ? $_REQUEST['email_template'] : '',
				'send_from_title' => isset( $_REQUEST['send_from_title'] ) ? sanitize_text_field( $_REQUEST['send_from_title'] ) : '',
				'subject'         => isset( $_REQUEST['subject'] ) ? sanitize_text_field( $_REQUEST['subject'] ) : '',
				'send_time'       => isset( $_REQUEST['send_time'] ) ? sanitize_text_field( $_REQUEST['send_time'] ) : '',
				'empty_posts'     => isset( $_REQUEST['empty_posts'] ) ? sanitize_text_field( $_REQUEST['empty_posts'] ) : '',
			);

			if ( $values['send_time'] !== $options['send_time'] ) {

				wp_unschedule_hook( 'wsuwp_covide_email_schedule' );

				$time = $values['send_time'] . ':00:00';

				//wp_schedule_event( strtotime( $time ), 'daily', 'wsuwp_covide_email_schedule' );

			}

			update_option( self::get( 'option_key' ), $values, 'no' );

		} // End if

	}


	public static function get_options() {

		$options = get_option( self::get( 'option_key' ), array() );

		if ( ! is_array( $options ) ) {

			$options = array();

		}

		$options = array_merge( self::get( 'option_defaults' ), $options );

		return $options;
	}


	public static function the_options_page() {

		$form_url = '//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

		$options = self::get_options();

		include get_stylesheet_directory() . '/template-parts/admin/form-email-options.php';

	}

	public static function render_email( $echo = true, $options = false ) {

		Email_Shortcodes::add_shortcodes();

		if ( empty( $options ) ) {

			$options = self::get_options();

		}

		$html = do_shortcode( stripslashes( $options['email_template'] ) );

		if ( $echo ) {

			echo $html;

		} else {

			return $html;

		}

	}



	protected static function get_posts( $q_args = array() ) {

		$posts = array();

		$args = array(
			'post_type' => 'post',
			'posts_per_page' => '10',
		);

		$args = array_merge( $args, $q_args );

		if ( empty( $_REQUEST['demo_content'] ) ) {

			$args['date_query'] = array(
				array(
					'after' => '24 hours ago',
				),
			);
		} else {

			$args['posts_per_page'] = '3';
			unset( $args['cat'] );

		}

		Email_Shortcodes::add_post_shortcodes();

		$the_query = new \WP_Query( $args );


		if ( $the_query->have_posts() ) {

			while ( $the_query->have_posts() ) {


				$the_query->the_post();

				$post = array(
					'title' => get_the_title(),
					'link'  => get_the_permalink(),
					'date'  => get_the_date(),
					'excerpt' => wp_trim_words( wp_strip_all_tags( get_the_excerpt() ), 35 ),
				);

				ob_start();

				the_content();

				$post['content'] = ob_get_clean();

				$posts[] = $post;

			}
		}

		wp_reset_postdata();

		return $posts;

	}


	protected static function parse_content( $content, $options ) {

		$content = stripslashes( $content );

		$posts = self::get_posts( array( 'cat' => '538' ) );
		$academics = self::get_posts( array( 'cat' => '545,543' ) );
		$faqs = self::get_posts( array( 'cat' => '539' ) );

		self::parse_post_content( $posts, $content, $options );
		self::parse_faq_content( $faqs, $content, $options );
		self::parse_academics_content( $academics, $content, $options );

		$content = str_replace( '[date_month]', current_time( 'F' ), $content );
		$content = str_replace( '[date_day]', current_time( 'j' ), $content );
		$content = str_replace( '[date_day_name]', current_time( 'l' ), $content );

		return $content;

	}


	protected static function parse_post_content( $posts, &$content, $options) {

		$post_content = '';

		$pattern = '/\[\/?posts\]/';

		$template_parts = preg_split( $pattern, $content );

		$header          = ( ! empty( $template_parts[0] ) ) ? $template_parts[0] : '';
		$post_template   = ( ! empty( $template_parts[1] ) ) ? $template_parts[1] : '';
		$footer          = ( ! empty( $template_parts[2] ) ) ? $template_parts[2] : '';

		foreach ( $posts as $post ) {

			$post_content .= self::do_merge_tags( $post, $post_template );

		}

		$content = $header . $post_content . $footer;

	}

	protected static function parse_academics_content( $posts, &$content, $options) {

		$post_content = '';

		$pattern = '/\[\/?academics\]/';

		$template_parts = preg_split( $pattern, $content );

		$header          = ( ! empty( $template_parts[0] ) ) ? $template_parts[0] : '';
		$post_template   = ( ! empty( $template_parts[1] ) ) ? $template_parts[1] : '';
		$footer          = ( ! empty( $template_parts[2] ) ) ? $template_parts[2] : '';

		foreach ( $posts as $post ) {

			$post_content .= self::do_merge_tags( $post, $post_template );

		}

		$content = $header . $post_content . $footer;

	}


	protected static function parse_faq_content( $posts, &$content, $options) {

		$post_content = '';

		$pattern = '/\[\/?faqs\]/';

		$template_parts = preg_split( $pattern, $content );

		$header          = ( ! empty( $template_parts[0] ) ) ? $template_parts[0] : '';
		$post_template   = ( ! empty( $template_parts[1] ) ) ? $template_parts[1] : '';
		$footer          = ( ! empty( $template_parts[2] ) ) ? $template_parts[2] : '';

		foreach ( $posts as $post ) {

			$post_content .= self::do_merge_tags( $post, $post_template );

		}

		$content = $header . $post_content . $footer;

	}


	protected static function do_merge_tags( $post, $template ) {

		$template = str_replace( '[date_month]', current_time( 'F' ), $template );
		$template = str_replace( '[date_day]', current_time( 'j' ), $template );
		$template = str_replace( '[date_day_name]', current_time( 'l' ), $template );
		$template = str_replace( '[post_title]', $post['title'], $template );
		$template = str_replace( '[post_link]', $post['link'], $template );
		$template = str_replace( '[post_excerpt]', $post['excerpt'], $template );
		$template = str_replace( '[post_content]', $post['content'], $template );
		$template = str_replace( '[post_date]', $post['date'], $template );

		return $template;

	}

}

(new Email_Digest )->init();
