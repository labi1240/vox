<?php

$post_type = \Voxel\Post_Type::get( 'profile' );
if ( ! $post_type->is_managed_by_voxel() ) {
	return;
}

$user = \Voxel\User::get( get_the_author_meta('ID') );
if ( ! $user ) {
	return;
}

\Voxel\set_current_post( $user->get_or_create_profile() );

$template_id = \Voxel\get_single_post_template_id( $post_type );

if ( post_password_required( $template_id ) ) {
	return;
}

if ( ! \Elementor\Plugin::$instance->documents->get( $template_id )->is_built_with_elementor() ) {
	return;
}

$frontend = \Elementor\Plugin::$instance->frontend;
add_action( 'wp_enqueue_scripts', [ $frontend, 'enqueue_styles' ] );
\Voxel\enqueue_template_css( $template_id );

get_header();
if ( \Voxel\get_page_setting( 'voxel_hide_header', $template_id ) !== 'yes' ) {
	\Voxel\print_header();
}

echo $frontend->get_builder_content_for_display( $template_id );

if ( \Voxel\get_page_setting( 'voxel_hide_footer', $template_id ) !== 'yes' ) {
	\Voxel\print_footer();
}
get_footer();