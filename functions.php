<?php


function wsuwp_t_covid_add_sidebars() {

	register_sidebar( array(
        'name'          => 'Article Footer',
        'id'            => 'article-footer',
        'description'   => 'Widgets in this area will be shown on all posts and pages.',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>',
    ) );
}



add_action( 'widgets_init', 'wsuwp_t_covid_add_sidebars' );