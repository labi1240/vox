<?php

namespace Voxel\Controllers;

if ( ! defined('ABSPATH') ) {
	exit;
}

class Settings_Controller extends Base_Controller {

	protected function hooks() {
		$this->on( 'admin_menu', '@add_menu_page' );
		$this->on( 'admin_menu', '@set_menu_icons', 1000 );
		$this->on( 'admin_menu', '@reorder_menu_items', 1000 );
		$this->on( 'admin_post_voxel_save_general_settings', '@save_settings' );
		$this->on( 'admin_head', '@enqueue_custom_font' );

		$this->load_theme_textdomain();
	}

	protected function add_menu_page() {
		add_menu_page(
			__( 'Voxel settings', 'voxel-backend' ),
			__( 'Voxel', 'voxel-backend' ),
			'manage_options',
			'voxel-settings',
			function() {
				$config = array_replace_recursive( [
					'recaptcha' => [
						'enabled' => false,
						'key' => null,
						'secret' => null,
					],
					'stripe' => [
						'test_mode' => true,
						'key' => null,
						'secret' => null,
						'test_key' => null,
						'test_secret' => null,

						'portal' => [
							'invoice_history' => true,
							'customer_update' => [
								'enabled' => true,
								'allowed_updates' => [ 'email', 'address', 'phone' ],
							],
							'live_config_id' => null,
							'test_config_id' => null,
						],

						'currency' => 'USD',

						'webhooks' => [
							'live' => [
								'id' => null,
								'secret' => null,
							],
							'live_connect' => [
								'id' => null,
								'secret' => null,
							],
							'test' => [
								'id' => null,
								'secret' => null,
							],
							'test_connect' => [
								'id' => null,
								'secret' => null,
							],
							'local' => [
								'enabled' => false,
								'secret' => null,
							],
						],
					],
					'membership' => [
						'require_verification' => true,
						'trial' => [
							'enabled' => false,
							'period_days' => 0,
						],
						'update' => [
							'proration_behavior' => 'always_invoice', // create_prorations|none|always_invoice
						],
						'cancel' => [
							'behavior' => 'at_period_end', // at_period_end|immediately
						],
						'checkout' => [
							'tax' => [
								'mode' => 'none',
								'manual' => [
									'tax_rates' => [],
									'test_tax_rates' => [],
								],
								'tax_id_collection' => false,
							],
							'promotion_codes' => [
								'enabled' => false,
							],
						],
					],
					'auth' => [
						'google' => [
							'enabled' => false,
							'client_id' => null,
							'client_secret' => null,
						],
					],
					'maps' => [
						'provider' => 'google_maps',
						'default_location' => [
							'lat' => null,
							'lng' => null,
							'zoom' => null,
						],
						'google_maps' => [
							'api_key' => null,
							'skin' => null,
							'language' => '',
							'region' => '',
							'autocomplete' => [
								'feature_types' => '',
								'feature_types_in_submission' => '',
								'countries' => [],
							],
							'map_type_id' => 'roadmap',
							'map_type_control' => false,
							'street_view_control' => false,
						],
						'mapbox' => [
							'api_key' => null,
							'skin' => null,
							'language' => '',
							'autocomplete' => [
								'feature_types' => [],
								'feature_types_in_submission' => [],
								'countries' => [],
							],
						],
					],
					'timeline' => [
						'posts' => [
							'editable' => true,
							'maxlength' => 5000,
							'images' => [
								'enabled' => true,
								'max_count' => 3,
								'max_size' => 2000,
							],
							'rate_limit' => [
								'time_between' => 20,
								'hourly_limit' => 20,
								'daily_limit' => 100,
							],
						],
						'replies' => [
							'max_nest_level' => null,
							'editable' => true,
							'maxlength' => 2000,
							'rate_limit' => [
								'time_between' => 5,
								'hourly_limit' => 100,
								'daily_limit' => 1000,
							],
						],
					],
					'db' => [
						'type' => 'mysql', // mysql|mariadb
						'max_revisions' => 5,
						'keyword_search' => [
							'min_word_length' => 3,
							'stopwords' => null,
						],
					],
					'notifications' => [
						'admin_user' => null,
						'inapp_persist_days' => 30, // how many days to keep inapp notifications for
					],
					'messages' => [
						'persist_days' => 365, // how many days to keep messages in the db
						'maxlength' => 2000,
						'files' => [
							'enabled' => true,
							'max_count' => 1,
							'max_size' => 1000,
							'allowed_file_types' => [
								'image/jpeg',
								'image/png',
								'image/webp',
							],
						],
						'enable_seen' => true,
						'enable_real_time' => true,
					],
					'emails' => [
						'from_name' => null,
						'from_email' => null,
						'footer_text' => null,
					],
					'nav_menus' => [
						'custom_locations' => [],
					],
					'icons' => [
						'line_awesome' => [
							'enabled' => true,
						],
					],
					'share' => [
						'networks' => [],
					],
					'stats' => [
						'enabled_post_types' => [],
						'db_ttl' => 90, // number of days to persist visits in database for
						'cache_ttl' => [
							'value' => 24,
							'unit' => 'hours',
						],
					],
					'ipgeo' => [
						'providers' => [],
					],
					'perf' => [
						'user_scalable' => 'no',
					],
				], \Voxel\get( 'settings', [] ) );

				if ( empty( $config['share']['networks'] ) ) {
					$config['share']['networks'] = \Voxel\Utils\Sharer::get_default_config();
				}

				$config['tab'] = $_GET['tab'] ?? 'membership';
				$config['editor'] = [
					'share' => [
						'presets' => \Voxel\Utils\Sharer::get_links(),
					],
					'ipgeo' => [
						'providers' => \Voxel\get_ipgeo_providers(),
					],
				];

				require locate_template( 'templates/backend/general-settings.php' );
			},
			\Voxel\get_image('post-types/logo.svg'),
			'0.207'
		);
	}

