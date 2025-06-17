<?php
global $wp_query;
$wp_query->query_vars['posts_per_page'] = 10;
query_posts($wp_query->query_vars);
get_header();
global $query_string;
?>

<div class="d-flex">
	<?php get_sidebar(); ?>
	<div class="content p-3">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<table>
				<tr>
					<td rowspan="2" class="pe-5">
						<?php if (has_post_thumbnail()): ?>
							<?php the_post_thumbnail('thumbnail'); ?>
						<?php endif ?>
					</td>
					<td>
						<a href="<?php the_permalink(); ?>" class="text-decoration-none">
							<?php the_title(); ?>
						</a>						
					</td>
				</tr>
				<tr>
					<td><?php the_excerpt(); ?></td>
				</tr>
			</table>
		<?php endwhile; else: ?>
		Записей нет.
	<?php endif; ?>
</div>
</div>

<?php get_footer(); ?>