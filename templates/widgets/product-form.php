<?php
/**
 * Product form widget template.
 *
 * @since 1.0
 */
if ( ! defined('ABSPATH') ) {
	exit;
}

$deferred_templates = [];
$deferred_templates[] = locate_template( 'templates/widgets/product-form/_date-picker.php' );
$deferred_templates[] = locate_template( 'templates/widgets/product-form/_date-range-picker.php' );
$deferred_templates[] = locate_template( 'templates/widgets/product-form/_information-fields.php' );
$deferred_templates[] = locate_template( 'templates/widgets/create-post/_media-popup.php' );
?>

<script type="text/json" class="vxconfig"><?= wp_specialchars_decode( wp_json_encode( $config ) ) ?></script>
<div
	class="ts-form ts-booking-form min-scroll"
	data-post-id="<?= absint( $post->get_id() ) ?>"
	data-field-key="<?= esc_attr( $field->get_key() ) ?>"
	v-cloak
>
	<div v-show="step === 'main'" class="ts-booking-main">
		<div class="booking-head">
			<?= \Voxel\get_icon_markup( $this->get_settings_for_display('stepone_ico') ) ?: \Voxel\svg( 'bag.svg' ) ?>
			<span><?= $this->get_settings_for_display('prform_stepone_text') ?></span>
		</div>

		<?php require locate_template( 'templates/widgets/product-form/booking.php' ) ?>
		<?php require locate_template( 'templates/widgets/product-form/additions.php' ) ?>
		<?php require locate_template( 'templates/widgets/product-form/custom-additions.php' ) ?>

		<div class="ts-form-group">
			<a href="#" @click.prevent="prepareCheckout" class="ts-btn ts-btn-2 ts-btn-large ts-booking-submit" :class="{'vx-pending': loading}">
				<?= $this->get_settings_for_display('prform_continue') ?>
				<?= \Voxel\get_icon_markup( $this->get_settings_for_display('ts_continue_icon') ) ?: \Voxel\svg( 'right-arrow.svg' ) ?>
			</a>
		</div>

		<?php require locate_template( 'templates/widgets/product-form/pricing-summary.php' ) ?>
	</div>

	<div v-show="step === 'checkout'" class="ts-booking-fields">
		<div class="booking-head">
			<?= \Voxel\get_icon_markup( $this->get_settings_for_display('steptwo_ico') ) ?: \Voxel\svg( 'menu.svg' ) ?>
			<span><?= $this->get_settings_for_display('prform_steptwo_text') ?></span>
		</div>

		<?php foreach ( $product_type->get_fields() as $field ):
			$field_object = sprintf( '$root.config.fields[%s]', esc_attr( wp_json_encode( $field->get_key() ) ) );
			?>
			<field-<?= $field->get_type() ?>
				:field="<?= $field_object ?>"
				ref="field:<?= esc_attr( $field->get_key() ) ?>"
			></field-<?= $field->get_type() ?>>
		<?php endforeach ?>

		<div class="ts-form-group">
			<a href="#" @click.prevent="submit" class="ts-btn ts-btn-2 ts-btn-large ts-booking-submit" :class="{'vx-pending': loading}">
				<?= \Voxel\get_icon_markup( $this->get_settings_for_display('ts_checkout_ico') ) ?: \Voxel\svg( 'shopping-bag.svg' ) ?>
				<?= $this->get_settings_for_display('prform_checkout') ?>
			</a>
		</div>
		<div v-if="!lockToCheckout" class="ts-form-group">
	   		<a href="#" class="ts-btn ts-btn-4 ts-btn-large"  @click.prevent="step = 'main'" >
	   			<?= \Voxel\get_icon_markup( $this->get_settings_for_display('ts_arrow_left') ) ?: \Voxel\svg( 'chevron-left.svg' ) ?>
	   			<?= __( 'Go back', 'voxel' ) ?>
	   		</a>
		</div>
	</div>

	<teleport to="body">
		<transition name="form-popup">
			<form-popup
				v-if="externalItemRef && externalItem"
				:target="externalItemRef"
				@blur="externalItemRef = null; externalItem = null;"
				@save="externalItem = null"
				@clear="externalItem.value = externalItem.has_quantity ? 0 : false;"
			>
				<div class="ts-form-group">
					<label>{{ externalItem.label }}</label>
					<div class="ts-stepper-input flexify">
						<button class="ts-stepper-left ts-icon-btn" @click.prevent="decrement(externalItem)">
							<?= \Voxel\get_icon_markup( $this->get_settings_for_display('ts_minus_icon') ) ?: \Voxel\svg( 'minus.svg' ) ?>
						</button>
						<input v-model="externalItem.value" type="number" class="ts-input-box" @change="validateValueInBounds(externalItem)">
						<button class="ts-stepper-right ts-icon-btn" @click.prevent="increment(externalItem)">
							<?= \Voxel\get_icon_markup( $this->get_settings_for_display('ts_plus_icon') ) ?: \Voxel\svg( 'plus.svg' ) ?>
						</button>
					</div>
				</div>
			</form-popup>
		</transition>
	</teleport>
</div>

<?php foreach ( $deferred_templates as $template_path ): ?>
	<?php require_once $template_path ?>
<?php endforeach ?>
