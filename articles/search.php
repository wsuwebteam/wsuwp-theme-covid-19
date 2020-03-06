<article id="post-<?php the_ID(); ?>" class="wsu-t-covid__search_result">
	<header class="wsu-t-covid__search_result__header">
		<h3 class="wsu-t-covid__search_result__title">
			<a href="<?php the_permalink(); ?>">
				<?php the_title(); ?>
			</a>
		</h3>
		<div class="wsu-t-covid__search__meta__wrapper">
			Published on <span class="wsu-t-covid__search__meta__date"><?php echo esc_html( get_the_date() ); ?></span>
		</div>
	</header>
	<div class="wsu-t-covid__search__result__excerpt">
		<?php echo wp_kses_post( wp_trim_words( wp_strip_all_tags( get_the_excerpt() ), 25 ) ); ?>
	</div>
</article>
