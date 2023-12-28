<?php

namespace Voxel\Controllers\Frontend\Timeline;

if ( ! defined('ABSPATH') ) {
	exit;
}

class Status_Controller extends \Voxel\Controllers\Base_Controller {

	protected function hooks() {
		$this->on( 'voxel_ajax_timeline.status.publish', '@publish_status' );
		$this->on( 'voxel_ajax_timeline.status.edit', '@edit_status' );
		$this->on( 'voxel_ajax_timeline.status.delete', '@delete_status' );
		$this->on( 'voxel_ajax_timeline.status.like', '@like_status' );
		$this->on( 'voxel_ajax_timeline.status.get_replies', '@get_replies' );
		$this->on( 'voxel_ajax_nopriv_timeline.status.get_replies', '@get_replies' );
	}

	protected function publish_status() {
		try {
			// request validation
			$mode = sanitize_text_field( $_GET['mode'] ?? '' );
			if ( ! in_array( $mode, [ 'post_reviews', 'post_timeline', 'post_wall', 'author_timeline', 'user_feed' ], true ) ) {
				throw new \Exception( _x( 'Something went wrong.', 'voxel' ), 90 );
			}

			$current_user = \Voxel\current_user();
			if ( $current_user->has_reached_status_rate_limit() ) {
				throw new \Exception( _x( 'You\'re posting too often, try again later.', 'timeline', 'voxel' ) );
			}

			// post validation
			if ( in_array( $mode, [ 'post_reviews', 'post_timeline', 'post_wall' ], true ) ) {
				$post = \Voxel\Post::get( $_GET['post_id'] ?? null );
			} elseif ( in_array( $mode, [ 'author_timeline', 'user_feed' ], true ) ) {
				$post = $current_user->get_or_create_profile();
			} else {
				$post = null;
			}

			if ( ! ( $post && $post->post_type ) ) {
				throw new \Exception( _x( 'Could not find post.', 'timeline', 'voxel' ), 91 );
			}

			if ( $post->get_status() !== 'publish' ) {
				throw new \Exception( _x( 'Could not publish to post.', 'timeline', 'voxel' ), 92 );
			}

			$values = json_decode( wp_unslash( $_POST['fields'] ), true );

			if ( $mode === 'post_wall' ) {
				if ( ! $current_user->can_post_to_wall( $post->get_id() ) ) {
					throw new \Exception( _x( 'You cannot post to this item\'s wall.', 'timeline', 'voxel' ), 100 );
				}

				$content = $this->sanitize_content( $values['message'] ?? '' );
				$files = $this->sanitize_files( $values['files'] ?? [] );

				if ( empty( $content ) && empty( $files ) ) {
					throw new \Exception( _x( 'Post cannot be empty.', 'timeline', 'voxel' ), 101 );
				}

				$details = [];
				if ( ! empty( $files ) ) {
					$details['files'] = $files;
				}

				$status = \Voxel\Timeline\Status::create( [
					'user_id' => $current_user->get_id(),
					'post_id' => $post->get_id(),
					'content' => $content,
					'details' => ! empty( $details ) ? $details : null,
				] );

				( new \Voxel\Events\Wall_Post_Created_Event( $post->post_type ) )->dispatch( $status->get_id() );

				return wp_send_json( [
					'success' => true,
					'status' => \Voxel\Timeline\prepare_status_json( $status ),
				] );
			} elseif ( $mode === 'post_timeline' ) {
				if ( ! $post->is_editable_by_current_user() ) {
					throw new \Exception( _x( 'You do not have permission to post as this page.', 'timeline', 'voxel' ) );
				}

				if ( ! $post->post_type->get_setting( 'timeline.enabled' ) ) {
					throw new \Exception( _x( 'Timeline posts are not enabled for this post type.', 'timeline', 'voxel' ) );
				}

				$content = $this->sanitize_content( $values['message'] ?? '' );
				$files = $this->sanitize_files( $values['files'] ?? [] );

				if ( empty( $content ) && empty( $files ) ) {
					throw new \Exception( _x( 'Post cannot be empty.', 'timeline', 'voxel' ), 101 );
				}

				$details = [
					'posted_by' => $current_user->get_id(),
				];

				if ( ! empty( $files ) ) {
					$details['files'] = $files;
				}

				$status = \Voxel\Timeline\Status::create( [
					'published_as' => $post->get_id(),
					'post_id' => $post->get_id(),
					'content' => $content,
					'details' => $details,
				] );

				( new \Voxel\Events\Timeline_Status_Created_Event( $post->post_type ) )->dispatch( $status->get_id() );

				return wp_send_json( [
					'success' => true,
					'status' => \Voxel\Timeline\prepare_status_json( $status ),
				] );
			} elseif ( $mode === 'post_reviews' ) {
				if ( ! $current_user->can_review_post( $post->get_id() ) ) {
					throw new \Exception( _x( 'You\'re not allowed to review this item.', 'timeline', 'voxel' ) );
				}

				if ( $current_user->has_reviewed_post( $post->get_id() ) ) {
					throw new \Exception( _x( 'You have already reviewed this item.', 'timeline', 'voxel' ) );
				}

				$ratings = $this->sanitize_ratings( $values['ratings'] ?? [], $post );
				if ( empty( $ratings ) ) {
					throw new \Exception( _x( 'Choose a rating.', 'timeline', 'voxel' ) );
				}

				$review_score = array_sum( $ratings ) / count( $ratings );
				$content = $this->sanitize_content( $values['message'] ?? '' );
				$files = $this->sanitize_files( $values['files'] ?? [] );

				$details = [
					'rating' => $ratings,
				];

				if ( ! empty( $files ) ) {
					$details['files'] = $files;
				}

				$status = \Voxel\Timeline\Status::create( [
					'user_id' => $current_user->get_id(),
					'post_id' => $post->get_id(),
					'content' => $content,
					'details' => $details,
					'review_score' => $review_score,
				] );

				( new \Voxel\Events\Review_Created_Event( $post->post_type ) )->dispatch( $status->get_id() );

				return wp_send_json( [
					'success' => true,
					'status' => \Voxel\Timeline\prepare_status_json( $status ),
				] );
			} elseif ( $mode === 'author_timeline' || $mode === 'user_feed' ) {
				if ( ! $current_user->can_post_to_wall( $post->get_id() ) ) {
					throw new \Exception( _x( 'You cannot post to this item\'s wall.', 'timeline', 'voxel' ), 100 );
				}

				$content = $this->sanitize_content( $values['message'] ?? '' );
				$files = $this->sanitize_files( $values['files'] ?? [] );

				if ( empty( $content ) && empty( $files ) ) {
					throw new \Exception( _x( 'Post cannot be empty.', 'timeline', 'voxel' ), 101 );
				}

				$details = [];
				if ( ! empty( $files ) ) {
					$details['files'] = $files;
				}

				$status = \Voxel\Timeline\Status::create( [
					'user_id' => $current_user->get_id(),
					'post_id' => $post->get_id(),
					'content' => $content,
					'details' => ! empty( $details ) ? $details : null,
				] );

				( new \Voxel\Events\Wall_Post_Created_Event( $post->post_type ) )->dispatch( $status->get_id() );

				return wp_send_json( [
					'success' => true,
					'status' => \Voxel\Timeline\prepare_status_json( $status ),
				] );
			} else {
				throw new \Exception( _x( 'Something went wrong.', 'voxel' ), 101 );
			}
		} catch ( \Exception $e ) {
			return wp_send_json( [
				'success' => false,
				'message' => $e->getMessage(),
			] );
		}
	}

