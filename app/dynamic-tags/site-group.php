<?php

namespace Voxel\Dynamic_Tags;

if ( ! defined('ABSPATH') ) {
	exit;
}

class Site_Group extends Base_Group {

	public $key = 'site';
	public $label = 'Site';

	protected function properties(): array {
		$post_types = [
			'label' => 'Post types',
			'type' => \Voxel\T_OBJECT,
			'properties' => [],
		];

		foreach ( \Voxel\Post_Type::get_voxel_types() as $post_type ) {
			$custom_templates = [];
			foreach ( $post_type->templates->get_custom_templates() as $template_group => $template_list ) {
				foreach ( $template_list as $template_details ) {
					$custom_templates[ sprintf( '%s:%s', $template_group, $template_details['label'] ) ] = [
						'label' => sprintf( '%s: %s', $template_group === 'single' ? 'Single page' : 'Preview card', $template_details['label'] ),
						'type' => \Voxel\T_NUMBER,
						'callback' => function() use ($template_details) {
							return $template_details['id'];
						},
					];
				}
			}

			$post_types['properties'][ $post_type->get_key() ] = [
				'label' => $post_type->get_label(),
				'type' => \Voxel\T_OBJECT,
				'properties' => [
					'singular' => [
						'label' => 'Singular name',
						'type' => \Voxel\T_STRING,
						'callback' => function() use ($post_type) {
							return $post_type->get_singular_name();
						},
					],

					'plural' => [
						'label' => 'Plural name',
						'type' => \Voxel\T_STRING,
						'callback' => function() use ($post_type) {
							return $post_type->get_plural_name();
						},
					],

					'icon' => [
						'label' => 'Icon',
						'type' => \Voxel\T_STRING,
						'callback' => function() use ($post_type) {
							return $post_type->get_icon();
						},
					],

					'archive' => [
						'label' => 'Archive link',
						'type' => \Voxel\T_URL,
						'callback' => function() use ($post_type) {
							return $post_type->get_archive_link();
						},
					],

					'create' => [
						'label' => 'Create post link',
						'type' => \Voxel\T_URL,
						'callback' => function() use ($post_type) {
							return $post_type->get_create_post_link();
						},
					],
					'templates' => [
						'label' => 'Templates',
						'type' => \Voxel\T_OBJECT,
						'properties' => [
							'single' => [
								'label' => 'Single page',
								'type' => \Voxel\T_NUMBER,
								'callback' => function() use ($post_type) {
									return $post_type->get_templates()['single'];
								},
							],
							'card' => [
								'label' => 'Preview card',
								'type' => \Voxel\T_NUMBER,
								'callback' => function() use ($post_type) {
									return $post_type->get_templates()['card'];
								},
							],
							'archive' => [
								'label' => 'Archive page',
								'type' => \Voxel\T_NUMBER,
								'callback' => function() use ($post_type) {
									return $post_type->get_templates()['archive'];
								},
							],
							'form' => [
								'label' => 'Submit page',
								'type' => \Voxel\T_NUMBER,
								'callback' => function() use ($post_type) {
									return $post_type->get_templates()['form'];
								},
							],
							'custom' => [
								'label' => 'Custom',
								'type' => \Voxel\T_OBJECT,
								'properties' => $custom_templates,
							],
						],
					],
				],
			];
		}

		$properties = [
			'post_types' => $post_types,

			'title' => [
				'label' => 'Title',
				'type' => \Voxel\T_STRING,
				'callback' => function() {
					return get_bloginfo('name');
				},
			],

			'logo' => [
				'label' => 'Logo',
				'type' => \Voxel\T_NUMBER,
				'callback' => function() {
					return get_theme_mod( 'custom_logo' );
				},
			],

			'tagline' => [
				'label' => 'Tagline',
				'type' => \Voxel\T_STRING,
				'callback' => function() {
					return get_bloginfo('description');
				},
			],

			'url' => [
				'label' => 'URL',
				'type' => \Voxel\T_URL,
				'callback' => function() {
					return get_bloginfo('url');
				},
			],

			'admin_url' => [
				'label' => 'WP Admin URL',
				'type' => \Voxel\T_URL,
				'callback' => function() {
					return admin_url();
				},
			],

			'login_url' => [
				'label' => 'Login URL',
				'type' => \Voxel\T_URL,
				'callback' => function() {
					return \Voxel\get_auth_url();
				},
			],

			'register_url' => [
				'label' => 'Register URL',
				'type' => \Voxel\T_URL,
				'callback' => function() {
					return add_query_arg( 'register', '', \Voxel\get_auth_url() );
				},
			],

			'logout_url' => [
				'label' => 'Logout URL',
				'type' => \Voxel\T_URL,
				'callback' => function() {
					return \Voxel\get_logout_url();
				},
			],

			'current_plan_url' => [
				'label' => 'Current plan URL',
				'type' => \Voxel\T_URL,
				'callback' => function() {
					return get_permalink( \Voxel\get( 'templates.current_plan' ) ) ?: home_url('/');
				},
			],

			'language' => [
				'label' => 'Language',
				'type' => \Voxel\T_STRING,
				'callback' => function() {
					return get_bloginfo('language');
				},
			],

			'date' => [
				'label' => 'Date',
				'type' => \Voxel\T_DATE,
				'callback' => function() {
					return current_time('Y-m-d H:i:s');
				},
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
									return \Voxel\Stats\get_sitewide_views('1d');
								},
							],
							'7d' => [
								'label' => 'Last 7 days',
								'type' => \Voxel\T_NUMBER,
								'callback' => function() {
									return \Voxel\Stats\get_sitewide_views('7d');
								},
							],
							'30d' => [
								'label' => 'Last 30 days',
								'type' => \Voxel\T_NUMBER,
								'callback' => function() {
									return \Voxel\Stats\get_sitewide_views('30d');
								},
							],
							'all' => [
								'label' => 'All',
								'type' => \Voxel\T_NUMBER,
								'callback' => function() {
									return \Voxel\Stats\get_sitewide_views('all');
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
									return \Voxel\Stats\get_sitewide_unique_views('1d');
								},
							],
							'7d' => [
								'label' => 'Last 7 days',
								'type' => \Voxel\T_NUMBER,
								'callback' => function() {
									return \Voxel\Stats\get_sitewide_unique_views('7d');
								},
							],
							'30d' => [
								'label' => 'Last 30 days',
								'type' => \Voxel\T_NUMBER,
								'callback' => function() {
									return \Voxel\Stats\get_sitewide_unique_views('30d');
								},
							],
							'all' => [
								'label' => 'All',
								'type' => \Voxel\T_NUMBER,
								'callback' => function() {
									return \Voxel\Stats\get_sitewide_unique_views('all');
								},
							],
						],
					],
					'countries' => [
						'label' => 'Top countries',
						'type' => \Voxel\T_OBJECT,
						'loopable' => true,
						'loopcount' => function() {
							$countries = \Voxel\Stats\get_sitewide_tracking_stats('countries');
							return count( $countries );
						},
						'properties' => [
							'name' => [
								'label' => 'Country name',
								'type' => \Voxel\T_STRING,
								'callback' => function( $index ) {
									$item = \Voxel\Stats\get_sitewide_tracking_stats('countries')[ $index ] ?? null;
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
									$item = \Voxel\Stats\get_sitewide_tracking_stats('countries')[ $index ] ?? null;
									return $item['count'] ?? 0;
								},
							],
							'code' => [
								'label' => 'Country code',
								'type' => \Voxel\T_STRING,
								'callback' => function( $index ) {
									$item = \Voxel\Stats\get_sitewide_tracking_stats('countries')[ $index ] ?? null;
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
							$domains = \Voxel\Stats\get_sitewide_tracking_stats('ref_domains');
							return count( $domains );
						},
						'properties' => [
							'name' => [
								'label' => 'Domain name',
								'type' => \Voxel\T_STRING,
								'callback' => function( $index ) {
									$item = \Voxel\Stats\get_sitewide_tracking_stats('ref_domains')[ $index ] ?? null;
									return $item['item'] ?? '';
								},
							],
							'count' => [
								'label' => 'Referral count',
								'type' => \Voxel\T_NUMBER,
								'callback' => function( $index ) {
									$item = \Voxel\Stats\get_sitewide_tracking_stats('ref_domains')[ $index ] ?? null;
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
							$ref_urls = \Voxel\Stats\get_sitewide_tracking_stats('ref_urls');
							return count( $ref_urls );
						},
						'properties' => [
							'name' => [
								'label' => 'URL',
								'type' => \Voxel\T_STRING,
								'callback' => function( $index ) {
									$item = \Voxel\Stats\get_sitewide_tracking_stats('ref_urls')[ $index ] ?? null;
									return $item['item'] ?? '';
								},
							],
							'count' => [
								'label' => 'Referral count',
								'type' => \Voxel\T_NUMBER,
								'callback' => function( $index ) {
									$item = \Voxel\Stats\get_sitewide_tracking_stats('ref_urls')[ $index ] ?? null;
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
							$browsers = \Voxel\Stats\get_sitewide_tracking_stats('browsers');
							return count( $browsers );
						},
						'properties' => [
							'name' => [
								'label' => 'Browser',
								'type' => \Voxel\T_STRING,
								'callback' => function( $index ) {
									$item = \Voxel\Stats\get_sitewide_tracking_stats('browsers')[ $index ] ?? null;
									return \Voxel\Stats\get_browser_label( $item['item'] ?? '' );
								},
							],
							'count' => [
								'label' => 'View count',
								'type' => \Voxel\T_NUMBER,
								'callback' => function( $index ) {
									$item = \Voxel\Stats\get_sitewide_tracking_stats('browsers')[ $index ] ?? null;
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
							$platforms = \Voxel\Stats\get_sitewide_tracking_stats('platforms');
							return count( $platforms );
						},
						'properties' => [
							'name' => [
								'label' => 'Platform',
								'type' => \Voxel\T_STRING,
								'callback' => function( $index ) {
									$item = \Voxel\Stats\get_sitewide_tracking_stats('platforms')[ $index ] ?? null;
									return \Voxel\Stats\get_platform_label( $item['item'] ?? '' );
								},
							],
							'count' => [
								'label' => 'View count',
								'type' => \Voxel\T_NUMBER,
								'callback' => function( $index ) {
									$item = \Voxel\Stats\get_sitewide_tracking_stats('platforms')[ $index ] ?? null;
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
							$devices = \Voxel\Stats\get_sitewide_tracking_stats('devices');
							return count( $devices );
						},
						'properties' => [
							'name' => [
								'label' => 'Device',
								'type' => \Voxel\T_STRING,
								'callback' => function( $index ) {
									$item = \Voxel\Stats\get_sitewide_tracking_stats('devices')[ $index ] ?? null;
									return \Voxel\Stats\get_device_label( $item['item'] ?? '' );
								},
							],
							'count' => [
								'label' => 'View count',
								'type' => \Voxel\T_NUMBER,
								'callback' => function( $index ) {
									$item = \Voxel\Stats\get_sitewide_tracking_stats('devices')[ $index ] ?? null;
									return $item['count'] ?? 0;
								},
							],
						],
					],
					'last_updated' => [
						'label' => 'Last updated',
						'type' => \Voxel\T_DATE,
						'callback' => function() {
							$time = \Voxel\Stats\get_sitewide_last_updated_time();
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
			'option' => Methods\Site_Option::class,
			'query_var' => Methods\Site_Query_Var::class,
		];
	}
}
