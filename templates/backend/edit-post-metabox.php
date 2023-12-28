<div id="vx-fields-wrapper">
	<iframe
		data-src="<?= add_query_arg( [
			'action' => 'admin.get_fields_form',
			'post_type' => $post->post_type->get_key(),
			'post_id' => $post->get_id(),
			'_wpnonce' => wp_create_nonce( 'vx_admin_edit_post' ),
		], home_url('/?vx=1') ) ?>"
		style="width: 100%; display: block;"
		frameborder="0"
	></iframe>
</div>

<style type="text/css">
	.edit-post-meta-boxes-area.is-loading::before {
		display: none;
	}
</style>
