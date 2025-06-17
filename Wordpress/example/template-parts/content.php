	<div class="d-flex">
		<?php get_sidebar(); ?>
		<div class="content p-3">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<div>
					<?php if (has_post_thumbnail()): ?>
						<?php the_post_thumbnail('medium'); ?>
					<?php endif ?>			
					<span class="h1 text-secondary d-inline"><?php the_title(); ?></span>
					<div class="">
						<?php the_content(); ?>
					</div>
				</div>
			<?php endwhile; else: ?>
			Записей нет.
		<?php endif; ?>
				<?php echo paginate_links(); ?>
	</div>
	<?php if (is_category()): ?>
		<h3><?php echo get_queried_object()->name; ?></h3>
	<?php endif ?>
	<?php if (is_home()): ?>
		<ul><?php wp_list_categories(); ?></ul>
	<?php endif ?>
</div>