	protected function edit_status() {
		try {
			$current_user = \Voxel\current_user();
			$status_id = absint( $_GET['status_id'] ?? null );
			$values = json_decode( wp_unslash( $_POST['fields'] ?? [] ), true );

			$status = \Voxel\Timeline\Status::get( $status_id );
			$editing_allowed = !! \Voxel\get( 'settings.timeline.posts.editable', true );
			if ( ! ( $status && $status->is_editable_by_current_user() && $editing_allowed ) ) {
				throw new \Exception( _x( 'You cannot edit this post.', 'timeline', 'voxel' ) );
			}

			$content = $this->sanitize_content( $values['message'] ?? '' );
			$files = $this->sanitize_files( $values['files'] ?? [] );
			if ( $status->is_review() ) {
				$ratings = $this->sanitize_ratings( $values['ratings'] ?? [], $status->get_post() );
				if ( empty( $ratings ) ) {
					throw new \Exception( _x( 'Choose a rating.', 'timeline', 'voxel' ) );
				}

				$review_score = array_sum( $ratings ) / count( $ratings );
			}

			if ( empty( $content ) && empty( $files ) && empty( $ratings ) ) {
				throw new \Exception( _x( 'Post cannot be empty.', 'timeline', 'voxel' ) );
			}

			$details = $status->get_details();

			$details['files'] = $files;
			if ( empty( $files ) ) {
				unset( $details['files'] );
			}
			
			if ( $status->is_review() ) {
				$details['rating'] = $ratings;
			}

			$status->update( [
				'content' => $content,
				'details' => $details,
				'review_score' => $review_score ?? null,
				'edited_at' => \Voxel\utc()->format( 'Y-m-d H:i:s' ),
			] );

			return wp_send_json( [
				'success' => true,
				'status' => \Voxel\Timeline\prepare_status_json(
					\Voxel\Timeline\Status::force_get( $status->get_id() )
				),
			] );
		} catch ( \Exception $e ) {
			return wp_send_json( [
				'success' => false,
				'message' => $e->getMessage(),
			] );
		}
	}

