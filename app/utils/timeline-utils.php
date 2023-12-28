<?php

namespace Voxel\Timeline;

if ( ! defined('ABSPATH') ) {
	exit;
}

function user_has_reached_status_rate_limit( int $user_id ): bool {
	global $wpdb;

	$limits = (array) \Voxel\get( 'settings.timeline.posts.rate_limit' );
	$limits = apply_filters( 'voxel/timeline/status-rate-limits', $limits, $user_id );
	$user_id = absint( $user_id );

	$time_between_reached = !! $wpdb->get_var( $wpdb->prepare( <<<SQL
		SELECT COUNT(tl.id) < 1
			FROM {$wpdb->prefix}voxel_timeline tl
			LEFT JOIN {$wpdb->posts} AS p on tl.published_as = p.ID
		WHERE ( tl.user_id = {$user_id} OR p.post_author = {$user_id} )
			AND created_at >= %s
		LIMIT 1
	SQL, date( 'Y-m-d H:i:s', strtotime( sprintf( '-%d seconds', absint( $limits['time_between'] ?? 20 ) ) ) ) ) );

	if ( ! $time_between_reached ) {
		return true;
	}

	$hourly_limit = absint( $limits['hourly_limit'] ?? 20 );
	$hourly_limit_reached = !! $wpdb->get_var( $wpdb->prepare( <<<SQL
		SELECT COUNT(tl.id) > {$hourly_limit}
			FROM {$wpdb->prefix}voxel_timeline tl
			LEFT JOIN {$wpdb->posts} AS p on tl.published_as = p.ID
		WHERE ( tl.user_id = {$user_id} OR p.post_author = {$user_id} )
			AND created_at >= %s
	SQL, date( 'Y-m-d H:i:s', strtotime('-1 hour') ) ) );

	if ( $hourly_limit_reached ) {
		return true;
	}

	$daily_limit = absint( $limits['daily_limit'] ?? 100 );
	$daily_limit_reached = !! $wpdb->get_var( $wpdb->prepare( <<<SQL
		SELECT COUNT(tl.id) > {$daily_limit}
			FROM {$wpdb->prefix}voxel_timeline tl
			LEFT JOIN {$wpdb->posts} AS p on tl.published_as = p.ID
		WHERE ( tl.user_id = {$user_id} OR p.post_author = {$user_id} )
			AND created_at >= %s
	SQL, date( 'Y-m-d H:i:s', strtotime('-1 day') ) ) );

	if ( $daily_limit_reached ) {
		return true;
	}

	return false;
}

function user_has_reached_reply_rate_limit( int $user_id ): bool {
	if ( current_user_can( 'administrator' ) ) {
		return false;
	}

	global $wpdb;

	$limits = (array) \Voxel\get( 'settings.timeline.replies.rate_limit' );
	$limits = apply_filters( 'voxel/timeline/reply-rate-limits', $limits, $user_id );
	$user_id = absint( $user_id );

	$time_between_reached = !! $wpdb->get_var( $wpdb->prepare( <<<SQL
		SELECT COUNT(r.id) < 1
			FROM {$wpdb->prefix}voxel_timeline_replies r
			LEFT JOIN {$wpdb->posts} AS p on r.published_as = p.ID
		WHERE ( r.user_id = {$user_id} OR p.post_author = {$user_id} )
			AND created_at >= %s
		LIMIT 1
	SQL, date( 'Y-m-d H:i:s', strtotime( sprintf( '-%d seconds', absint( $limits['time_between'] ?? 5 ) ) ) ) ) );

	if ( ! $time_between_reached ) {
		return true;
	}

	$hourly_limit = absint( $limits['hourly_limit'] ?? 100 );
	$hourly_limit_reached = !! $wpdb->get_var( $wpdb->prepare( <<<SQL
		SELECT COUNT(r.id) > {$hourly_limit}
			FROM {$wpdb->prefix}voxel_timeline_replies r
			LEFT JOIN {$wpdb->posts} AS p on r.published_as = p.ID
		WHERE ( r.user_id = {$user_id} OR p.post_author = {$user_id} )
			AND created_at >= %s
	SQL, date( 'Y-m-d H:i:s', strtotime('-1 hour') ) ) );

	if ( $hourly_limit_reached ) {
		return true;
	}

	$daily_limit = absint( $limits['daily_limit'] ?? 1000 );
	$daily_limit_reached = !! $wpdb->get_var( $wpdb->prepare( <<<SQL
		SELECT COUNT(r.id) > {$daily_limit}
			FROM {$wpdb->prefix}voxel_timeline_replies r
			LEFT JOIN {$wpdb->posts} AS p on r.published_as = p.ID
		WHERE ( r.user_id = {$user_id} OR p.post_author = {$user_id} )
			AND created_at >= %s
	SQL, date( 'Y-m-d H:i:s', strtotime('-1 day') ) ) );

	if ( $daily_limit_reached ) {
		return true;
	}

	return false;
}