	protected function set_menu_icons() {
		global $menu;

		foreach ( $menu as $index => $item ) {
			if ( str_starts_with( $item[2], 'edit.php' ) ) {
				if ( $item[2] === 'edit.php' ) {
					$post_type = \Voxel\Post_Type::get('post');
				} else {
					$post_type = \Voxel\Post_Type::get( substr( $item[2], 19 ) );
				}

				if ( ! $post_type && $post_type->is_managed_by_voxel() ) {
					continue;
				}

				$icon = \Voxel\parse_icon_string( $post_type->get_icon() );
				if ( $icon['library'] !== 'svg' ) {
					continue;
				}

				$icon_path = get_attached_file( $icon['value']['id'] ?? null );
				if ( ! empty( $icon_path ) ) {
					$menu[ $index ][6] = sprintf(
						'data:image/svg+xml;base64,%s',
						base64_encode( \Voxel\paint_svg( file_get_contents( $icon_path ), '#a7aaad' ) )
					);

					$menu[ $index ][4] = str_replace( ' menu-icon-', ' _menu-icon-', $menu[ $index ][4] );
				}
			}
		}
	}

	protected function reorder_menu_items() {
		global $submenu;

		if ( isset( $submenu['voxel-settings'] ) ) {
			$submenu['voxel-settings'][0][0] = 'Settings';
		}

		if ( isset( $submenu['voxel-membership'] ) ) {
			$submenu['voxel-membership'][0][0] = 'Plans';
		}

		if ( isset( $submenu['voxel-post-types'] ) ) {
			$submenu['voxel-post-types'][0][0] = 'Post Types';
		}

		if ( isset( $submenu['voxel-templates'] ) ) {
			$submenu['voxel-templates'][0][0] = 'General';

			foreach ( $submenu['voxel-templates'] as $i => $item ) {
				if ( str_starts_with( $item[2], 'vx-templates-post-type-' ) ) {
					$post_type_key = substr( $item[2], 23 );
					$submenu['voxel-templates'][$i][2] = ( $post_type_key === 'post' )
						? 'edit.php?page=edit-post-type-post&tab=templates.base-templates'
						: sprintf(
						'edit.php?post_type=%s&page=edit-post-type-%s&tab=templates.base-templates',
						$post_type_key,
						$post_type_key
					);
				}
			}
		}
	}

