<?php get_header(); ?>

<?php do_action( 'spine_theme_template_before_main', 'search.php' ); ?>

<main id="wsuwp-main" class="spine-page-default">

<?php do_action( 'spine_theme_template_before_headers', 'search.php' ); ?>

<?php wsuwp_spine_get_template_part( 'page.php', 'parts/headers' ); ?>

<?php do_action( 'spine_theme_template_after_headers', 'search.php' ); ?>

<?php wsuwp_spine_get_template_part( 'page.php', 'parts/featured-images' ); ?>

<?php do_action( 'spine_theme_template_before_content', 'search.php' ); ?>

<section class="row side-right gutter pad-ends">

	<div class="column one">

		<?php do_action( 'spine_theme_template_before_articles', 'search.php' ); ?>

		<h1>Search</h1>

		<?php get_search_form(); ?>

		<h2 class="wsuwp-t-covid__search__results__heading">Results</h2>

		<div class="wsuwp-t-covid__search__results__wrapper">

		<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php wsuwp_spine_get_template_part( 'page.php', 'articles/search' ); ?>

		<?php endwhile; ?>

		<?php else : ?>

		<?php wsuwp_spine_get_template_part( 'page.php', 'articles/no-results' ); ?>

		<?php endif; ?>

		<?php do_action( 'spine_theme_template_after_articles', 'search.php' ); ?>
		</div>

	</div><!--/column-->

	<div class="column two">

		<?php do_action( 'spine_theme_template_before_sidebar', 'search.php' ); ?>

		<?php get_sidebar(); ?>

		<?php do_action( 'spine_theme_template_after_sidebar', 'search.php' ); ?>

	</div><!--/column two-->

</section>

<?php do_action( 'spine_theme_template_after_content', 'search.php' ); ?>

<?php do_action( 'spine_theme_template_before_footer', 'search.php' ); ?>

<?php wsuwp_spine_get_template_part( 'page.php', 'parts/footers' ); ?>

<?php do_action( 'spine_theme_template_after_footer', 'search.php' ); ?>

</main>

<?php do_action( 'spine_theme_template_after_main', 'search.php' ); ?>

<?php get_footer();
