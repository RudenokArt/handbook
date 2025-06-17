<?php get_header(); ?>
<div class="d-flex">
	<?php get_sidebar(); ?>
	<div class="content p-3">
		<?php if ( have_posts() ) : the_post(); ?>
			<?php if (has_post_thumbnail()): ?>
				<?php the_post_thumbnail('large'); ?>
			<?php endif ?>			
			<div class="h1 text-secondary"><?php the_title(); ?></div>
			<div class="">
				<?php the_content(); ?>
			</div>
			<i><?php echo get_post_meta($post->ID, 'testfield', true); ?></i>
		<?php else: ?>
		Записей нет.
	<?php endif; ?>
	<?php comment_form(); ?>
	<?php comments_template( '/comments.php' ); ?>
</div>
</div>

<pre><?php print_r($_REQUEST); ?></pre>
<?php get_footer(); ?>