	protected function save_settings() {
		check_admin_referer( 'voxel_save_general_settings' );
		if ( ! current_user_can( 'manage_options' ) ) {
			die;
		}

		if ( empty( $_POST['config'] ) ) {
			die;
		}

		$config = json_decode( stripslashes( $_POST['config'] ), true );
		$original_values = \Voxel\get( 'settings', [] );

		$recaptcha = $config['recaptcha'] ?? [];
		$stripe = $config['stripe'] ?? [];
		$portal = $stripe['portal'] ?? [];
		$auth = $config['auth'] ?? [];
		$google = $auth['google'] ?? [];
		$membership = $config['membership'] ?? [];
		$maps = $config['maps'] ?? [];
		$timeline = $config['timeline'] ?? [];
		$db = $config['db'] ?? [];
		$notifications = $config['notifications'] ?? [];
		$messages = $config['messages'] ?? [];
		$emails = $config['emails'] ?? [];
		$nav_menus = $config['nav_menus'] ?? [];
		$icons = $config['icons'] ?? [];
		$share = $config['share'] ?? [];
		$stats = $config['stats'] ?? [];

		// sort allowed_updates so checking for changed settings works properly
		$allowed_customer_updates = (array) ( $portal['customer_update']['allowed_updates'] ?? [] );
		sort( $allowed_customer_updates );

		\Voxel\set( 'settings', [
			'recaptcha' => [
				'enabled' => !! $recaptcha['enabled'],
				'key' => sanitize_text_field( $recaptcha['key'] ?? null ),
				'secret' => sanitize_text_field( $recaptcha['secret'] ?? null ),
			],
			'stripe' => [
				'test_mode' => !! $stripe['test_mode'],
				'key' => sanitize_text_field( $stripe['key'] ?? null ),
				'secret' => sanitize_text_field( $stripe['secret'] ?? null ),
				'test_key' => sanitize_text_field( $stripe['test_key'] ?? null ),
				'test_secret' => sanitize_text_field( $stripe['test_secret'] ?? null ),

				'portal' => [
					'invoice_history' => $portal['invoice_history'] ?? true,
					'customer_update' => [
						'enabled' => $portal['customer_update']['enabled'] ?? true,
						'allowed_updates' => $allowed_customer_updates,
					],
					'live_config_id' => $portal['live_config_id'] ?? null,
					'test_config_id' => $portal['test_config_id'] ?? null,
				],

				'currency' => sanitize_text_field( $stripe['currency'] ?? 'USD' ),

				'webhooks' => [
					'live' => [
						'id' => sanitize_text_field( $stripe['webhooks']['live']['id'] ?? null ),
						'secret' => sanitize_text_field( $stripe['webhooks']['live']['secret'] ?? null ),
					],
					'live_connect' => [
						'id' => sanitize_text_field( $stripe['webhooks']['live_connect']['id'] ?? null ),
						'secret' => sanitize_text_field( $stripe['webhooks']['live_connect']['secret'] ?? null ),
					],
					'test' => [
						'id' => sanitize_text_field( $stripe['webhooks']['test']['id'] ?? null ),
						'secret' => sanitize_text_field( $stripe['webhooks']['test']['secret'] ?? null ),
					],
					'test_connect' => [
						'id' => sanitize_text_field( $stripe['webhooks']['test_connect']['id'] ?? null ),
						'secret' => sanitize_text_field( $stripe['webhooks']['test_connect']['secret'] ?? null ),
					],
					'local' => [
						'enabled' => !! ( $stripe['webhooks']['local']['enabled'] ?? false ),
						'secret' => sanitize_text_field( $stripe['webhooks']['local']['secret'] ?? null ),
					],
				],
			],

			'membership' => [
				'require_verification' => $membership['require_verification'] ?? true,
				'trial' => [
					'enabled' => $membership['trial']['enabled'] ?? false,
					'period_days' => $membership['trial']['period_days'] ?? 0,
				],
				'update' => [
					'proration_behavior' => $membership['update']['proration_behavior'] ?? 'always_invoice',
				],
				'cancel' => [
					'behavior' => $membership['cancel']['behavior'] ?? 'at_period_end',
				],
				'checkout' => [
					'tax' => [
						'mode' => $membership['checkout']['tax']['mode'] ?? 'none',
						'manual' => [
							'tax_rates' => $membership['checkout']['tax']['manual']['tax_rates'] ?? [],
							'test_tax_rates' => $membership['checkout']['tax']['manual']['test_tax_rates'] ?? [],
						],
						'tax_id_collection' => $membership['checkout']['tax']['tax_id_collection'] ?? false,
					],
					'promotion_codes' => [
						'enabled' => $membership['checkout']['promotion_codes']['enabled'] ?? false,
					],
				],
			],

			'auth' => [
				'google' => [
					'enabled' => !! $google['enabled'],
					'client_id' => sanitize_text_field( $google['client_id'] ?? null ),
					'client_secret' => sanitize_text_field( $google['client_secret'] ?? null ),
				],
			],

			'maps' => [
				'provider' => $maps['provider'] ?? null,
				'default_location' => [
					'lat' => $maps['default_location']['lat'] ?? null,
					'lng' => $maps['default_location']['lng'] ?? null,
					'zoom' => $maps['default_location']['zoom'] ?? null,
				],
				'google_maps' => [
					'api_key' => $maps['google_maps']['api_key'] ?? null,
					'skin' => ( $maps['google_maps']['skin'] ?? null ) ? wp_json_encode( json_decode( $maps['google_maps']['skin'] ) ) : null,
					'language' => $maps['google_maps']['language'] ?? null,
					'region' => $maps['google_maps']['region'] ?? null,
					'autocomplete' => [
						'feature_types' => $maps['google_maps']['autocomplete']['feature_types'] ?? null,
						'feature_types_in_submission' => $maps['google_maps']['autocomplete']['feature_types_in_submission'] ?? null,
						'countries' => (array) ( $maps['google_maps']['autocomplete']['countries'] ?? [] ),
					],
					'map_type_id' => $maps['google_maps']['map_type_id'] ?? 'roadmap',
					'map_type_control' => $maps['google_maps']['map_type_control'] ?? false,
					'street_view_control' => $maps['google_maps']['street_view_control'] ?? false,
				],
				'mapbox' => [
					'api_key' => $maps['mapbox']['api_key'] ?? null,
					'skin' => $maps['mapbox']['skin'] ?? null,
					'language' => $maps['mapbox']['language'] ?? null,
					'autocomplete' => [
						'feature_types' => (array) ( $maps['mapbox']['autocomplete']['feature_types'] ?? [] ),
						'feature_types_in_submission' => (array) ( $maps['mapbox']['autocomplete']['feature_types_in_submission'] ?? [] ),
						'countries' => (array) ( $maps['mapbox']['autocomplete']['countries'] ?? [] ),
					],
				],
			],

			'timeline' => [
				'posts' => [
					'editable' => $timeline['posts']['editable'] ?? true,
					'maxlength' => $timeline['posts']['maxlength'] ?? 5000,
					'images' => [
						'enabled' => $timeline['posts']['images']['enabled'] ?? true,
						'max_count' => $timeline['posts']['images']['max_count'] ?? 3,
						'max_size' => $timeline['posts']['images']['max_size'] ?? 2000,
					],
					'rate_limit' => [
						'time_between' => $timeline['posts']['rate_limit']['time_between'] ?? 20,
						'hourly_limit' => $timeline['posts']['rate_limit']['hourly_limit'] ?? 20,
						'daily_limit' => $timeline['posts']['rate_limit']['daily_limit'] ?? 100,
					],
				],
				'replies' => [
					'editable' => $timeline['replies']['editable'] ?? true,
					'max_nest_level' => $timeline['replies']['max_nest_level'] ?? null,
					'maxlength' => $timeline['replies']['maxlength'] ?? 2000,
					'rate_limit' => [
						'time_between' => $timeline['replies']['rate_limit']['time_between'] ?? 5,
						'hourly_limit' => $timeline['replies']['rate_limit']['hourly_limit'] ?? 100,
						'daily_limit' => $timeline['replies']['rate_limit']['daily_limit'] ?? 1000,
					],
				],
			],
			'db' => [
				'type' => \Voxel\from_list( $db['type'] ?? null, [ 'mysql', 'mariadb' ], 'mysql' ),
				'max_revisions' => $db['max_revisions'] ?? 5,
				'keyword_search' => [
					'min_word_length' => $db['keyword_search']['min_word_length'] ?? 3,
					'stopwords' => $db['keyword_search']['stopwords'] ?? null,
				],
			],
			'notifications' => [
				'admin_user' => $notifications['admin_user'] ?? null,
				'inapp_persist_days' => absint( $notifications['inapp_persist_days'] ?? 30 ),
			],
			'messages' => [
				'persist_days' => absint( $messages['persist_days'] ?? 365 ),
				'maxlength' => $messages['maxlength'] ?? 2000,
				'files' => [
					'enabled' => $messages['files']['enabled'] ?? true,
					'max_count' => $messages['files']['max_count'] ?? 1,
					'max_size' => $messages['files']['max_size'] ?? 1000,
					'allowed_file_types' => $messages['files']['allowed_file_types'] ?? [
						'image/jpeg',
						'image/png',
						'image/webp',
					],
				],
				'enable_seen' => $messages['enable_seen'] ?? true,
				'enable_real_time' => $messages['enable_real_time'] ?? true,
			],
			'emails' => [
				'from_name' => $emails['from_name'] ?? null,
				'from_email' => $emails['from_email'] ?? null,
				'footer_text' => $emails['footer_text'] ?? null,
			],
			'nav_menus' => [
				'custom_locations' => array_filter( array_map( function( $location ) {
					$key = sanitize_key( $location['key'] ?? null );
					$label = sanitize_text_field( $location['label'] ?? null );
					if ( empty( $key ) || empty( $label ) ) {
						return null;
					}

					return compact( 'key', 'label' );
				}, (array) $nav_menus['custom_locations'] ?? [] ) ),
			],
			'icons' => [
				'line_awesome' => [
					'enabled' => $icons['line_awesome']['enabled'] ?? true,
				],
			],
			'share' => [
				'networks' => (array) $share['networks'] ?? [],
			],
			'stats' => [
				'enabled_post_types' => array_values( array_filter( (array) ( $stats['enabled_post_types'] ?? [] ), function( $post_type_key ) {
					$post_type = \Voxel\Post_Type::get( $post_type_key );
					return $post_type && $post_type->is_managed_by_voxel();
				} ) ),
				'db_ttl' => $stats['db_ttl'] ?? 90, // number of days to persist visits in database for
				'cache_ttl' => [
					'value' => $stats['cache_ttl']['value'] ?? 24,
					'unit' => $stats['cache_ttl']['unit'] ?? 'hours',
				],
			],
			'ipgeo' => [
				'providers' => (array) ( $config['ipgeo']['providers'] ?? [
					[ 'key' => 'geojs.io' ],
					[ 'key' => 'ipapi.co' ],
					[ 'key' => 'ip-api.io' ],
				] ),
			],
			'perf' => [
				'user_scalable' => $config['perf']['user_scalable'] ?? 'no',
			],
		] );

		// if customer portal settings have changed, update configuration (or create new if it doesn't exist)
		if ( \Voxel\get( 'settings.stripe.secret' ) ) {
			if ( empty( \Voxel\get( 'settings.stripe.portal.live_config_id' ) ) ) {
				$this->create_live_customer_portal();
			} elseif ( ( $original_values['stripe']['portal'] ?? [] ) !== \Voxel\get( 'settings.stripe.portal', [] ) ) {
				$this->update_live_customer_portal();
			}
		}

		if ( \Voxel\get( 'settings.stripe.test_secret' ) ) {
			if ( empty( \Voxel\get( 'settings.stripe.portal.test_config_id' ) ) ) {
				$this->create_test_customer_portal();
			} elseif ( ( $original_values['stripe']['portal'] ?? [] ) !== \Voxel\get( 'settings.stripe.portal', [] ) ) {
				$this->update_test_customer_portal();
			}
		}

		if ( ! empty( \Voxel\get( 'settings.stripe.secret' ) ) && empty( \Voxel\get( 'settings.stripe.webhooks.live.id' ) ) ) {
			$this->create_live_webhook_endpoint();
		}

		if ( ! empty( \Voxel\get( 'settings.stripe.secret' ) ) && empty( \Voxel\get( 'settings.stripe.webhooks.live_connect.id' ) ) ) {
			$this->create_live_connect_webhook_endpoint();
		}

		if ( ! empty( \Voxel\get( 'settings.stripe.test_secret' ) ) && empty( \Voxel\get( 'settings.stripe.webhooks.test.id' ) ) ) {
			$this->create_test_webhook_endpoint();
		}

		if ( ! empty( \Voxel\get( 'settings.stripe.test_secret' ) ) && empty( \Voxel\get( 'settings.stripe.webhooks.test_connect.id' ) ) ) {
			$this->create_test_connect_webhook_endpoint();
		}


		wp_safe_redirect( add_query_arg( 'tab', $config['tab'] ?? null, admin_url( 'admin.php?page=voxel-settings' ) ) );
		die;
	}