	protected function delete_status() {
		try {
			$status = \Voxel\Timeline\Status::get( absint( $_GET['status_id'] ?? null ) );
			if ( ! ( $status && ( $status->is_editable_by_current_user() || $status->is_moderatable_by_current_user() ) ) ) {
				throw new \Exception( _x( 'You cannot delete this post.', 'timeline', 'voxel' ) );
			}

			$status->delete();

			return wp_send_json( [
				'success' => true,
			] );
		} catch ( \Exception $e ) {
			return wp_send_json( [
				'success' => false,
				'message' => $e->getMessage(),
			] );
		}
	}

	protected function like_status() {
		try {
			$status = \Voxel\Timeline\Status::get( absint( $_GET['status_id'] ?? null ) );
			if ( ! $status ) {
				throw new \Exception( _x( 'You cannot like this post.', 'timeline', 'voxel' ) );
			}

			$like_count = $status->get_like_count();
			if ( $status->liked_by_user() ) {
				$status->unlike();
				$like_count--;
				$liked_by_user = false;
			} else {
				$status->like();
				$like_count++;
				$liked_by_user = true;
			}

			return wp_send_json( [
				'success' => true,
				'liked_by_user' => $liked_by_user,
				'like_count' => $like_count ? number_format_i18n( $like_count ) : null,
			] );
		} catch ( \Exception $e ) {
			return wp_send_json( [
				'success' => false,
				'message' => $e->getMessage(),
			] );
		}
	}

	protected function get_replies() {
		try {
			$status = \Voxel\Timeline\Status::get( absint( $_GET['status_id'] ?? null ) );
			if ( ! ( $status && $status->is_viewable_by_current_user() ) ) {
				throw new \Exception( _x( 'Could not load comments.', 'timeline', 'voxel' ) );
			}

			$parent_id = is_numeric( $_GET['parent_id'] ?? null ) ? absint( $_GET['parent_id'] ?? null ) : 0;
			$page = absint( $_GET['page'] ?? 1 );
			$per_page = 10;
			$args = [
				'status_id' => $status->get_id(),
				'parent_id' => $parent_id,
				'limit' => $per_page + 1,
				'with_like_count' => true,
				'with_reply_count' => true,
				'with_user_like_status' => true,
			];

			if ( $page > 1 ) {
				$args['offset'] = ( $page - 1 ) * $per_page;
			}

			$replies = \Voxel\Timeline\Reply::query( $args );
			$has_more = count( $replies ) > $per_page;
			if ( $has_more ) {
				array_pop( $replies );
			}

			$data = array_map( '\Voxel\Timeline\prepare_reply_json', $replies );

			return wp_send_json( [
				'success' => true,
				'data' => $data,
				'has_more' => $has_more,
			] );
		} catch ( \Exception $e ) {
			return wp_send_json( [
				'success' => false,
				'message' => $e->getMessage(),
			] );
		}
	}

	protected function sanitize_ratings( $ratings, $post ) {
		$sanitized = [];
		foreach ( $post->post_type->reviews->get_categories() as $key => $category ) {
			$score = $ratings[ $key ] ?? null;

			if ( $score === null ) {
				if ( $category['required'] ) {
					throw new \Exception( \Voxel\replace_vars( _x( 'You must choose a rating for @category_label', 'reviews', 'voxel' ), [
						'@category_label' => $category['label'],
					] ), 121 );
				} else {
					// no rating submitted for this category and it isn't required, skip
					continue;
				}
			}

			$score = (int) $score;
			if ( ! in_array( $score, [ -2, -1, 0, 1, 2 ], true ) ) {
				throw new \Exception( \Voxel\replace_vars( _x( 'You must choose a rating for @category_label', 'reviews', 'voxel' ), [
					'@category_label' => $category['label'],
				] ), 122 );
			}

			$sanitized[ $key ] = $score;
		}

		return $sanitized;
	}

	protected function sanitize_content( $content ) {
		$field = new \Voxel\Timeline\Fields\Status_Message_Field;
		$content = $field->sanitize( $content );
		$field->validate( $content );

		return $content;
	}

	protected function sanitize_files( $files ) {
		if ( ! \Voxel\get( 'settings.timeline.posts.images.enabled', true ) ) {
			return [];
		}

		$field = new \Voxel\Timeline\Fields\Status_Files_Field;
		$files = $field->sanitize( $files );
		$field->validate( $files );
		$file_ids = $field->prepare_for_storage( $files );

		return $file_ids;
	}
}
