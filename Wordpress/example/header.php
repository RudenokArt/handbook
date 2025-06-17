<?php wp_head(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- <title>Document</title> -->
</head>
<body>

	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-md-4 col-sm-6 col-12 pt-2 d-flex">
				<div>
					<img alt="" width="50" src="<?php echo wp_get_attachment_url(get_theme_mod('custom_logo')); ?>" >
				</div>

				<div class="h3 text-info"><?php echo __('header', 'translate'); ?></div>
			</div>
		</div>
		<hr>