	protected function create_live_webhook_endpoint() {
		try {
			$stripe = \Voxel\Stripe::getLiveClient();
			$endpoint = $stripe->webhookEndpoints->create( [
				'url' => home_url( '/?vx=1&action=stripe.webhooks' ),
				'enabled_events' => \Voxel\Stripe::WEBHOOK_EVENTS,
			] );

			\Voxel\set( 'settings.stripe.webhooks.live', [
				'id' => $endpoint->id,
				'secret' => $endpoint->secret,
			] );
		} catch ( \Exception $e ) {
			\Voxel\log( $e );
		}
	}

	protected function create_test_webhook_endpoint() {
		try {
			$stripe = \Voxel\Stripe::getTestClient();
			$endpoint = $stripe->webhookEndpoints->create( [
				'url' => home_url( '/?vx=1&action=stripe.webhooks' ),
				'enabled_events' => \Voxel\Stripe::WEBHOOK_EVENTS,
			] );

			\Voxel\set( 'settings.stripe.webhooks.test', [
				'id' => $endpoint->id,
				'secret' => $endpoint->secret,
			] );
		} catch ( \Exception $e ) {
			\Voxel\log( $e );
		}
	}

	protected function create_live_connect_webhook_endpoint() {
		try {
			$stripe = \Voxel\Stripe::getLiveClient();
			$endpoint = $stripe->webhookEndpoints->create( [
				'url' => home_url( '/?vx=1&action=stripe.connect_webhooks' ),
				'connect' => true,
				'enabled_events' => \Voxel\Stripe::CONNECT_WEBHOOK_EVENTS,
			] );

			\Voxel\set( 'settings.stripe.webhooks.live_connect', [
				'id' => $endpoint->id,
				'secret' => $endpoint->secret,
			] );
		} catch ( \Exception $e ) {
			\Voxel\log( $e );
		}
	}

