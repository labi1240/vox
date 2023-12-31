<?php

namespace Voxel\Dynamic_Tags;

if ( ! defined('ABSPATH') ) {
	exit;
}

abstract class Base_Group {

	protected static $properties;
	protected static $methods;

	public $key;
	public $label;

	public $post;
	public $post_type;

	public function __construct() {
		if ( \Voxel\is_elementor_ajax() ) {
			$this->editor_init();
		} elseif ( \Voxel\is_edit_mode() ) {
			$this->editor_init();
		} else {
			$this->frontend_init();
		}
	}

	public function get_key(): string {
		return $this->key;
	}

	public function get_id(): string {
		return $this->key;
	}

	public function set_key( string $key ) {
		$this->key = $key;
	}

	public function get_label(): string {
		return $this->label;
	}

	public function set_label( string $label ) {
		$this->label = $label;
	}

	abstract protected function properties(): array;

	protected function methods(): array {
		return [];
	}

	protected function editor_init(): void {
		//
	}

	protected function frontend_init(): void {
		//
	}

	public function get_properties() {
		return $this->properties();
	}

	public function get_methods() {
		if ( ! isset( static::$methods[ $this->get_key() ] ) ) {
			static::$methods[ $this->get_key() ] = [];
			foreach ( $this->methods() as $key => $cls ) {
				static::$methods[ $this->get_key() ][ $key ] = new $cls;
			}
		}

		return static::$methods[ $this->get_key() ];
	}

	public function get_property( $path ) {
		$properties = $this->get_properties();

		$keys = explode( '.', $path );
		$key = array_shift( $keys );

		$parent = null;
		$property = $properties[ $key ] ?? null;
		if ( $property === null ) {
			return null;
		}

		if ( isset( $property['before_callback'] ) ) {
			$before_callback = $property['before_callback']( $this );
			if ( $before_callback === false ) {
				return null;
			}
		}

		$property['_key'] = $key;

		foreach ( $keys as $key ) {
			if ( ! isset( $property['properties'][ $key ] ) ) {
				return null;
			}

			$parent = $property;
			$property = $property['properties'][ $key ];
			$property['_key'] = $key;

			if ( isset( $property['before_callback'] ) ) {
				$before_callback = $property['before_callback']( $this );
				if ( $before_callback === false ) {
					return null;
				}
			}
		}

		/*if ( $property['type'] === \Voxel\T_OBJECT ) {
			if ( isset( $property['properties'][':default'] ) ) {
				$property = $property['properties'][':default'];
				$property['_key'] = ':default';
			} else {
				return null;
			}
		}*/

		$loop_index = 0;
		if ( $parent !== null && ! empty( $parent['loopable'] ) ) {
			$parent_path = substr( $path, 0, -( strlen( $property['_key'] ) + 1 ) );
			$loop_id = sprintf( '@%s(%s)', $this->get_key(), $parent_path );
			if ( \Voxel\Dynamic_Tags\Loop::is_running( $loop_id ) ) {
				$loop_index = \Voxel\Dynamic_Tags\Loop::get_index( $loop_id );
			}
		}

		$property['_loop_index'] = $loop_index;
		return $property;
	}

	public function set_post_type( \Voxel\Post_Type $post_type ) {
		$this->post_type = $post_type;
	}

	public function get_post() {
		if ( $this->post === null ) {
			$this->post = \Voxel\get_current_post() ?? \Voxel\Post::dummy();
		}

		return $this->post;
	}

	public function get_post_type() {
		if ( $this->post_type === null ) {
			$this->post_type = \Voxel\get_current_post_type() ?? \Voxel\Post_Type::get('post');
		}

		return $this->post_type;
	}

