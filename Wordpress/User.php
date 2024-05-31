<?php

// Проверка пользователя на админа:
print_r(current_user_can('manage_options'));

// Добавить новое поле (свойство) пользователя
add_action( 'edit_user_profile', static function ( $user) {
	$company_id = get_the_author_meta('company_id', $user->ID);
?> Company ID:
<input value="<?php echo esc_attr($company_id);?>"
min="1" step="1" type="number" name="company_id" id="company_id"
/><?php
});
add_action('edit_user_profile_update', static function( $user) {
	update_user_meta( $user, 'company_id', sanitize_text_field( $_POST['company_id']));
});