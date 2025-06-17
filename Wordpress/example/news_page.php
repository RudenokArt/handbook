<?php
/*
Template Name: news_page
*/
get_header();
$posts_per_page = 2;
$current_page = 1;
if (isset($_GET['page_N']) and $_GET['page_N']) {
	$current_page = $_GET['page_N'];
}

global $post;
$query = new WP_Query([
	'post_type' => 'post',
	'posts_per_page' => $posts_per_page,
	'offset' => ($current_page -1 ) * $posts_per_page,
]);
$news = $query->posts;
?>

<div class="d-flex">
	<?php get_sidebar(); ?>
	<div class="content p-3">

		<div class="d-flex">
			<div>
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<div>
						<?php if (has_post_thumbnail()): ?>
							<?php the_post_thumbnail('medium'); ?>
						<?php endif ?>
						<div class="">
						<span class="h1 text-secondary d-inline"><?php the_title(); ?></span>
							<?php the_content(); ?>
						</div>
					</div>
				<?php endwhile; else: ?>
				Записей нет.
			<?php endif; ?>
		</div>

		<ul><?php wp_list_categories(); ?></ul>

	</div>


	<?php if ($news): ?>
		<table style="margin: auto;">
			<?php foreach ($news as $key => $post): ?>
				<?php setup_postdata($post); ?>
				<tr>
					<td rowspan="2" class="pe-5">
						<?php the_post_thumbnail('thumbnail'); ?>
					</td>
					<td class="text-secondary h2"><?php the_title(); ?></td>
				</tr>
				<tr>
					<td>
						<?php the_excerpt(); ?>
						<a class="text-decoration-none" href="<?php the_permalink(); ?>">read more...</a>
					</td>
				</tr>
			<?php endforeach ?>
		</table>
	<?php endif ?>
	<hr>
	<?php echo paginate_links( array(
		'base' => site_url() . '/news/%_%',
		'format' => '?page_N=%#%',
		'total' => $query->max_num_pages,
		'current' => $current_page,
	) ); ?>

	<?php get_footer(); ?>
</div>
</div>