	protected function _post_properties( $is_profile = false ): array {
		$properties = [
			':id' => [
				'label' => 'ID',
				'type' => \Voxel\T_NUMBER,
				'callback' => function() {
					return $this->get_post()->get_id();
				},
			],

			':title' => [
				'label' => 'Title',
				'type' => \Voxel\T_STRING,
				'callback' => function() {
					return $this->get_post()->get_title();
				},
			],

			':content' => [
				'label' => 'Content',
				'type' => \Voxel\T_STRING,
				'callback' => function() {
					// prevent memory leak when elementor uses $document->save_plain_text();
					if ( \Voxel\is_elementor_ajax() ) {
						return $this->get_post()->get_content();
					}

					return apply_filters( 'the_content', $this->get_post()->get_content() );
				},
			],

			':excerpt' => [
				'label' => 'Excerpt',
				'type' => \Voxel\T_STRING,
				'callback' => function() {
					return $this->get_post()->get_excerpt();
				},
			],

			':date' => [
				'label' => 'Date',
				'type' => \Voxel\T_DATE,
				'callback' => function() {
					$wp_post = $this->get_post()->get_wp_post_object();
					return $wp_post->post_date;
				},
			],

			':modified_date' => [
				'label' => 'Last modified date',
				'type' => \Voxel\T_DATE,
				'callback' => function() {
					$wp_post = $this->get_post()->get_wp_post_object();
					return $wp_post->post_modified;
				},
			],

			':expiry_date' => [
				'label' => 'Expiration date',
				'type' => \Voxel\T_DATE,
				'callback' => function() {
					return $this->get_post()->get_expiry_date() ?? '';
				},
			],

			':logo' => [
				'label' => 'Logo',
				'type' => \Voxel\T_NUMBER,
				'callback' => function() {
					return $this->get_post()->get_logo_id();
				},
			],

			':url' => [
				'label' => 'Permalink',
				'type' => \Voxel\T_URL,
				'callback' => function() {
					return $this->get_post()->get_link();
				},
			],

			':edit_url' => [
				'label' => 'Edit link',
				'type' => \Voxel\T_URL,
				'callback' => function() {
					return $this->get_post()->get_edit_link();
				},
			],

			':slug' => [
				'label' => 'Slug',
				'type' => \Voxel\T_STRING,
				'callback' => function() {
					return $this->get_post()->get_slug();
				},
			],

			':status' => [
				'label' => 'Status',
				'type' => \Voxel\T_OBJECT,
				'properties' => [
					'key' => [
						'label' => 'Key',
						'type' => \Voxel\T_STRING,
						'callback' => function() {
							return $this->get_post()->get_status();
						},
					],
					'label' => [
						'label' => 'Label',
						'type' => \Voxel\T_STRING,
						'callback' => function() {
							global $wp_post_statuses;
							return $wp_post_statuses[ $this->get_post()->get_status() ]->label ?? '';
						},
					],
				],
			],

			':post_type' => [
				'label' => 'Post type',
				'type' => \Voxel\T_OBJECT,
				'properties' => [
					'singular' => [
						'label' => 'Singular name',
						'type' => \Voxel\T_STRING,
						'callback' => function() {
							$post_type = $this->get_post()->post_type;
							return $post_type ? $post_type->get_singular_name() : '';
						},
					],

					'plural' => [
						'label' => 'Plural name',
						'type' => \Voxel\T_STRING,
						'callback' => function() {
							$post_type = $this->get_post()->post_type;
							return $post_type ? $post_type->get_plural_name() : '';
						},
					],
				],
			],

			':reviews' => [
				'label' => 'Reviews',
				'type' => \Voxel\T_OBJECT,
				'properties' => [
					'total' => [
						'label' => 'Total count',
						'type' => \Voxel\T_NUMBER,
						'callback' => function() {
							$stats = $this->get_post()->repository->get_review_stats();
							return absint( $stats['total'] );
						},
					],
					'average' => [
						'label' => 'Average rating',
						'type' => \Voxel\T_NUMBER,
						'callback' => function() {
							$stats = $this->get_post()->repository->get_review_stats();
							if ( $stats['average'] === null ) {
								return '';
							}

							// convert scale from -2..2 to 1..5
							return round( ( $stats['average'] + 3 ), 2 );
						},
					],
					'percentage' => [
						'label' => 'Percentage',
						'type' => \Voxel\T_NUMBER,
						'callback' => function() {
							$stats = $this->get_post()->repository->get_review_stats();
							if ( $stats['average'] === null ) {
								return '0';
							}

							$average = \Voxel\clamp( $stats['average'] + 2, 0, 4 );
							return round( ( $average / 4 ) * 100 );
						},
					],
					'latest' => [
						'label' => 'Latest review',
						'type' => \Voxel\T_OBJECT,
						'properties' => [
							'id' => [
								'label' => 'ID',
								'type' => \Voxel\T_NUMBER,
								'callback' => function() {
									$stats = $this->get_post()->repository->get_review_stats();
									return $stats['latest']['id'] ?? null;
								},
							],
							'created_at' => [
								'label' => 'Date created',
								'type' => \Voxel\T_NUMBER,
								'callback' => function() {
									$stats = $this->get_post()->repository->get_review_stats();
									return $stats['latest']['created_at'] ?? null;
								},
							],
							'author' => [
								'label' => 'Author',
								'type' => \Voxel\T_OBJECT,
								'properties' => [
									'name' => [
										'label' => 'Name',
										'type' => \Voxel\T_STRING,
										'callback' => function() {
											$stats = $this->get_post()->repository->get_review_stats();
											$user = \Voxel\User::get( $stats['latest']['user_id'] ?? null );
											$post = \Voxel\Post::get( $stats['latest']['published_as'] ?? null );
											return $user ? $user->get_display_name() : ( $post ? $post->get_title() : null );
										},
									],
									'link' => [
										'label' => 'Link',
										'type' => \Voxel\T_URL,
										'callback' => function() {
											$stats = $this->get_post()->repository->get_review_stats();
											$user = \Voxel\User::get( $stats['latest']['user_id'] ?? null );
											$post = \Voxel\Post::get( $stats['latest']['published_as'] ?? null );
											return $user ? $user->get_link() : ( $post ? $post->get_link() : null );
										},
									],
									'avatar' => [
										'label' => 'Avatar',
										'type' => \Voxel\T_NUMBER,
										'callback' => function() {
											$stats = $this->get_post()->repository->get_review_stats();
											$user = \Voxel\User::get( $stats['latest']['user_id'] ?? null );
											$post = \Voxel\Post::get( $stats['latest']['published_as'] ?? null );
											return $user ? $user->get_avatar_id() : ( $post ? $post->get_logo_id() : null );
										},
									],
								],
							],
						],
					],
					'replies' => [
						'label' => 'Replies',
						'type' => \Voxel\T_OBJECT,
						'properties' => [
							'total' => [
								'label' => 'Total count',
								'type' => \Voxel\T_NUMBER,
								'callback' => function() {
									$stats = $this->get_post()->repository->get_review_reply_stats();
									return absint( $stats['total'] );
								},
							],
							'latest' => [
								'label' => 'Latest reply',
								'type' => \Voxel\T_OBJECT,
								'properties' => [
									'id' => [
										'label' => 'ID',
										'type' => \Voxel\T_NUMBER,
										'callback' => function() {
											$stats = $this->get_post()->repository->get_review_reply_stats();
											return $stats['latest']['id'] ?? null;
										},
									],
									'created_at' => [
										'label' => 'Date created',
										'type' => \Voxel\T_NUMBER,
										'callback' => function() {
											$stats = $this->get_post()->repository->get_review_reply_stats();
											return $stats['latest']['created_at'] ?? null;
										},
									],
									'author' => [
										'label' => 'Author',
										'type' => \Voxel\T_OBJECT,
										'properties' => [
											'name' => [
												'label' => 'Name',
												'type' => \Voxel\T_STRING,
												'callback' => function() {
													$stats = $this->get_post()->repository->get_review_reply_stats();
													$user = \Voxel\User::get( $stats['latest']['user_id'] ?? null );
													$post = \Voxel\Post::get( $stats['latest']['published_as'] ?? null );
													return $user ? $user->get_display_name() : ( $post ? $post->get_title() : null );
												},
											],
											'link' => [
												'label' => 'Link',
												'type' => \Voxel\T_URL,
												'callback' => function() {
													$stats = $this->get_post()->repository->get_review_reply_stats();
													$user = \Voxel\User::get( $stats['latest']['user_id'] ?? null );
													$post = \Voxel\Post::get( $stats['latest']['published_as'] ?? null );
													return $user ? $user->get_link() : ( $post ? $post->get_link() : null );
												},
											],
											'avatar' => [
												'label' => 'Avatar',
												'type' => \Voxel\T_NUMBER,
												'callback' => function() {
													$stats = $this->get_post()->repository->get_review_reply_stats();
													$user = \Voxel\User::get( $stats['latest']['user_id'] ?? null );
													$post = \Voxel\Post::get( $stats['latest']['published_as'] ?? null );
													return $user ? $user->get_avatar_id() : ( $post ? $post->get_logo_id() : null );
												},
											],
										],
									],
								],
							],
						],
					],
				],
			],

			':timeline' => [
				'label' => 'Timeline posts',
				'type' => \Voxel\T_OBJECT,
				'properties' => [
					'total' => [
						'label' => 'Total count',
						'type' => \Voxel\T_NUMBER,
						'callback' => function() {
							$stats = $this->get_post()->repository->get_timeline_stats();
							return absint( $stats['total'] );
						},
					],
					'latest' => [
						'label' => 'Latest post',
						'type' => \Voxel\T_OBJECT,
						'properties' => [
							'id' => [
								'label' => 'ID',
								'type' => \Voxel\T_NUMBER,
								'callback' => function() {
									$stats = $this->get_post()->repository->get_timeline_stats();
									return $stats['latest']['id'] ?? null;
								},
							],
							'created_at' => [
								'label' => 'Date created',
								'type' => \Voxel\T_NUMBER,
								'callback' => function() {
									$stats = $this->get_post()->repository->get_timeline_stats();
									return $stats['latest']['created_at'] ?? null;
								},
							],
						],
					],
					'replies' => [
						'label' => 'Replies',
						'type' => \Voxel\T_OBJECT,
						'properties' => [
							'total' => [
								'label' => 'Total count',
								'type' => \Voxel\T_NUMBER,
								'callback' => function() {
									$stats = $this->get_post()->repository->get_timeline_reply_stats();
									return absint( $stats['total'] );
								},
							],
							'latest' => [
								'label' => 'Latest reply',
								'type' => \Voxel\T_OBJECT,
								'properties' => [
									'id' => [
										'label' => 'ID',
										'type' => \Voxel\T_NUMBER,
										'callback' => function() {
											$stats = $this->get_post()->repository->get_timeline_reply_stats();
											return $stats['latest']['id'] ?? null;
										},
									],
									'created_at' => [
										'label' => 'Date created',
										'type' => \Voxel\T_NUMBER,
										'callback' => function() {
											$stats = $this->get_post()->repository->get_timeline_reply_stats();
											return $stats['latest']['created_at'] ?? null;
										},
									],
									'author' => [
										'label' => 'Author',
										'type' => \Voxel\T_OBJECT,
										'properties' => [
											'name' => [
												'label' => 'Name',
												'type' => \Voxel\T_STRING,
												'callback' => function() {
													$stats = $this->get_post()->repository->get_timeline_reply_stats();
													$user = \Voxel\User::get( $stats['latest']['user_id'] ?? null );
													$post = \Voxel\Post::get( $stats['latest']['published_as'] ?? null );
													return $user ? $user->get_display_name() : ( $post ? $post->get_title() : null );
												},
											],
											'link' => [
												'label' => 'Link',
												'type' => \Voxel\T_URL,
												'callback' => function() {
													$stats = $this->get_post()->repository->get_timeline_reply_stats();
													$user = \Voxel\User::get( $stats['latest']['user_id'] ?? null );
													$post = \Voxel\Post::get( $stats['latest']['published_as'] ?? null );
													return $user ? $user->get_link() : ( $post ? $post->get_link() : null );
												},
											],
											'avatar' => [
												'label' => 'Avatar',
												'type' => \Voxel\T_NUMBER,
												'callback' => function() {
													$stats = $this->get_post()->repository->get_timeline_reply_stats();
													$user = \Voxel\User::get( $stats['latest']['user_id'] ?? null );
													$post = \Voxel\Post::get( $stats['latest']['published_as'] ?? null );
													return $user ? $user->get_avatar_id() : ( $post ? $post->get_logo_id() : null );
												},
											],
										],
									],
								],
							],
						],
					],
				],
			],

			':wall' => [
				'label' => 'Wall posts',
				'type' => \Voxel\T_OBJECT,
				'properties' => [
					'total' => [
						'label' => 'Total count',
						'type' => \Voxel\T_NUMBER,
						'callback' => function() {
							$stats = $this->get_post()->repository->get_wall_stats();
							return absint( $stats['total'] );
						},
					],
					'total_with_replies' => [
						'label' => 'Total count (including replies)',
						'type' => \Voxel\T_NUMBER,
						'callback' => function() {
							$stats = $this->get_post()->repository->get_wall_stats();
							$reply_stats = $this->get_post()->repository->get_wall_reply_stats();
							return absint( $stats['total'] ) + absint( $reply_stats['total'] );
						},
					],
					'latest' => [
						'label' => 'Latest post',
						'type' => \Voxel\T_OBJECT,
						'properties' => [
							'id' => [
								'label' => 'ID',
								'type' => \Voxel\T_NUMBER,
								'callback' => function() {
									$stats = $this->get_post()->repository->get_wall_stats();
									return $stats['latest']['id'] ?? null;
								},
							],
							'created_at' => [
								'label' => 'Date created',
								'type' => \Voxel\T_NUMBER,
								'callback' => function() {
									$stats = $this->get_post()->repository->get_wall_stats();
									return $stats['latest']['created_at'] ?? null;
								},
							],
							'author' => [
								'label' => 'Author',
								'type' => \Voxel\T_OBJECT,
								'properties' => [
									'name' => [
										'label' => 'Name',
										'type' => \Voxel\T_STRING,
										'callback' => function() {
											$stats = $this->get_post()->repository->get_wall_stats();
											$user = \Voxel\User::get( $stats['latest']['user_id'] ?? null );
											$post = \Voxel\Post::get( $stats['latest']['published_as'] ?? null );
											return $user ? $user->get_display_name() : ( $post ? $post->get_title() : null );
										},
									],
									'link' => [
										'label' => 'Link',
										'type' => \Voxel\T_URL,
										'callback' => function() {
											$stats = $this->get_post()->repository->get_wall_stats();
											$user = \Voxel\User::get( $stats['latest']['user_id'] ?? null );
											$post = \Voxel\Post::get( $stats['latest']['published_as'] ?? null );
											return $user ? $user->get_link() : ( $post ? $post->get_link() : null );
										},
									],
									'avatar' => [
										'label' => 'Avatar',
										'type' => \Voxel\T_NUMBER,
										'callback' => function() {
											$stats = $this->get_post()->repository->get_wall_stats();
											$user = \Voxel\User::get( $stats['latest']['user_id'] ?? null );
											$post = \Voxel\Post::get( $stats['latest']['published_as'] ?? null );
											return $user ? $user->get_avatar_id() : ( $post ? $post->get_logo_id() : null );
										},
									],
								],
							],
						],
					],
					'replies' => [
						'label' => 'Replies',
						'type' => \Voxel\T_OBJECT,
						'properties' => [
							'total' => [
								'label' => 'Total count',
								'type' => \Voxel\T_NUMBER,
								'callback' => function() {
									$stats = $this->get_post()->repository->get_wall_reply_stats();
									return absint( $stats['total'] );
								},
							],
							'latest' => [
								'label' => 'Latest reply',
								'type' => \Voxel\T_OBJECT,
								'properties' => [
									'id' => [
										'label' => 'ID',
										'type' => \Voxel\T_NUMBER,
										'callback' => function() {
											$stats = $this->get_post()->repository->get_wall_reply_stats();
											return $stats['latest']['id'] ?? null;
										},
									],
									'created_at' => [
										'label' => 'Date created',
										'type' => \Voxel\T_NUMBER,
										'callback' => function() {
											$stats = $this->get_post()->repository->get_wall_reply_stats();
											return $stats['latest']['created_at'] ?? null;
										},
									],
									'author' => [
										'label' => 'Author',
										'type' => \Voxel\T_OBJECT,
										'properties' => [
											'name' => [
												'label' => 'Name',
												'type' => \Voxel\T_STRING,
												'callback' => function() {
													$stats = $this->get_post()->repository->get_wall_reply_stats();
													$user = \Voxel\User::get( $stats['latest']['user_id'] ?? null );
													$post = \Voxel\Post::get( $stats['latest']['published_as'] ?? null );
													return $user ? $user->get_display_name() : ( $post ? $post->get_title() : null );
												},
											],
											'link' => [
												'label' => 'Link',
												'type' => \Voxel\T_URL,
												'callback' => function() {
													$stats = $this->get_post()->repository->get_wall_reply_stats();
													$user = \Voxel\User::get( $stats['latest']['user_id'] ?? null );
													$post = \Voxel\Post::get( $stats['latest']['published_as'] ?? null );
													return $user ? $user->get_link() : ( $post ? $post->get_link() : null );
												},
											],
											'avatar' => [
												'label' => 'Avatar',
												'type' => \Voxel\T_NUMBER,
												'callback' => function() {
													$stats = $this->get_post()->repository->get_wall_reply_stats();
													$user = \Voxel\User::get( $stats['latest']['user_id'] ?? null );
													$post = \Voxel\Post::get( $stats['latest']['published_as'] ?? null );
													return $user ? $user->get_avatar_id() : ( $post ? $post->get_logo_id() : null );
												},
											],
										],
									],
								],
							],
						],
					],
				],
			],

			':followers' => [
				'label' => 'Followers',
				'type' => \Voxel\T_OBJECT,
				'properties' => [
					'accepted' => [
						'label' => 'Follow count',
						'description' => 'Number of users that are following this post',
						'type' => \Voxel\T_NUMBER,
						'callback' => function() {
							$stats = $this->get_post()->repository->get_follow_stats();
							return absint( $stats['followed'][ \Voxel\FOLLOW_ACCEPTED ] ?? 0 );
						},
					],
					'requested' => [
						'label' => 'Follow requested count',
						'description' => 'Number of users that have requested to follow this post',
						'type' => \Voxel\T_NUMBER,
						'callback' => function() {
							$stats = $this->get_post()->repository->get_follow_stats();
							return absint( $stats['followed'][ \Voxel\FOLLOW_REQUESTED ] ?? 0 );
						},
					],
					'blocked' => [
						'label' => 'Block count',
						'description' => 'Number of users that have been blocked by this post',
						'type' => \Voxel\T_NUMBER,
						'callback' => function() {
							$stats = $this->get_post()->repository->get_follow_stats();
							return absint( $stats['followed'][ \Voxel\FOLLOW_BLOCKED ] ?? 0 );
						},
					],
				],
			],
		];

		if ( in_array( $this->get_post_type()->get_key(), (array) \Voxel\get('settings.stats.enabled_post_types'), true ) ) {
			$properties[':stats'] = [
				'label' => 'Stats',
				'type' => \Voxel\T_OBJECT,
				'properties' => [
					'views' => [
						'label' => 'Views',
						'type' => \Voxel\T_OBJECT,
						'properties' => [
							'1d' => [
								'label' => 'Last 24 hours',
								'type' => \Voxel\T_NUMBER,
								'callback' => function() {
									return $this->get_post()->stats->get_views('1d');
								},
							],
							'7d' => [
								'label' => 'Last 7 days',
								'type' => \Voxel\T_NUMBER,
								'callback' => function() {
									return $this->get_post()->stats->get_views('7d');
								},
							],
							'30d' => [
								'label' => 'Last 30 days',
								'type' => \Voxel\T_NUMBER,
								'callback' => function() {
									return $this->get_post()->stats->get_views('30d');
								},
							],
							'all' => [
								'label' => 'All',
								'type' => \Voxel\T_NUMBER,
								'callback' => function() {
									return $this->get_post()->stats->get_views('all');
								},
							],
						],
					],
					'unique_views' => [
						'label' => 'Unique views',
						'type' => \Voxel\T_OBJECT,
						'properties' => [
							'1d' => [
								'label' => 'Last 24 hours',
								'type' => \Voxel\T_NUMBER,
								'callback' => function() {
									return $this->get_post()->stats->get_unique_views('1d');
								},
							],
							'7d' => [
								'label' => 'Last 7 days',
								'type' => \Voxel\T_NUMBER,
								'callback' => function() {
									return $this->get_post()->stats->get_unique_views('7d');
								},
							],
							'30d' => [
								'label' => 'Last 30 days',
								'type' => \Voxel\T_NUMBER,
								'callback' => function() {
									return $this->get_post()->stats->get_unique_views('30d');
								},
							],
							'all' => [
								'label' => 'All',
								'type' => \Voxel\T_NUMBER,
								'callback' => function() {
									return $this->get_post()->stats->get_unique_views('all');
								},
							],
						],
					],
					'countries' => [
						'label' => 'Top countries',
						'type' => \Voxel\T_OBJECT,
						'loopable' => true,
						'loopcount' => function() {
							$countries = $this->get_post()->stats->get_tracking_stats('countries');
							return count( $countries );
						},
						'properties' => [
							'name' => [
								'label' => 'Country name',
								'type' => \Voxel\T_STRING,
								'callback' => function( $index ) {
									$item = $this->get_post()->stats->get_tracking_stats('countries')[ $index ] ?? null;
									if ( ! is_array( $item ) ) {
										return '';
									}

									$list = \Voxel\Data\Country_List::all();
									return $list[ $item['item'] ?? '' ]['name'] ?? '';
								},
							],
							'count' => [
								'label' => 'View count',
								'type' => \Voxel\T_NUMBER,
								'callback' => function( $index ) {
									$item = $this->get_post()->stats->get_tracking_stats('countries')[ $index ] ?? null;
									return $item['count'] ?? 0;
								},
							],
							'code' => [
								'label' => 'Country code',
								'type' => \Voxel\T_STRING,
								'callback' => function( $index ) {
									$item = $this->get_post()->stats->get_tracking_stats('countries')[ $index ] ?? null;
									return $item['item'] ?? '';
								},
							],
						],
					],
					'ref_domains' => [
						'label' => 'Top referrers (domains)',
						'type' => \Voxel\T_OBJECT,
						'loopable' => true,
						'loopcount' => function() {
							$domains = $this->get_post()->stats->get_tracking_stats('ref_domains');
							return count( $domains );
						},
						'properties' => [
							'name' => [
								'label' => 'Domain name',
								'type' => \Voxel\T_STRING,
								'callback' => function( $index ) {
									$item = $this->get_post()->stats->get_tracking_stats('ref_domains')[ $index ] ?? null;
									return $item['item'] ?? '';
								},
							],
							'count' => [
								'label' => 'Referral count',
								'type' => \Voxel\T_NUMBER,
								'callback' => function( $index ) {
									$item = $this->get_post()->stats->get_tracking_stats('ref_domains')[ $index ] ?? null;
									return $item['count'] ?? 0;
								},
							],
						],
					],
					'ref_urls' => [
						'label' => 'Top referrers (URLs)',
						'type' => \Voxel\T_OBJECT,
						'loopable' => true,
						'loopcount' => function() {
							$ref_urls = $this->get_post()->stats->get_tracking_stats('ref_urls');
							return count( $ref_urls );
						},
						'properties' => [
							'name' => [
								'label' => 'URL',
								'type' => \Voxel\T_STRING,
								'callback' => function( $index ) {
									$item = $this->get_post()->stats->get_tracking_stats('ref_urls')[ $index ] ?? null;
									return $item['item'] ?? '';
								},
							],
							'count' => [
								'label' => 'Referral count',
								'type' => \Voxel\T_NUMBER,
								'callback' => function( $index ) {
									$item = $this->get_post()->stats->get_tracking_stats('ref_urls')[ $index ] ?? null;
									return $item['count'] ?? 0;
								},
							],
						],
					],
					'browsers' => [
						'label' => 'Top browsers',
						'type' => \Voxel\T_OBJECT,
						'loopable' => true,
						'loopcount' => function() {
							$browsers = $this->get_post()->stats->get_tracking_stats('browsers');
							return count( $browsers );
						},
						'properties' => [
							'name' => [
								'label' => 'Browser',
								'type' => \Voxel\T_STRING,
								'callback' => function( $index ) {
									$item = $this->get_post()->stats->get_tracking_stats('browsers')[ $index ] ?? null;
									return \Voxel\Stats\get_browser_label( $item['item'] ?? '' );
								},
							],
							'count' => [
								'label' => 'View count',
								'type' => \Voxel\T_NUMBER,
								'callback' => function( $index ) {
									$item = $this->get_post()->stats->get_tracking_stats('browsers')[ $index ] ?? null;
									return $item['count'] ?? 0;
								},
							],
						],
					],
					'platforms' => [
						'label' => 'Top platforms',
						'type' => \Voxel\T_OBJECT,
						'loopable' => true,
						'loopcount' => function() {
							$platforms = $this->get_post()->stats->get_tracking_stats('platforms');
							return count( $platforms );
						},
						'properties' => [
							'name' => [
								'label' => 'Platform',
								'type' => \Voxel\T_STRING,
								'callback' => function( $index ) {
									$item = $this->get_post()->stats->get_tracking_stats('platforms')[ $index ] ?? null;
									return \Voxel\Stats\get_platform_label( $item['item'] ?? '' );
								},
							],
							'count' => [
								'label' => 'View count',
								'type' => \Voxel\T_NUMBER,
								'callback' => function( $index ) {
									$item = $this->get_post()->stats->get_tracking_stats('platforms')[ $index ] ?? null;
									return $item['count'] ?? 0;
								},
							],
						],
					],
					'devices' => [
						'label' => 'Devices',
						'type' => \Voxel\T_OBJECT,
						'loopable' => true,
						'loopcount' => function() {
							$devices = $this->get_post()->stats->get_tracking_stats('devices');
							return count( $devices );
						},
						'properties' => [
							'name' => [
								'label' => 'Device',
								'type' => \Voxel\T_STRING,
								'callback' => function( $index ) {
									$item = $this->get_post()->stats->get_tracking_stats('devices')[ $index ] ?? null;
									return \Voxel\Stats\get_device_label( $item['item'] ?? '' );
								},
							],
							'count' => [
								'label' => 'View count',
								'type' => \Voxel\T_NUMBER,
								'callback' => function( $index ) {
									$item = $this->get_post()->stats->get_tracking_stats('devices')[ $index ] ?? null;
									return $item['count'] ?? 0;
								},
							],
						],
					],
					'last_updated' => [
						'label' => 'Last updated',
						'type' => \Voxel\T_DATE,
						'callback' => function() {
							$time = $this->get_post()->stats->get_last_updated_time();
							return date( 'Y-m-d H:i:s', $time );
						},
					],
				],
			];
		}

		if ( ! $is_profile && $this->get_post_type()->get_key() === 'collection' ) {
			$properties[':item_counts'] = [
				'label' => 'Item counts',
				'type' => \Voxel\T_OBJECT,
				'properties' => $this->_collection_counts(),
			];
		}

		if ( $is_profile && \Voxel\Post_Type::get('profile') ) {
			$fields = \Voxel\Post_Type::get('profile')->get_fields();
		} elseif ( $this->get_post() ) {
			$fields = $this->get_post()->get_fields();
		} else {
			$fields = [];
		}

		foreach ( $fields as $field ) {
			$exports = $field->exports();
			if ( $exports === null ) {
				continue;
			}

			if ( $is_profile ) {
				$exports['before_callback'] = function( $group ) use ( $field ) {
					$field->set_post( $group->get_post() );
				};
			}

			if ( isset( $this->before_field_callback ) ) {
				$exports['before_callback'] = function() use ( $field ) {
					($this->before_field_callback)( $field );
				};
			}

			$properties[ $field->get_key() ] = $exports;
		}

		return $properties;
	}

