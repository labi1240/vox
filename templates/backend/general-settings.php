<?php
/**
 * Admin general settings.
 *
 * @since 1.0
 */

if ( ! defined('ABSPATH') ) {
	exit;
}

wp_enqueue_script('vue');
wp_enqueue_script('sortable');
wp_enqueue_script('vue-draggable');
wp_enqueue_script('vx:general-settings.js');
?>
<div class="wrap">
	<div id="vx-general-settings" data-config="<?= esc_attr( wp_json_encode( $config ) ) ?>" v-cloak>
		<form method="POST" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ) ?>" @submit="state.submit_config = JSON.stringify( config )">
			<div class="sticky-top">
				<div class="vx-head x-container">
					<h2 v-if="tab === 'membership'">Membership</h2>
					<h2 v-if="tab === 'stripe'">Stripe</h2>
					<h2 v-if="tab === 'stripe.portal'">Stripe Customer Portal</h2>
					<h2 v-if="tab === 'maps'">Map providers</h2>
					<h2 v-if="tab === 'auth.google'">Login with Google</h2>
					<h2 v-if="tab === 'recaptcha'">Recaptcha</h2>
					<h2 v-if="tab === 'timeline'">Timeline</h2>
					<h2 v-if="tab === 'notifications'">Notifications</h2>
					<h2 v-if="tab === 'dms'">Direct messages</h2>
					<h2 v-if="tab === 'stats'">Statistics</h2>
					<h2 v-if="tab === 'emails'">Emails</h2>
					<h2 v-if="tab === 'nav_menus'">Emails</h2>
					<h2 v-if="tab === 'share_menu'">Share menu</h2>
					<h2 v-if="tab === 'db'">Database</h2>
					<h2 v-if="tab === 'other'">Other</h2>

					<div class="vxh-actions">
						<input type="hidden" name="config" :value="state.submit_config">
						<input type="hidden" name="action" value="voxel_save_general_settings">
						<?php wp_nonce_field( 'voxel_save_general_settings' ) ?>
						<button type="submit" class="ts-button btn-shadow ts-save-settings">
							<i class="las la-save icon-sm"></i>
							Save changes
						</button>
					</div>
				</div>
			</div>
			<div class="ts-spacer"></div>
			<div class="x-container">
				<div class="x-row">
					<div class="x-col-3">
						<ul class="inner-tabs vertical-tabs">
							<li :class="{'current-item': tab === 'membership'}">
								<a href="#" @click.prevent="tab = 'membership'">Membership</a>
							</li>
							<li :class="{'current-item': tab === 'stripe'}">
								<a href="#" @click.prevent="tab = 'stripe'">Stripe</a>
							</li>
							<li :class="{'current-item': tab === 'stripe.portal'}">
								<a href="#" @click.prevent="tab = 'stripe.portal'">Stripe Customer Portal</a>
							</li>
							<li :class="{'current-item': tab === 'maps'}">
								<a href="#" @click.prevent="tab = 'maps'">Map providers</a>
							</li>
							<li :class="{'current-item': tab === 'auth.google'}">
								<a href="#" @click.prevent="tab = 'auth.google'">Login with Google</a>
							</li>
							<li :class="{'current-item': tab === 'recaptcha'}">
								<a href="#" @click.prevent="tab = 'recaptcha'">Recaptcha</a>
							</li>
							<li :class="{'current-item': tab === 'timeline'}">
								<a href="#" @click.prevent="tab = 'timeline'">Timeline</a>
							</li>
							<li :class="{'current-item': tab === 'notifications'}">
								<a href="#" @click.prevent="tab = 'notifications'">Notifications</a>
							</li>
							<li :class="{'current-item': tab === 'dms'}">
								<a href="#" @click.prevent="tab = 'dms'">Direct Messages</a>
							</li>
							<li :class="{'current-item': tab === 'stats'}">
								<a href="#" @click.prevent="tab = 'stats'">Statistics</a>
							</li>
							<li :class="{'current-item': tab === 'emails'}">
								<a href="#" @click.prevent="tab = 'emails'">Emails</a>
							</li>
							<li :class="{'current-item': tab === 'nav_menus'}">
								<a href="#" @click.prevent="tab = 'nav_menus'">Nav menus</a>
							</li>
							<li :class="{'current-item': tab === 'share_menu'}">
								<a href="#" @click.prevent="tab = 'share_menu'">Share menu</a>
							</li>
							<li :class="{'current-item': tab === 'db'}">
								<a href="#" @click.prevent="tab = 'db'">Database</a>
							</li>
							<li :class="{'current-item': tab === 'other'}">
								<a href="#" @click.prevent="tab = 'other'">Other</a>
							</li>
						</ul>
					</div>

					<div v-if="tab === 'recaptcha'" class="x-col-9">
						<?php require_once locate_template( 'templates/backend/general-settings/recaptcha-settings.php' ) ?>
					</div>
					<div v-else-if="tab === 'stripe'" class="x-col-9">
						<?php require_once locate_template( 'templates/backend/general-settings/stripe-settings.php' ) ?>
					</div>
					<div v-if="tab === 'stripe.portal'" class="x-col-9">
						<?php require_once locate_template( 'templates/backend/general-settings/stripe-portal-settings.php' ) ?>
					</div>
					<div v-if="tab === 'membership'" class="x-col-9">
						<?php require_once locate_template( 'templates/backend/general-settings/membership-settings.php' ) ?>
					</div>
					<div v-else-if="tab === 'auth.google'" class="x-col-9">
						<?php require_once locate_template( 'templates/backend/general-settings/google-auth-settings.php' ) ?>
					</div>
					<div v-else-if="tab === 'maps'" class="x-col-9">
						<?php require_once locate_template( 'templates/backend/general-settings/map-settings.php' ) ?>
					</div>
					<div v-else-if="tab === 'timeline'" class="x-col-9">
						<?php require_once locate_template( 'templates/backend/general-settings/timeline-settings.php' ) ?>
					</div>
					<div v-else-if="tab === 'notifications'" class="x-col-9">
						<?php require_once locate_template( 'templates/backend/general-settings/notification-settings.php' ) ?>
					</div>
					<div v-else-if="tab === 'dms'" class="x-col-9">
						<?php require_once locate_template( 'templates/backend/general-settings/dm-settings.php' ) ?>
					</div>
					<div v-else-if="tab === 'stats'" class="x-col-9">
						<?php require_once locate_template( 'templates/backend/general-settings/tracking-settings.php' ) ?>
					</div>
					<div v-else-if="tab === 'emails'" class="x-col-9">
						<?php require_once locate_template( 'templates/backend/general-settings/email-settings.php' ) ?>
					</div>
					<div v-else-if="tab === 'nav_menus'" class="x-col-9">
						<?php require_once locate_template( 'templates/backend/general-settings/nav-menu-settings.php' ) ?>
					</div>
					<div v-else-if="tab === 'share_menu'" class="x-col-9">
						<share-menu></share-menu>
					</div>
					<div v-else-if="tab === 'db'" class="x-col-9">
						<?php require_once locate_template( 'templates/backend/general-settings/db-settings.php' ) ?>
					</div>
					<div v-else-if="tab === 'other'" class="x-col-9">
						<div class="ts-group">
							<div class="ts-group-head">
								<h3>Viewport</h3>
							</div>
							<div class="x-row">
								<?php \Voxel\Form_Models\Select_Model::render( [
									'v-model' => 'config.perf.user_scalable',
									'label' => 'User scalable',
									'description' => 'Set whether whether zoom in and zoom out actions are allowed on the page',
									'classes' => 'x-col-12',
									'footnote' => 'Note: When enabled, font size in mobile should be set to at least 16px to prevent input zoom on focus',
									'choices' => [
										'yes' => 'Yes',
										'no' => 'No',
										'auto' => 'Auto',
									],
								] ) ?>
							</div>
						</div>

						<div class="ts-group">
							<div class="ts-group-head">
								<h3>Icon packs</h3>
							</div>
							<div class="x-row">
								<?php \Voxel\Form_Models\Switcher_Model::render( [
									'v-model' => 'config.icons.line_awesome.enabled',
									'label' => 'Enable "Line Awesome" icon pack',
									'classes' => 'x-col-12',
								] ) ?>
							</div>
						</div>
					</div>
					<!-- <div class="">
						<pre debug>{{ config }}</pre>
					</div> -->
				</div>
			</div>
		</form>
	</div>
</div>

<?php require_once locate_template( 'templates/backend/product-types/components/rate-list-component.php' ) ?>
<?php require_once locate_template( 'templates/backend/general-settings/share-menu-settings.php' ) ?>
