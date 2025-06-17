<div class="sidebar border-end p-2 pt-5">
	<?php get_search_form(); ?>
	<hr>
	<?php wp_nav_menu([
		'menu' => 'header-menu',
		'menu_class' => 'header-menu'
	]); ?>
<hr>
<?php dynamic_sidebar( 'test_widget_area' ); ?>
</div>