	protected function create_test_connect_webhook_endpoint() {
		try {
			$stripe = \Voxel\Stripe::getTestClient();
			$endpoint = $stripe->webhookEndpoints->create( [
				'url' => home_url( '/?vx=1&action=stripe.connect_webhooks' ),
				'connect' => true,
				'enabled_events' => \Voxel\Stripe::CONNECT_WEBHOOK_EVENTS,
			] );

			\Voxel\set( 'settings.stripe.webhooks.test_connect', [
				'id' => $endpoint->id,
				'secret' => $endpoint->secret,
			] );
		} catch ( \Exception $e ) {
			\Voxel\log( $e );
		}
	}

	protected function create_live_customer_portal() {
		try {
			$stripe = \Voxel\Stripe::getLiveClient();
			$configuration = $stripe->billingPortal->configurations->create( $this->_get_portal_config() );
			\Voxel\set( 'settings.stripe.portal.live_config_id', $configuration->id );
		} catch ( \Exception $e ) {
			\Voxel\log( $e );
		}
	}

	protected function update_live_customer_portal() {
		try {
			$stripe = \Voxel\Stripe::getLiveClient();
			$configuration_id = \Voxel\get( 'settings.stripe.portal.live_config_id' );
			$stripe->billingPortal->configurations->update( $configuration_id, $this->_get_portal_config() );
		} catch ( \Exception $e ) {
			\Voxel\log( $e );
		}
	}