	protected function _collection_counts() {
		$items = [];
		foreach ( \Voxel\Post_Type::get( 'collection' )->get_field('items')->get_prop('post_types') as $post_type_key ) {
			if ( $post_type = \Voxel\Post_Type::get( $post_type_key ) ) {
				$items[ $post_type->get_key() ] = [
					'label' => $post_type->get_label(),
					'type' => \Voxel\T_NUMBER,
					'callback' => function() use ( $post_type ) {
						$post = $this->get_post();
						$collection_id = absint( $post->get_id() );

						if ( ! isset( $GLOBALS['vx_collection_counts'] ) ) {
							$GLOBALS['vx_collection_counts'] = [];
						}

						if ( isset( $GLOBALS['vx_collection_counts'][ $collection_id ] ) ) {
							$counts = $GLOBALS['vx_collection_counts'][ $collection_id ];
						} else {
							global $wpdb;
							$counts = $wpdb->get_results( <<<SQL
								SELECT posts.post_type, COUNT(*) AS total FROM {$wpdb->prefix}voxel_relations AS relations
									LEFT JOIN {$wpdb->posts} AS posts ON ( relations.child_id = posts.ID )
								WHERE relations.parent_id = {$collection_id}
									AND relations.relation_key = 'items'
									AND posts.post_status = 'publish'
								GROUP BY post_type
							SQL, OBJECT_K );
							$GLOBALS['vx_collection_counts'][ $collection_id ] = $counts;
						}

						return absint( $counts[ $post_type->get_key() ]->total ?? 0 );
					},
				];
			}
		}

		return $items;
	}

}
