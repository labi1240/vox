<?php

namespace Voxel\Dynamic_Tags;

if ( ! defined('ABSPATH') ) {
	exit;
}

class User_Group extends Base_Group {

	public $key = 'user';
	public $label = 'User';

	public $user;

	public function get_user() {
		if ( $this->user === null ) {
			$this->user = \Voxel\User::get( wp_get_current_user() ) ?? \Voxel\User::dummy();
		}

		return $this->user;
	}

	public function get_post() {
		if ( $this->post === null ) {
			$user = $this->get_user();
			if ( $user->get_id() !== 0 && ( $profile = $user->get_profile() ) ) {
				$this->post = $profile;
			} else {
				$this->post = \Voxel\Post::dummy();
			}
		}

		return $this->post;
	}

	public function get_post_type() {
		if ( $this->post_type === null ) {
			$this->post_type = $this->get_post()->post_type ?? \Voxel\Post_Type::get('post');
		}

		return $this->post_type;
	}

	protected function properties(): array {
		$post_types = [
			'label' => 'Post types',
			'type' => \Voxel\T_OBJECT,
			'properties' => [],
		];

		foreach ( \Voxel\Post_Type::get_voxel_types() as $post_type ) {
			$post_types['properties'][ $post_type->get_key() ] = [
				'label' => $post_type->get_label(),
				'type' => \Voxel\T_OBJECT,
				'properties' => [
					'published' => [
						'label' => 'Published count',
						'type' => \Voxel\T_NUMBER,
						'callback' => function() use ($post_type) {
							$stats = $this->get_user()->get_post_stats();
							return $stats[ $post_type->get_key() ]['publish'] ?? 0;
						},
					],
					'pending' => [
						'label' => 'Pending count',
						'type' => \Voxel\T_NUMBER,
						'callback' => function() use ($post_type) {
							$stats = $this->get_user()->get_post_stats();
							return $stats[ $post_type->get_key() ]['pending'] ?? 0;
						},
					],
					'unpublished' => [
						'label' => 'Unpublished count',
						'type' => \Voxel\T_NUMBER,
						'callback' => function() use ($post_type) {
							$stats = $this->get_user()->get_post_stats();
							return $stats[ $post_type->get_key() ]['unpublished'] ?? 0;
						},
					],
					'expired' => [
						'label' => 'Expired count',
						'type' => \Voxel\T_NUMBER,
						'callback' => function() use ($post_type) {
							$stats = $this->get_user()->get_post_stats();
							return $stats[ $post_type->get_key() ]['expired'] ?? 0;
						},
					],
					'rejected' => [
						'label' => 'Rejected count',
						'type' => \Voxel\T_NUMBER,
						'callback' => function() use ($post_type) {
							$stats = $this->get_user()->get_post_stats();
							return $stats[ $post_type->get_key() ]['rejected'] ?? 0;
						},
					],
					'draft' => [
						'label' => 'Draft count',
						'type' => \Voxel\T_NUMBER,
						'callback' => function() use ($post_type) {
							$stats = $this->get_user()->get_post_stats();
							return $stats[ $post_type->get_key() ]['draft'] ?? 0;
						},
					],
					'archive' => [
						'label' => 'Archive link',
						'type' => \Voxel\T_URL,
						'callback' => function() use ($post_type) {
							$filters = $post_type->get_filters();
							$key = 'user';
							foreach ( $filters as $filter ) {
								if ( $filter->get_type() === 'user' ) {
									$key = $filter->get_key();
								}
							}

							return add_query_arg( $key, $this->get_user()->get_id(), $post_type->get_archive_link() );
						},
					],
				],
			];
		}

		$vendor = [
			'label' => 'Vendor stats',
			'type' => \Voxel\T_OBJECT,
			'properties' => [
				'earnings' => [
					'label' => 'Total earnings',
					'type' => \Voxel\T_NUMBER,
					'default_mods' => '.currency_format(,true)',
					'callback' => function() {
						return $this->get_user()->get_vendor_stats()->get_total_earnings();
					},
				],

				'fees' => [
					'label' => 'Total platform fees',
					'type' => \Voxel\T_NUMBER,
					'default_mods' => '.currency_format(,true)',
					'callback' => function() {
						return $this->get_user()->get_vendor_stats()->get_total_fees();
					},
				],

				'customers' => [
					'label' => 'Customer count',
					'type' => \Voxel\T_NUMBER,
					'callback' => function() {
						return $this->get_user()->get_vendor_stats()->get_total_customer_count();
					},
				],

				'orders' => [
					'label' => 'Order count',
					'type' => \Voxel\T_OBJECT,
					'properties' => [
						'completed' => [
							'label' => 'Completed',
							'type' => \Voxel\T_NUMBER,
							'callback' => function() {
								return $this->get_user()->get_vendor_stats()->get_total_order_count( \Voxel\Order::STATUS_COMPLETED );
							},
						],

						'pending_approval' => [
							'label' => 'Pending approval',
							'type' => \Voxel\T_NUMBER,
							'callback' => function() {
								return $this->get_user()->get_vendor_stats()->get_total_order_count( \Voxel\Order::STATUS_PENDING_APPROVAL );
							},
						],

						'declined' => [
							'label' => 'Declined',
							'type' => \Voxel\T_NUMBER,
							'callback' => function() {
								return $this->get_user()->get_vendor_stats()->get_total_order_count( \Voxel\Order::STATUS_DECLINED );
							},
						],

						'refund_requested' => [
							'label' => 'Refund requested',
							'type' => \Voxel\T_NUMBER,
							'callback' => function() {
								return $this->get_user()->get_vendor_stats()->get_total_order_count( \Voxel\Order::STATUS_REFUND_REQUESTED );
							},
						],

						'refunded' => [
							'label' => 'Refunded',
							'type' => \Voxel\T_NUMBER,
							'callback' => function() {
								return $this->get_user()->get_vendor_stats()->get_total_order_count( \Voxel\Order::STATUS_REFUNDED );
							},
						],
					],
				],

				'this-year' => [
					'label' => 'This year',
					'type' => \Voxel\T_OBJECT,
					'properties' => [
						'earnings' => [
							'label' => 'Earnings',
							'type' => \Voxel\T_NUMBER,
							'default_mods' => '.currency_format(,true)',
							'callback' => function() {
								return $this->get_user()->get_vendor_stats()->get_this_year_stats()['earnings'];
							},
						],

						'orders' => [
							'label' => 'Completed orders',
							'type' => \Voxel\T_NUMBER,
							'callback' => function() {
								return $this->get_user()->get_vendor_stats()->get_this_year_stats()['orders'];
							},
						],

						'fees' => [
							'label' => 'Platform fees',
							'type' => \Voxel\T_NUMBER,
							'default_mods' => '.currency_format(,true)',
							'callback' => function() {
								return $this->get_user()->get_vendor_stats()->get_this_year_stats()['fees'];
							},
						],
					],
				],

				'this-month' => [
					'label' => 'This month',
					'type' => \Voxel\T_OBJECT,
					'properties' => [
						'earnings' => [
							'label' => 'Earnings',
							'type' => \Voxel\T_NUMBER,
							'default_mods' => '.currency_format(,true)',
							'callback' => function() {
								return $this->get_user()->get_vendor_stats()->get_this_month_stats()['earnings'];
							},
						],

						'orders' => [
							'label' => 'Completed orders',
							'type' => \Voxel\T_NUMBER,
							'callback' => function() {
								return $this->get_user()->get_vendor_stats()->get_this_month_stats()['orders'];
							},
						],

						'fees' => [
							'label' => 'Platform fees',
							'type' => \Voxel\T_NUMBER,
							'default_mods' => '.currency_format(,true)',
							'callback' => function() {
								return $this->get_user()->get_vendor_stats()->get_this_month_stats()['fees'];
							},
						],
					],
				],

				'this-week' => [
					'label' => 'This week',
					'type' => \Voxel\T_OBJECT,
					'properties' => [
						'earnings' => [
							'label' => 'Earnings',
							'type' => \Voxel\T_NUMBER,
							'default_mods' => '.currency_format(,true)',
							'callback' => function() {
								return $this->get_user()->get_vendor_stats()->get_this_week_stats()['earnings'];
							},
						],

						'orders' => [
							'label' => 'Completed orders',
							'type' => \Voxel\T_NUMBER,
							'callback' => function() {
								return $this->get_user()->get_vendor_stats()->get_this_week_stats()['orders'];
							},
						],

						'fees' => [
							'label' => 'Platform fees',
							'type' => \Voxel\T_NUMBER,
							'default_mods' => '.currency_format(,true)',
							'callback' => function() {
								return $this->get_user()->get_vendor_stats()->get_this_week_stats()['fees'];
							},
						],
					],
				],

				'today' => [
					'label' => 'Today',
					'type' => \Voxel\T_OBJECT,
					'properties' => [
						'earnings' => [
							'label' => 'Earnings',
							'type' => \Voxel\T_NUMBER,
							'default_mods' => '.currency_format(,true)',
							'callback' => function() {
								return $this->get_user()->get_vendor_stats()->get_today_stats()['earnings'];
							},
						],

						'orders' => [
							'label' => 'Completed orders',
							'type' => \Voxel\T_NUMBER,
							'callback' => function() {
								return $this->get_user()->get_vendor_stats()->get_today_stats()['orders'];
							},
						],

						'fees' => [
							'label' => 'Platform fees',
							'type' => \Voxel\T_NUMBER,
							'default_mods' => '.currency_format(,true)',
							'callback' => function() {
								return $this->get_user()->get_vendor_stats()->get_today_stats()['fees'];
							},
						],
					],
				],
			],
		];

		$properties = [
			'profile' => [
				'label' => 'Profile',
				'type' => \Voxel\T_OBJECT,
				'properties' => $this->_post_properties( true ),
			],
			':id' => [
				'label' => 'ID',
				'type' => \Voxel\T_NUMBER,
				'callback' => function() {
					return $this->get_user()->get_id();
				},
			],

			':username' => [
				'label' => 'Username',
				'type' => \Voxel\T_STRING,
				'callback' => function() {
					return $this->get_user()->get_username();
				},
			],

			':email' => [
				'label' => 'Email',
				'type' => \Voxel\T_EMAIL,
				'callback' => function() {
					return $this->get_user()->get_email();
				},
			],

			':first_name' => [
				'label' => 'First Name',
				'type' => \Voxel\T_STRING,
				'callback' => function() {
					return $this->get_user()->get_first_name();
				},
			],

			':last_name' => [
				'label' => 'Last Name',
				'type' => \Voxel\T_STRING,
				'callback' => function() {
					return $this->get_user()->get_last_name();
				},
			],

			':display_name' => [
				'label' => 'Display Name',
				'type' => \Voxel\T_STRING,
				'callback' => function() {
					return $this->get_user()->get_display_name();
				},
			],

			':avatar' => [
				'label' => 'Avatar',
				'type' => \Voxel\T_NUMBER,
				'callback' => function() {
					return $this->get_user()->get_avatar_id();
				},
			],

			':profile_url' => [
				'label' => 'Profile URL',
				'type' => \Voxel\T_URL,
				'callback' => function() {
					return get_author_posts_url( $this->get_user()->get_id() );
				},
			],
			':profile_id' => [
				'label' => 'Profile ID',
				'type' => \Voxel\T_NUMBER,
				'callback' => function() {
					return $this->get_user()->get_profile_id();
				},
			],

			':plan' => [
				'label' => 'Membership plan',
				'type' => \Voxel\T_OBJECT,
				'properties' => [
					'key' => [
						'label' => 'Key',
						'type' => \Voxel\T_STRING,
						'callback' => function() {
							$membership = $this->get_user()->get_membership();
							return $membership->is_active() ? $membership->plan->get_key() : 'default';
						},
					],
					'label' => [
						'label' => 'Label',
						'type' => \Voxel\T_STRING,
						'callback' => function() {
							$membership = $this->get_user()->get_membership();
							$default_plan = \Voxel\Plan::get_or_create_default_plan();
							return $membership->is_active() ? $membership->plan->get_label() : $default_plan->get_label();
						},
					],
					'description' => [
						'label' => 'Description',
						'type' => \Voxel\T_STRING,
						'callback' => function() {
							$membership = $this->get_user()->get_membership();
							$default_plan = \Voxel\Plan::get_or_create_default_plan();
							return $membership->is_active() ? $membership->plan->get_description() : $default_plan->get_description();
						},
					],
					'pricing' => [
						'label' => 'Pricing',
						'type' => \Voxel\T_OBJECT,
						'properties' => [
							'amount' => [
								'label' => 'Amount',
								'type' => \Voxel\T_NUMBER,
								'default_mods' => '.currency_format(,true)',
								'callback' => function() {
									$membership = $this->get_user()->get_membership();
									if ( $membership->get_type() === 'subscription' || $membership->get_type() === 'payment' ) {
										return $membership->get_amount();
									} else {
										return 0;
									}
								},
							],
							'period' => [
								'label' => 'Period',
								'type' => \Voxel\T_STRING,
								'callback' => function() {
									$membership = $this->get_user()->get_membership();
									if ( $membership->get_type() === 'subscription' ) {
										return \Voxel\interval_format( $membership->get_interval(), $membership->get_interval_count() );
									} elseif ( $membership->get_type() === 'payment' ) {
										return _x( 'one time', 'price interval', 'voxel' );
									} else {
										return '';
									}
								},
							],
							'currency' => [
								'label' => 'Currency',
								'type' => \Voxel\T_STRING,
								'callback' => function() {
									$membership = $this->get_user()->get_membership();
									if ( $membership->get_type() === 'subscription' || $membership->get_type() === 'payment' ) {
										return $membership->get_currency();
									} else {
										return '';
									}
								},
							],
						],
					],
				],
			],

			'post_types' => $post_types,

			'vendor' => $vendor,

			':followers' => [
				'label' => 'Followers',
				'type' => \Voxel\T_OBJECT,
				'properties' => [
					'accepted' => [
						'label' => 'Follow count',
						'description' => 'Number of users that are following this user',
						'type' => \Voxel\T_NUMBER,
						'callback' => function() {
							$stats = $this->get_user()->get_follow_stats();
							return absint( $stats['followed'][ \Voxel\FOLLOW_ACCEPTED ] ?? 0 );
						},
					],
					'requested' => [
						'label' => 'Follow requested count',
						'description' => 'Number of users that have requested to follow this user',
						'type' => \Voxel\T_NUMBER,
						'callback' => function() {
							$stats = $this->get_user()->get_follow_stats();
							return absint( $stats['followed'][ \Voxel\FOLLOW_REQUESTED ] ?? 0 );
						},
					],
					'blocked' => [
						'label' => 'Block count',
						'description' => 'Number of users that have been blocked by this user',
						'type' => \Voxel\T_NUMBER,
						'callback' => function() {
							$stats = $this->get_user()->get_follow_stats();
							return absint( $stats['followed'][ \Voxel\FOLLOW_BLOCKED ] ?? 0 );
						},
					],
				],
			],

			':following' => [
				'label' => 'Following',
				'type' => \Voxel\T_OBJECT,
				'properties' => [
					'accepted' => [
						'label' => 'Follow count',
						'description' => 'Number of users/posts this user is following',
						'type' => \Voxel\T_NUMBER,
						'callback' => function() {
							$stats = $this->get_user()->get_follow_stats();
							return absint( $stats['following'][ \Voxel\FOLLOW_ACCEPTED ] ?? 0 );
						},
					],
					'requested' => [
						'label' => 'Follow requested count',
						'description' => 'Number of users/posts this user has requested to follow',
						'type' => \Voxel\T_NUMBER,
						'callback' => function() {
							$stats = $this->get_user()->get_follow_stats();
							return absint( $stats['following'][ \Voxel\FOLLOW_REQUESTED ] ?? 0 );
						},
					],
					'blocked' => [
						'label' => 'Block count',
						'description' => 'Number of users/posts this user has been blocked by',
						'type' => \Voxel\T_NUMBER,
						'callback' => function() {
							$stats = $this->get_user()->get_follow_stats();
							return absint( $stats['following'][ \Voxel\FOLLOW_BLOCKED ] ?? 0 );
						},
					],
				],
			],
		];

		if ( ! empty( \Voxel\get('settings.stats.enabled_post_types') ) ) {
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
									return $this->get_user()->stats->get_views('1d');
								},
							],
							'7d' => [
								'label' => 'Last 7 days',
								'type' => \Voxel\T_NUMBER,
								'callback' => function() {
									return $this->get_user()->stats->get_views('7d');
								},
							],
							'30d' => [
								'label' => 'Last 30 days',
								'type' => \Voxel\T_NUMBER,
								'callback' => function() {
									return $this->get_user()->stats->get_views('30d');
								},
							],
							'all' => [
								'label' => 'All',
								'type' => \Voxel\T_NUMBER,
								'callback' => function() {
									return $this->get_user()->stats->get_views('all');
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
									return $this->get_user()->stats->get_unique_views('1d');
								},
							],
							'7d' => [
								'label' => 'Last 7 days',
								'type' => \Voxel\T_NUMBER,
								'callback' => function() {
									return $this->get_user()->stats->get_unique_views('7d');
								},
							],
							'30d' => [
								'label' => 'Last 30 days',
								'type' => \Voxel\T_NUMBER,
								'callback' => function() {
									return $this->get_user()->stats->get_unique_views('30d');
								},
							],
							'all' => [
								'label' => 'All',
								'type' => \Voxel\T_NUMBER,
								'callback' => function() {
									return $this->get_user()->stats->get_unique_views('all');
								},
							],
						],
					],
					'countries' => [
						'label' => 'Top countries',
						'type' => \Voxel\T_OBJECT,
						'loopable' => true,
						'loopcount' => function() {
							$countries = $this->get_user()->stats->get_tracking_stats('countries');
							return count( $countries );
						},
						'properties' => [
							'name' => [
								'label' => 'Country name',
								'type' => \Voxel\T_STRING,
								'callback' => function( $index ) {
									$item = $this->get_user()->stats->get_tracking_stats('countries')[ $index ] ?? null;
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
									$item = $this->get_user()->stats->get_tracking_stats('countries')[ $index ] ?? null;
									return $item['count'] ?? 0;
								},
							],
							'code' => [
								'label' => 'Country code',
								'type' => \Voxel\T_STRING,
								'callback' => function( $index ) {
									$item = $this->get_user()->stats->get_tracking_stats('countries')[ $index ] ?? null;
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
							$domains = $this->get_user()->stats->get_tracking_stats('ref_domains');
							return count( $domains );
						},
						'properties' => [
							'name' => [
								'label' => 'Domain name',
								'type' => \Voxel\T_STRING,
								'callback' => function( $index ) {
									$item = $this->get_user()->stats->get_tracking_stats('ref_domains')[ $index ] ?? null;
									return $item['item'] ?? '';
								},
							],
							'count' => [
								'label' => 'Referral count',
								'type' => \Voxel\T_NUMBER,
								'callback' => function( $index ) {
									$item = $this->get_user()->stats->get_tracking_stats('ref_domains')[ $index ] ?? null;
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
							$ref_urls = $this->get_user()->stats->get_tracking_stats('ref_urls');
							return count( $ref_urls );
						},
						'properties' => [
							'name' => [
								'label' => 'URL',
								'type' => \Voxel\T_STRING,
								'callback' => function( $index ) {
									$item = $this->get_user()->stats->get_tracking_stats('ref_urls')[ $index ] ?? null;
									return $item['item'] ?? '';
								},
							],
							'count' => [
								'label' => 'Referral count',
								'type' => \Voxel\T_NUMBER,
								'callback' => function( $index ) {
									$item = $this->get_user()->stats->get_tracking_stats('ref_urls')[ $index ] ?? null;
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
							$browsers = $this->get_user()->stats->get_tracking_stats('browsers');
							return count( $browsers );
						},
						'properties' => [
							'name' => [
								'label' => 'Browser',
								'type' => \Voxel\T_STRING,
								'callback' => function( $index ) {
									$item = $this->get_user()->stats->get_tracking_stats('browsers')[ $index ] ?? null;
									return \Voxel\Stats\get_browser_label( $item['item'] ?? '' );
								},
							],
							'count' => [
								'label' => 'View count',
								'type' => \Voxel\T_NUMBER,
								'callback' => function( $index ) {
									$item = $this->get_user()->stats->get_tracking_stats('browsers')[ $index ] ?? null;
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
							$platforms = $this->get_user()->stats->get_tracking_stats('platforms');
							return count( $platforms );
						},
						'properties' => [
							'name' => [
								'label' => 'Platform',
								'type' => \Voxel\T_STRING,
								'callback' => function( $index ) {
									$item = $this->get_user()->stats->get_tracking_stats('platforms')[ $index ] ?? null;
									return \Voxel\Stats\get_platform_label( $item['item'] ?? '' );
								},
							],
							'count' => [
								'label' => 'View count',
								'type' => \Voxel\T_NUMBER,
								'callback' => function( $index ) {
									$item = $this->get_user()->stats->get_tracking_stats('platforms')[ $index ] ?? null;
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
							$devices = $this->get_user()->stats->get_tracking_stats('devices');
							return count( $devices );
						},
						'properties' => [
							'name' => [
								'label' => 'Device',
								'type' => \Voxel\T_STRING,
								'callback' => function( $index ) {
									$item = $this->get_user()->stats->get_tracking_stats('devices')[ $index ] ?? null;
									return \Voxel\Stats\get_device_label( $item['item'] ?? '' );
								},
							],
							'count' => [
								'label' => 'View count',
								'type' => \Voxel\T_NUMBER,
								'callback' => function( $index ) {
									$item = $this->get_user()->stats->get_tracking_stats('devices')[ $index ] ?? null;
									return $item['count'] ?? 0;
								},
							],
						],
					],
					'last_updated' => [
						'label' => 'Last updated',
						'type' => \Voxel\T_DATE,
						'callback' => function() {
							$time = $this->get_user()->stats->get_last_updated_time();
							return date( 'Y-m-d H:i:s', $time );
						},
					],
				],
			];
		}

		return $properties;
	}

	protected function methods(): array {
		return [
			'meta' => Methods\User_Meta::class,
		];
	}
}
