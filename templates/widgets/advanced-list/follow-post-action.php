<?php
$current_post = \Voxel\get_current_post();
$current_user = \Voxel\current_user();
$status = null;
if ( is_user_logged_in() && $current_post ) {
	if ( isset( $GLOBALS['vx_preview_card_current_ids'] ) ) {
		\Voxel\prime_user_following_cache( $current_user->get_id(), $GLOBALS['vx_preview_card_current_ids'], 'post' );
	}

	$status = $current_user->get_follow_status( 'post', $current_post->get_id() );
}

$is_active = $status === \Voxel\FOLLOW_ACCEPTED;
$is_intermediate = $status === \Voxel\FOLLOW_REQUESTED;
?>
<?= $start_action ?>
<a
	href="<?= esc_url( add_query_arg( [
		'vx' => 1,
		'action' => 'user.follow_post',
		'post_id' => $current_post ? $current_post->get_id() : null,
		'_wpnonce' => wp_create_nonce( 'vx_user_follow' ),
	], home_url( '/' ) ) ) ?>"
	rel="nofollow"
	class="ts-action-con ts-action-follow <?= $is_active ? 'active' : '' ?> <?= $is_intermediate ? 'intermediate' : '' ?>" role="button">
	<span class="ts-initial">
		<div class="ts-action-icon"><?php \Voxel\render_icon( $action['ts_acw_initial_icon'] ) ?></div><?= $action['ts_acw_initial_text'] ?>
	</span>
	<span class="ts-reveal">
		<div class="ts-action-icon"><?php \Voxel\render_icon( $action['ts_acw_reveal_icon'] ) ?></div><?= $action['ts_acw_reveal_text'] ?>
	</span>
</a>
<?= $end_action ?>
