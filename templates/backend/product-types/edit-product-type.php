<?php
/**
 * Edit product type fields in WP Admin.
 *
 * @since 1.0
 */
if ( ! defined('ABSPATH') ) {
	exit;
}

require_once locate_template('templates/backend/product-types/components/additions.php');
require_once locate_template('templates/backend/product-types/components/information-fields.php');
require_once locate_template('templates/backend/product-types/components/order-tags.php');
require_once locate_template('templates/backend/post-types/components/select-field-choices.php');
?>


<div id="voxel-edit-product-type" v-cloak>
<form method="POST" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ) ?>" @submit="prepareSubmission">
	<div class="sticky-top">
		<div class="vx-head x-container">
			<h2><?= $product_type->get_label() ?></h2>

			<div>
				<input type="hidden" name="product_type_config" :value="submit_config">
				<input type="hidden" name="action" value="voxel_save_product_type_settings">
				<?php wp_nonce_field( 'voxel_save_product_type_settings' ) ?>
				<button type="submit" name="remove_product_type" value="yes" class="ts-button ts-transparent"
					onclick="return confirm('Are you sure?')">
					Delete
				</button>
				&nbsp;&nbsp;
				<button type="submit" class="ts-button ts-save-settings btn-shadow">
					<i class="las la-save icon-sm"></i>
					Save changes
				</button>
			</div>
		</div>
	</div>


	<div class="x-container">

		<div class="ts-tab-content ts-container">
			<div class="ts-theme-options-nav">
				<div class="ts-nav">
					<div class="ts-nav-item" :class="{'current-item': tab === 'general'}">
						<a href="#" @click.prevent="setTab('general', 'base')">
							<span class="item-icon all-center">
								<i class="las la-home"></i>
							</span>
							<span class="item-name">
								General
							</span>
						</a>
					</div>
					<div class="ts-nav-item" :class="{'current-item': tab === 'pricing'}">
						<a href="#" @click.prevent="setTab('pricing', 'base')">
							<span class="item-icon all-center">
								<i class="las la-dollar-sign"></i>
							</span>
							<span class="item-name">
								Pricing
							</span>
						</a>
					</div>
					<div class="ts-nav-item" :class="{'current-item': tab === 'additions', 'vx-disabled': config.settings.payments.pricing === 'price_id'}">
						<a href="#" @click.prevent="setTab('additions')">
							<span class="item-icon all-center">
								<i class="las la-plus"></i>
							</span>
							<span class="item-name">
								Additions
							</span>
						</a>
					</div>
					<div class="ts-nav-item" :class="{'current-item': tab === 'fields'}">
						<a href="#" @click.prevent="setTab('fields')">
							<span class="item-icon all-center">
								<i class="las la-user-circle"></i>
							</span>
							<span class="item-name">
								Checkout fields
							</span>
						</a>
					</div>
					<div class="ts-nav-item" :class="{'current-item': tab === 'checkout'}">
						<a href="#" @click.prevent="setTab('checkout', 'tax')">
							<span class="item-icon all-center">
								<i class="las la-shopping-bag"></i>
							</span>
							<span class="item-name">
								Checkout
							</span>
						</a>
					</div>
					</div>
			</div>
			<div class="ts-spacer"></div>
			<div v-if="tab === 'general'" class="inner-tab x-row">



						<div class="x-col-12 ts-content-head">
							<h1>General</h1>
							<p>General settings related to this product type type</p>
						</div>
						<div class="x-col-4">
							<ul class="inner-tabs vertical-tabs">
								<li :class="{'current-item': $root.subtab === 'base'}">
									<a href="#" @click.prevent="$root.setTab('general', 'base')">General</a>
								</li>
								<li :class="{'current-item': $root.subtab === 'tags'}">
									<a href="#" @click.prevent="$root.setTab('general', 'tags')">Order tags</a>
								</li>
								<li :class="{'current-item': $root.subtab === 'deliverables'}">
									<a href="#" @click.prevent="$root.setTab('general', 'deliverables')">Deliverables</a>
								</li>
								<li :class="{'current-item': $root.subtab === 'comments'}">
									<a href="#" @click.prevent="$root.setTab('general', 'comments')">Comments</a>
								</li>
								<li :class="{'current-item': $root.subtab === 'catalog'}">
									<a href="#" @click.prevent="$root.setTab('general', 'catalog')">Catalog mode</a>
								</li>
								<li :class="{'current-item': $root.subtab === 'labels'}">
									<a href="#" @click.prevent="$root.setTab('general', 'labels')">Labels</a>
								</li>
								<li :class="{'current-item': $root.subtab === 'other'}">
									<a href="#" @click.prevent="$root.setTab('general', 'other')">Other</a>
								</li>
							</ul>
						</div>

						<div class="x-col-8">
							<template v-if="subtab === 'base'">


								<div class="ts-group">
									<div class="ts-group-head">
										<h3>Product mode</h3>
									</div>
									<div class="x-row">
										<div class="ts-form-group x-col-12">
											<div class="ts-radio-container two-column">
												<label class="container-radio">
													<h3>Booking product</h3>
													<p style="color: #ffffff87; margin: 0;">Create a product type which includes bookable days or timeslots</p>
													<input type="radio" v-model="config.settings.mode" value="booking">
													<span class="checkmark"></span>
												</label>
											</div>


										</div>
										<div class="ts-form-group x-col-12">
											<div class="ts-radio-container two-column">
												<label class="container-radio">
													<h3>Regular product</h3>
													<p style="color: #ffffff87; margin: 0;">Create a regular product</p>
													<input type="radio" v-model="config.settings.mode" value="regular">
													<span class="checkmark"></span>
												</label>
											</div>
										</div>
										<div class="ts-form-group x-col-12">
											<div class="ts-radio-container two-column">
												<label class="container-radio">
													<h3>Claim post</h3>
													<p style="color: #ffffff87; margin: 0;">Create a product type that can transfer ownership of a post after order completion</p>
													<input type="radio" v-model="config.settings.mode" value="claim">
													<span class="checkmark"></span>
												</label>
											</div>
										</div>
									</div>

								</div>


								<div v-if="config.settings.mode === 'booking'" class="ts-group">
									<div class="ts-group-head">
										<h3>Booking settings</h3>
									</div>
									<div class="x-row">
										<?php \Voxel\Form_Models\Select_Model::render( [
											'v-model' => 'config.calendar.type',
											'classes' => 'x-col-6',
											'label' => 'Get bookable instances from:',
											'choices' => [
												'booking' => 'Booking calendar',
												'recurring-date' => 'Recurring date field',
											],
										] ) ?>

										<template v-if="config.calendar.type === 'booking'">
											<?php \Voxel\Form_Models\Select_Model::render( [
												'v-model' => 'config.calendar.format',
												'classes' => 'x-col-6',
												'label' => 'Vendor can create bookable',
												'choices' => [
													'days' => 'Days',
													'slots' => 'Time slots',
												],
											] ) ?>

											<?php \Voxel\Form_Models\Switcher_Model::render( [
												'v-model' => 'config.calendar.allow_range',
												'v-if' => 'config.calendar.format === "days"',
												'classes' => 'x-col-12',
												'label' => 'Vendor can create bookable day ranges',
											] ) ?>

											<?php \Voxel\Form_Models\Select_Model::render( [
												'v-model' => 'config.calendar.range_mode',
												'v-if' => 'config.calendar.format === "days" && config.calendar.allow_range',
												'label' => 'Count range length using',
												'classes' => 'x-col-12',
												'choices' => [
													'days' => 'Days: Count the number of days in the selected range',
													'nights' => 'Nights: Count the number of nights in the selected range',
												],
											] ) ?>
										</template>
									</div>
								</div>

								<div class="ts-group">
									<div class="ts-group-head">
										<h3>Basic</h3>
									</div>
									<div class="x-row">
										<div class="ts-form-group x-col-6">
											<label>Label</label>
											<input type="text" v-model="config.settings.label">
										</div>
										<div class="ts-form-group x-col-6">
											<label>Key</label>
											<input type="text" v-model="config.settings.key" maxlength="20" required disabled>
										</div>
									</div>
								</div>






							</template>
							<template v-else-if="subtab === 'catalog'">
								<div class="ts-group">
									<div class="ts-group-head">
										<h3>Catalog mode</h3>
									</div>
									<div class="x-row">
										<div class="x-col-12 ts-form-group">
											<p>
												Catalog mode skips online Stripe checkout while keeping the rest of the functionality in place without any transactions taking place.
											</p>
										</div>
										<?php \Voxel\Form_Models\Switcher_Model::render( [
											'v-model' => 'config.settings.catalog_mode.active',
											'label' => 'Enable catalog mode',
											'classes' => 'x-col-12',
										] ) ?>

										<template v-if="config.settings.catalog_mode.active">
											<?php \Voxel\Form_Models\Switcher_Model::render( [
												'v-model' => 'config.settings.catalog_mode.requires_approval',
												'label' => 'Catalog mode: Orders require vendor approval',
												'classes' => 'x-col-12',
											] ) ?>

											<?php \Voxel\Form_Models\Switcher_Model::render( [
												'v-model' => 'config.settings.catalog_mode.refunds_allowed',
												'label' => 'Catalog mode: Allow refund requests',
												'classes' => 'x-col-12',
											] ) ?>
										</template>
									</div>
								</div>
							</template>
							<template v-else-if="subtab === 'tags'">

									<order-tags></order-tags>

							</template>
							<template v-else-if="subtab === 'deliverables'">
								<div class="ts-group">
									<div class="ts-group-head">
										<h3>Deliverables</h3>
									</div>
									<div class="x-row">
										<div class="x-col-12 ts-form-group">
											<p>
												Deliverables allow product vendors to securely share files with their customers.
												This can be done automatically when the order is completed, or manually by the vendor at any time.
												Deliverables are stored securely, without direct link access.
											</p>
										</div>

										<?php \Voxel\Form_Models\Switcher_Model::render( [
											'v-model' => 'config.settings.deliverables.enabled',
											'label' => 'Enable deliverables',
											'classes' => 'x-col-12',
										] ) ?>
									</div>
								</div>

								<template v-if="config.settings.deliverables.enabled">
									<div class="ts-group">
										<div class="ts-group-head">
											<h3>Delivery</h3>
										</div>
										<div class="x-row">
											<?php \Voxel\Form_Models\Checkboxes_Model::render( [
												'v-model' => 'config.settings.deliverables.delivery_methods',
												'label' => 'Delivery methods',
												'classes' => 'x-col-12',
												'choices' => [
													'automatic' => 'Automatic: Share files automatically when the order is completed',
													'manual' => 'Manual: Files are manually delivered by the vendor after the order is completed',
												],
											] ) ?>

											<?php \Voxel\Form_Models\Number_Model::render( [
												'v-model' => 'config.settings.deliverables.download_limit',
												'label' => 'Download limit (per file). Leave empty for unlimited downloads.',
												'classes' => 'x-col-12',
											] ) ?>
										</div>
									</div>



									<div class="ts-group">
										<div class="ts-group-head">
											<h3>Uploads</h3>
										</div>
										<div class="x-row">
											<?php \Voxel\Form_Models\Number_Model::render( [
												'v-model' => 'config.settings.deliverables.uploads.max_size',
												'label' => 'Max file size (kB)',
												'classes' => 'x-col-6',
											] ) ?>

											<?php \Voxel\Form_Models\Number_Model::render( [
												'v-model' => 'config.settings.deliverables.uploads.max_count',
												'label' => 'Max file count',
												'classes' => 'x-col-6',
											] ) ?>

											<?php \Voxel\Form_Models\Checkboxes_Model::render( [
												'v-model' => 'config.settings.deliverables.uploads.allowed_file_types',
												'label' => 'Allowed file types',
												'classes' => 'x-col-12',
												'choices' => array_combine( get_allowed_mime_types(), get_allowed_mime_types() ),
											] ) ?>
										</div>
									</div>
								</template>
							</template>
							<template v-else-if="subtab === 'comments'">


								<div class="ts-group">
									<div class="ts-group-head">
										<h3>Order comments</h3>
									</div>
									<div class="x-row">
										<?php \Voxel\Form_Models\Number_Model::render( [
											'v-model' => 'config.settings.comments.uploads.max_size',
											'label' => 'Max file size (kB)',
											'classes' => 'x-col-6',
										] ) ?>

										<?php \Voxel\Form_Models\Number_Model::render( [
											'v-model' => 'config.settings.comments.uploads.max_count',
											'label' => 'Max file count',
											'classes' => 'x-col-6',
										] ) ?>

										<?php \Voxel\Form_Models\Checkboxes_Model::render( [
											'v-model' => 'config.settings.comments.uploads.allowed_file_types',
											'label' => 'Allowed file types',
											'classes' => 'x-col-12',
											'choices' => array_combine( get_allowed_mime_types(), get_allowed_mime_types() ),
										] ) ?>
									</div>
								</div>
							</template>
							<template v-else-if="subtab === 'other'">
								<div class="ts-group">
									<div class="ts-group-head">
										<h3>Other</h3>
									</div>
									<div class="x-row">
										<?php \Voxel\Form_Models\Switcher_Model::render( [
											'v-model' => 'config.settings.notes.enabled',
											'classes' => 'x-col-12',
											'label' => 'Enable vendor notes',
										] ) ?>

										<?php \Voxel\Form_Models\Switcher_Model::render( [
											'v-model' => 'config.settings.skip_main_step',
											'classes' => 'x-col-12',
											'label' => 'Product form: Skip first step when there are no additions/booking calendar',
										] ) ?>
									</div>
								</div>
							</template>
							<template v-else-if="subtab === 'labels'">
								<div class="ts-group">
									<div class="ts-group-head">
										<h3>Product field</h3>
									</div>
									<div class="x-row">
										<div class="ts-form-group x-col-12">
											<label>Base price</label>
											<input type="text" v-model="config.settings.l10n.field.base_price">
										</div>
										<div class="ts-form-group x-col-12">
											<label>Quantity per day</label>
											<input type="text" v-model="config.settings.l10n.field.instances_per_day">
										</div>
										<div class="ts-form-group x-col-12">
											<label>Quantity per timeslot</label>
											<input type="text" v-model="config.settings.l10n.field.instances_per_slot">
										</div>
										<div class="ts-form-group x-col-12">
											<label>Notes label</label>
											<input type="text" v-model="config.settings.l10n.field.notes.label">
										</div>
										<div class="ts-form-group x-col-12">
											<label>Notes placeholder</label>
											<input type="text" v-model="config.settings.l10n.field.notes.placeholder">
										</div>
										<div class="ts-form-group x-col-12">
											<label>Notes description</label>
											<textarea v-model="config.settings.l10n.field.notes.description"></textarea>
										</div>
									</div>
								</div>


								<div class="ts-group">
									<div class="ts-group-head">
										<h3>Product form</h3>
									</div>
									<div class="x-row">

										<div class="ts-form-group x-col-12">
											<label>Check-in</label>
											<input type="text" v-model="config.settings.l10n.form.check_in">
										</div>
										<div class="ts-form-group x-col-12">
											<label>Check-out</label>
											<input type="text" v-model="config.settings.l10n.form.check_out">
										</div>
										<div class="ts-form-group x-col-12">
											<label>Choose date</label>
											<input type="text" v-model="config.settings.l10n.form.pick_date">
										</div>
									</div>
								</div>
							</template>
						</div>


			</div>
			<div v-if="tab === 'pricing'" class="inner-tab x-row h-center">





					<div class="x-col-12 ts-content-head">
						<h1>Pricing</h1>
						<p>Configure how product prices will be calculated</p>
					</div>


					<div class="x-col-4">
						<ul class="inner-tabs vertical-tabs">
							<li :class="{'current-item': $root.subtab === 'base'}">
								<a href="#" @click.prevent="$root.setTab('pricing', 'base')">Pricing</a>
							</li>

							<li :class="{'current-item': $root.subtab === 'advanced'}">
								<a href="#" @click.prevent="$root.setTab('pricing', 'advanced')">Advanced</a>
							</li>
						</ul>
					</div>

					<div class="x-col-8">
						<template v-if="subtab === 'base'">
							<div class="ts-group">
								<div class="ts-group-head">
									<h3>Enable base price</h3>
								</div>
								<div class="x-row">
									<?php \Voxel\Form_Models\Switcher_Model::render( [
										'v-model' => 'config.settings.base_price.active',
										'label' => 'Enable base price',
										'description' => 'Allows vendor to enter a base price for the product, before taking into account additions',
										'classes' => 'x-col-12',
									] ) ?>

									<?php \Voxel\Form_Models\Number_Model::render( [
										'v-model' => 'config.settings.base_price.default_price',
										'label' => "{{ config.settings.base_price.active ? 'Default base price' : 'Predefined price' }}",
										'classes' => 'x-col-12',
									] ) ?>
								</div>
							</div>
							<div class="ts-group">
								<div class="ts-group-head">
									<h3>Payment</h3>
								</div>
								<div class="x-row">
									<?php \Voxel\Form_Models\Select_Model::render( [
										'v-model' => 'config.settings.payments.mode',
										'label' => 'Payment mode',
										'classes' => 'x-col-12',
										'choices' => [
											'payment' => 'Single payment: Users pay once for products of this type',
											'subscription' => 'Subscription: Users pay on a recurring interval for products of this type',
										],
									] ) ?>

									<?php \Voxel\Form_Models\Select_Model::render( [
										'v-model' => 'config.settings.payments.transfer_destination',
										'label' => 'Upon successful payment, funds are transferred to:',
										'classes' => 'x-col-12',
										'choices' => [
											'vendor_account' => 'Vendor: Funds are transferred directly to the seller\'s account',
											'admin_account' => 'Admin: Funds are transferred to the admin account',
										],
									] ) ?>

									<?php \Voxel\Form_Models\Select_Model::render( [
										'v-if' => 'config.settings.payments.mode === \'payment\'',
										'v-model' => 'config.settings.payments.capture_method',
										'label' => 'Funds capture method',
										'classes' => 'x-col-12',
										'choices' => [
											'automatic' => 'Automatic: Capture funds when the customer authorizes the payment.',
											'manual' => 'Manual: Capture funds when the vendor approves the customer order.',
										],
									] ) ?>
								</div>

							</div>
							<template v-if="config.settings.payments.transfer_destination === 'vendor_account'">
								<div class="ts-group">
									<div class="ts-group-head">
										<h3>Vendor settings</h3>
									</div>
									<div class="x-row">
										<template v-if="config.settings.payments.mode === 'subscription'">
											<?php \Voxel\Form_Models\Number_Model::render( [
												'v-model' => 'config.checkout.application_fee.amount',
												'label' => 'Platform fee on subscription sales (in percentage)',
												'min' => 0,
												'max' => 100,
											] ) ?>
										</template>
										<template v-else>
											<?php \Voxel\Form_Models\Radio_Buttons_Model::render( [
												'v-model' => 'config.checkout.application_fee.type',
												'label' => 'Platform fee on product sales',
												'classes' => 'x-col-12',
												'choices' => [
													'percentage' => 'Percentage of product price',
													'fixed_amount' => 'Fixed amount',
												],
											] ) ?>

											<?php \Voxel\Form_Models\Number_Model::render( [
												'v-model' => 'config.checkout.application_fee.amount',
												'v-if' => 'config.checkout.application_fee.type === "percentage"',
												'label' => 'Percentage',
												'min' => 0,
												'max' => 100,
												'classes' => 'x-col-12',
											] ) ?>

											<?php \Voxel\Form_Models\Number_Model::render( [
												'v-model' => 'config.checkout.application_fee.amount',
												'v-if' => 'config.checkout.application_fee.type === "fixed_amount"',
												'label' => 'Amount (in cents)',
												'min' => 0,
												'classes' => 'x-col-12',
											] ) ?>
										</template>

										<?php \Voxel\Form_Models\Switcher_Model::render( [
											'v-model' => 'config.checkout.on_behalf_of',
											'label' => 'Make the vendor account the business of record for the payment',
											'classes' => 'x-col-12',
										] ) ?>

										<div class="x-col-12 ts-form-group">
											<details>
												<summary>Details</summary>
												<p>
												When enabled, Stripe automatically:<br>
												 - Settles charges in the country of the specified account, thereby minimizing declines and avoiding currency conversions.</br>
												 - Uses the fee structure for the connected account’s country.</br>
												 - Uses the connected account’s statement descriptor.</br>
												 - If the account is in a different country than the platform, the connected account’s address and phone number shows up on the customer’s credit card statement (as opposed to the platform’s).</br>
												 - The number of days that a pending balance is held before being paid out depends on the delay_days setting on the connected account.</br>
												 - Not compatible with automatic tax calculation.<br><br>
												Source: <a href="https://stripe.com/docs/connect/charges#on_behalf_of" target="_blank">https://stripe.com/docs/connect/charges#on_behalf_of</a>
												</p>
											</details>
										</div>
									</div>
								</div>
							</template>

						</template>

						<template v-else-if="subtab === 'advanced'">
							<div class="ts-group">
								<div class="ts-group-head">
									<h3>Advanced</h3>
								</div>
								<div class="x-row">
									<?php \Voxel\Form_Models\Radio_Buttons_Model::render( [
										'v-model' => 'config.settings.payments.pricing',
										'label' => 'Product pricing',
										'classes' => 'x-col-12',
										'choices' => [
											'dynamic' => <<<HTML
												<h3>Dynamic</h3>
												<p style="color: #ffffff87; margin: 0;">Price is calculated as the sum of the base price and used additions.</p>
											HTML,
											'price_id' => <<<HTML
												<h3>Price ID</h3>
												<p style="color: #ffffff87; margin: 0;">
													Price references a product price ID created directly in the Stripe dashboard.
													Product additions are not available with this method.
												</p>
											HTML,
										],
									] ) ?>
								</div>
							</div>
						</template>
					</div>


			</div>
			<div v-if="tab === 'additions'" class="inner-tab x-row">
				<product-additions></product-additions>
			</div>
			<div v-if="tab === 'fields'" class="inner-tab x-row ">
				<information-fields></information-fields>
			</div>
			<div v-if="tab === 'checkout'" class="inner-tab x-row">

					<div class="x-col-12 ts-content-head">
						<h1>Checkout</h1>
						<p>Configure checkout for this product type</p>
					</div>
					<div class="x-col-4">
						<ul class="inner-tabs vertical-tabs">
							<li :class="{'current-item': $root.subtab === 'tax'}">
								<a href="#" @click.prevent="$root.setTab('checkout', 'tax')">Tax collection</a>
							</li>
							<li :class="{'current-item': $root.subtab === 'shipping'}">
								<a href="#" @click.prevent="$root.setTab('checkout', 'shipping')">Shipping</a>
							</li>
							<li :class="{'current-item': $root.subtab === 'promotions'}">
								<a href="#" @click.prevent="$root.setTab('checkout', 'promotions')">Promotion codes</a>
							</li>
						</ul>
					</div>

					<div class="x-col-8">
						<template v-if="subtab === 'tax'">

							<div class="ts-group">
								<div class="ts-group-head">
									<h3>Tax collection</h3>
								</div>
								<div class="x-row">
									<?php \Voxel\Form_Models\Switcher_Model::render( [
										'v-model' => 'config.checkout.tax.auto.tax_id_collection',
										'label' => 'Enable customer tax ID collection',
										'classes' => 'x-col-12',
									] ) ?>

									<div class="x-col-12 ts-form-group">
										<p class="mt15">See list of supported countries <a href="https://stripe.com/docs/tax/checkout/tax-ids#supported-types" target="_blank">here</a></p>
									</div>

									<?php \Voxel\Form_Models\Select_Model::render( [
										'v-model' => 'config.checkout.tax.mode',
										'label' => 'Tax collection mode',
										'classes' => 'x-col-12',
										'choices' => [
											'auto' => 'Automatic',
											'manual' => 'Manual',
											'none' => 'None',
										],
									] ) ?>
								</div>
							</div>

							<template v-if="config.checkout.tax.mode === 'auto'">
								<div class="ts-group">
									<div class="ts-group-head">
										<h3>Automatic tax collection</h3>
									</div>
									<div class="x-row">
										<div class="ts-form-group x-col-12">
											<p>Collect taxes automatically using <a href="https://stripe.com/tax" target="_blank">Stripe Tax</a></p>

										</div>


										<?php \Voxel\Form_Models\Select_Model::render( [
											'v-model' => 'config.checkout.tax.auto.tax_code',
											'label' => 'Tax code',
											'classes' => 'x-col-12',
											'choices' => [ '' => 'Select a code' ] + \Voxel\Stripe\Tax_Codes::all(),
										] ) ?>

										<?php \Voxel\Form_Models\Select_Model::render( [
											'v-model' => 'config.checkout.tax.auto.tax_behavior',
											'label' => 'Tax behavior',
											'classes' => 'x-col-12',
											'choices' => [
												'inclusive' => 'Inclusive',
												'exclusive' => 'Exclusive',
											],
										] ) ?>

										<div class="ts-form-group x-col-12">

											<p>
												<a href="<?= esc_url( \Voxel\Stripe::dashboard_url( '/settings/tax' ) ) ?>" target="_blank">Configure Stripe Tax</a>
												<span> &middot; </span>
												<a href="https://stripe.com/docs/tax/tax-codes" target="_blank">Available Tax Codes</a>
											</p>
										</div>
									</div>
								</div>
							</template>

							<template v-if="config.checkout.tax.mode === 'manual'">

								<div class="ts-group">
									<div class="ts-group-head">
										<h3>Collect taxes manually using Tax Rates</h3>
									</div>
									<div class="x-row">
										<div class="x-col-12">
											<a href="<?= esc_url( \Voxel\Stripe::dashboard_url( '/tax-rates' ) ) ?>" target="_blank" class="ts-button ts-outline full-width">
												<i class="las la-external-link-alt icon-sm"></i>
												Setup tax rates
											</a>
										</div>
									</div>
								</div>


								<div class="ts-group">
									<div class="ts-group-head">
										<h3>Live mode</h3>
									</div>
									<div class="x-row">
										<div class="ts-form-group x-col-12">

											<rate-list
												v-model="config.checkout.tax.manual.tax_rates"
												mode="live"
												source="backend.list_tax_rates"
											></rate-list>
										</div>
									</div>
								</div>

								<div class="ts-group">
									<div class="ts-group-head">
										<h3>Test mode</h3>
									</div>
									<div class="x-row">
										<div class="ts-form-group x-col-12">

											<rate-list
												v-model="config.checkout.tax.manual.test_tax_rates"
												mode="test"
												source="backend.list_tax_rates"
											></rate-list>
										</div>
									</div>
								</div>

							</template>
						</template>
						<template v-else-if="subtab === 'shipping'">
							<div class="ts-group">
								<div class="ts-group-head">
									<h3>Shipping</h3>
								</div>
								<div class="x-row">
									<?php \Voxel\Form_Models\Switcher_Model::render( [
										'v-model' => 'config.checkout.shipping.enabled',
										'label' => 'Enable shipping',
										'classes' => 'x-col-12',
									] ) ?>
								</div>
							</div>

							<template v-if="config.checkout.shipping.enabled">
								<div class="ts-group">
									<div class="ts-group-head">
										<h3>Shipping rates</h3>
									</div>
									<div class="x-row">
										<div class="ts-form-group x-col-12">
											<a class="ts-button ts-outline full-width" href="<?= esc_url( \Voxel\Stripe::dashboard_url( '/shipping-rates' ) ) ?>" target="_blank">Manage Shipping Rates</a>
										</div>
									</div>
								</div>
								<div class="ts-group">
									<div class="ts-group-head">
										<h3>Live mode</h3>
									</div>
									<div class="x-row">
										<div class="ts-form-group x-col-12">
											
											<rate-list
												v-model="config.checkout.shipping.shipping_rates"
												mode="live"
												source="backend.list_shipping_rates"
											></rate-list>
										</div>
									</div>
									
								</div>
								<div class="ts-group">
									<div class="ts-group-head">
										<h3>Test mode</h3>
									</div>
									<div class="x-row">
										<div class="ts-form-group x-col-12">
										
											<rate-list
												v-model="config.checkout.shipping.test_shipping_rates"
												mode="test"
												source="backend.list_shipping_rates"
											></rate-list>
										</div>
									</div>

									
								</div>
								<div class="ts-group">
									<div class="ts-group-head">
										<h3>Countries</h3>
									</div>
									<div class="x-row">
										<?php \Voxel\Form_Models\Checkboxes_Model::render( [
											'v-model' => 'config.checkout.shipping.allowed_countries',
											'label' => 'Allowed countries',
											'classes' => 'x-col-12',
											'description' => sprintf(
												'These countries are currently not supported: %s',
												"\n - ".join( "\n - ", \Voxel\Stripe\Country_Codes::shipping_unsupported() )
											),
											'columns' => 'two',
											'choices' => \Voxel\Stripe\Country_Codes::shipping_supported(),
										] ) ?>
									</div>
								</div>
								
							</template>
						</template>
						<template v-else-if="subtab === 'promotions'">
							<div class="ts-group">
								<div class="ts-group-head">
									<h3>Promotion codes</h3>
								</div>
								<div class="x-row">
									<?php \Voxel\Form_Models\Switcher_Model::render( [
										'v-model' => 'config.checkout.promotion_codes.enabled',
										'label' => 'Allow promotion codes in checkout',
										'classes' => 'x-col-12',
									] ) ?>

									<div class="x-col-12">
										<div class="basic-ul">
											<a href="<?= esc_url( \Voxel\Stripe::dashboard_url( '/coupons' ) ) ?>" target="_blank" class="ts-button ts-outline full-width">
												<i class="las la-external-link-alt icon-sm"></i>
												Manage promotion codes
											</a>
										</div>
									</div>
								</div>
							</div>
						</template>
					</div>

			</div>
		</div>

		<?php if ( \Voxel\is_dev_mode() ): ?>
			<!-- <pre debug>{{ config }}</pre> -->
		<?php endif ?>
	</div>
</form>
</div>


<?php require_once locate_template( 'templates/backend/product-types/components/rate-list-component.php' ) ?>