	protected function create_test_customer_portal() {
		try {
			$stripe = \Voxel\Stripe::getTestClient();
			$configuration = $stripe->billingPortal->configurations->create( $this->_get_portal_config() );
			\Voxel\set( 'settings.stripe.portal.test_config_id', $configuration->id );
		} catch ( \Exception $e ) {
			\Voxel\log( $e );
		}
	}

	protected function update_test_customer_portal() {
		try {
			$stripe = \Voxel\Stripe::getTestClient();
			$configuration_id = \Voxel\get( 'settings.stripe.portal.test_config_id' );
			$stripe->billingPortal->configurations->update( $configuration_id, $this->_get_portal_config() );
		} catch ( \Exception $e ) {
			\Voxel\log( $e );
		}
	}

	protected function _get_portal_config() {
		$portal = \Voxel\get( 'settings.stripe.portal', [] );
		return [
			'business_profile' => [
				'headline' => get_bloginfo( 'name' ),
				'privacy_policy_url' => get_permalink( \Voxel\get( 'templates.privacy_policy' ) ) ?: home_url('/'),
				'terms_of_service_url' => get_permalink( \Voxel\get( 'templates.terms' ) ) ?: home_url('/'),
			],
			'features' => [
				'payment_method_update' => [ 'enabled' => true ],
				'customer_update' => [
					'allowed_updates' => $portal['customer_update']['allowed_updates'] ?? [ 'email', 'address', 'phone' ],
					'enabled' => $portal['customer_update']['enabled'] ?? true,
				],
				'invoice_history' => [ 'enabled' => $portal['invoice_history'] ?? true ],
			],
		];
	}

	protected function enqueue_custom_font() {
		echo '<link href="https://fonts.googleapis.com/css2?family=Almarai&display=swap" rel="stylesheet">';
	}

	protected function load_theme_textdomain(): void {
		load_theme_textdomain( 'voxel', trailingslashit( get_template_directory() ).'languages' );
		if ( is_admin() ) {
			load_theme_textdomain( 'voxel-backend', trailingslashit( get_template_directory() ).'languages' );
			load_theme_textdomain( 'voxel-elementor', trailingslashit( get_template_directory() ).'languages' );
		}
	}
}
