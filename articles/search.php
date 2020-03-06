<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> class="wsu-t-covid__search_result">
	<?php if ( true === spine_get_option( 'articletitle_show' ) && apply_filters( 'wsuwp_spine_themes_show_title', true, 'article.php' ) ) : ?>
	<header class="article-header">
		<h2 class="wsu-t-covid__search_result__title">
			<a href="<?php the_permalink(); ?>">
				<?php the_title(); ?>
			</a>
		</h2>
		<div class="wsu-t-covid__search__meta__wrapper">
			Published on <span class="wsu-t-covid__search__meta__date"><?php echo esc_html( get_the_date() ); ?></span>
		</div>
	</header>
	<?php endif; ?>
	<?php echo wp_kses_post( wp_trim_words( wp_strip_all_tags( get_the_excerpt() ), 25 ) ); ?>
</article>