function prepare_status_json( \Voxel\Timeline\Status $status ): array {
	static $loaded_review_config = [];

	$user = $status->get_user();
	$publisher = $status->get_post_published_as();
	$post = $status->get_post();
	$details = $status->get_details();
	$file_field = new \Voxel\Timeline\Fields\Status_Files_Field;

	$response = [
		'id' => $status->get_id(),
		'key' => $status->get_unique_key(),
		'link' => $status->get_link(),
		'time' => $status->get_time_for_display(),
		'edit_time' => $status->get_edit_time_for_display(),
		'content' => $status->get_content_for_display(),
		'raw_content' => $status->get_content(),
		'files' => $file_field->prepare_for_display( $details['files'] ?? '' ),
		'is_review' => $status->is_review(),
		'user' => [
			'exists' => !! $user,
			'name' => $user ? $user->get_display_name() : null,
			'avatar' => $user ? $user->get_avatar_markup() : null,
			'link' => $user ? $user->get_link() : null,
			'id' => $user ? $user->get_id() : null,
		],
		'publisher' => [
			'exists' => !! $publisher,
			'name' => $publisher ? $publisher->get_display_name() : null,
			'avatar' => $publisher ? $publisher->get_avatar_markup() : null,
			'link' => $publisher ? $publisher->get_link() : null,
		],
		'post' => [
			'exists' => !! $post,
			'title' => $post ? $post->get_display_name() : null,
			'link' => $post ? $post->get_link() : null,
			'is_profile' => $user && $post && (int) $user->get_profile_id() === (int) $post->get_id(),
			'post_type' => ( $post && $post->post_type ) ? $post->post_type->get_key() : null,
		],
		'user_can_edit' => $status->is_editable_by_current_user(),
		'user_can_moderate' => $status->is_moderatable_by_current_user(),
		'liked_by_user' => $status->liked_by_user(),
		'like_count' => $status->get_like_count() ? number_format_i18n( $status->get_like_count() ) : null,
		'reply_count' => $status->get_reply_count() ? number_format_i18n( $status->get_reply_count() ) : null,
		'replies' => [
			'requested' => false,
			'visible' => false,
			'page' => 1,
			'loading' => false,
			'hasMore' => false,
			'list' => [],
		],
	];

	if ( $status->is_review() ) {
		$response['reviews'] = [
			'score' => $status->get_review_score(),
			'score_formatted' => $status->get_review_score_for_display(),
			'mode' => ( $post && $post->post_type ) ? $post->post_type->reviews->get_input_mode() : null,
			'ratings' => $details['rating'] ?? [],
		];

		if ( ! empty( $_REQUEST['_review_post_types'] ) ) {
			$loaded_review_post_types = (array) json_decode( wp_unslash( $_REQUEST['_review_post_types'] ?? '' ), true );
			if (
				$post
				&& $post->post_type
				&& ! in_array( $post->post_type->get_key(), $loaded_review_post_types, true )
				&& ! isset( $loaded_review_config[ $post->post_type->get_key() ] )
			) {
				$response['review_config'] = $post->post_type->reviews->get_timeline_config();
				$loaded_review_config[ $post->post_type->get_key() ] = true;
			}
		}
	}

	return $response;
}

function prepare_reply_json( \Voxel\Timeline\Reply $reply ): array {
	$user = $reply->get_user();
	$reply_to = $reply->get_reply_to();
	$reply_to_user = $reply_to ? $reply_to->get_user() : null;
	$reply_to_markup = '';
	if ( $reply_to_user ) {
		$reply_to_markup = sprintf(
			'<a href="%s">@%s</a> ',
			$reply_to_user->get_link(),
			$reply_to_user->get_display_name()
		);
	}

	return [
		'id' => $reply->get_id(),
		'key' => $reply->get_unique_key(),
		'link' => $reply->get_link(),
		'time' => $reply->get_time_for_display(),
		'edit_time' => $reply->get_edit_time_for_display(),
		'content' => $reply_to_markup . $reply->get_content_for_display(),
		'raw_content' => $reply->get_content(),
		'user' => [
			'name' => $user->get_display_name(),
			'avatar' => $user->get_avatar_markup(),
			'link' => $user->get_link(),
		],
		'reply_to' => [
			'exists' => !! $reply_to_user,
			'name' => $reply_to_user ? $reply_to_user->get_display_name() : null,
			'link' => $reply_to_user ? $reply_to_user->get_link() : null,
		],
		'user_can_edit' => $reply->is_editable_by_current_user(),
		'user_can_moderate' => $reply->is_moderatable_by_current_user(),
		'liked_by_user' => $reply->liked_by_user(),
		'like_count' => $reply->get_like_count() ? number_format_i18n( $reply->get_like_count() ) : null,
		'reply_count' => $reply->get_reply_count() ? number_format_i18n( $reply->get_reply_count() ) : null,
		'replies' => [
			'requested' => false,
			'visible' => false,
			'page' => 1,
			'loading' => false,
			'hasMore' => false,
			'list' => [],
		],
	];
}
