<?php
/**
 * Create post widget template.
 *
 * @since 1.0
 */
if ( ! defined('ABSPATH') ) {
	exit;
}

$deferred_templates = [];
$deferred_templates[] = locate_template( 'templates/widgets/create-post/_media-popup.php' );
?>

<?php if ( ! $post && ! $user->can_create_post( $post_type->get_key() ) ):
	$limit = $user->get_submission_limit_for_post_type( $post_type->get_key() );
	$role = $user->get_roles()[0] ?? null;

	$pricing_plans_url = get_permalink( \Voxel\Role::get('subscriber')->get_pricing_page_id() );
	if ( $role && ! ( $user->has_role('administrator') || $user->has_role('editor') ) ) {
		$pricing_plans_url = get_permalink( $role->get_pricing_page_id() );
	}

	$configure_plan_url = get_permalink( \Voxel\get( 'templates.configure_plan' ) );
	$current_plan_url = get_permalink( \Voxel\get( 'templates.current_plan' ) );

	$current_url = home_url( $GLOBALS['wp']->request );
	$pricing_plans_url = add_query_arg( 'redirect_to', $current_url, $pricing_plans_url );
	$configure_plan_url = add_query_arg( 'redirect_to', $current_url, $configure_plan_url );
	?>
<div class="ts-form ts-create-post no-vue ts-ready create-post-form">
	<div class="ts-edit-success flexify">
		<?= \Voxel\get_icon_markup( $this->get_settings_for_display('info_icon') ) ?: \Voxel\svg( 'info.svg' ) ?>

		<?php if ( ! $limit || $limit->get_count() < 1 ): ?>
			<h4><?= _x( 'Your current plan does not have submission capabilities', 'create post', 'voxel' ) ?></h4>
		<?php else: ?>
			<h4><?= _x( 'You have reached your allowed submission limit', 'create post', 'voxel' ) ?></h4>
		<?php endif ?>

		<div class="es-buttons flexify">
			<?php if ( $user->can_modify_limits_for_post_type( $post_type->get_key() ) ): ?>
				<a href="<?= esc_url( $configure_plan_url ) ?>" class="ts-btn ts-btn-1 ts-btn-large form-btn">
					<?= \Voxel\get_icon_markup( $this->get_settings_for_display('next_icon') ) ?: \Voxel\svg( 'circle-plus.svg' ) ?>
					<?= _x( 'Increase limits of your current plan', 'create post', 'voxel' ) ?>
				</a>
			<?php endif ?>
			<a href="<?= esc_url( $pricing_plans_url ) ?>" class="ts-btn ts-btn-1 ts-btn-large form-btn">
				<?= \Voxel\get_icon_markup( $this->get_settings_for_display('ts_switch_ico') ) ?: \Voxel\svg( 'switch.svg' ) ?>
				<?= _x( 'Switch to a different plan', 'create post', 'voxel' ) ?>
			</a>
			<a href="<?= esc_url( $current_plan_url ) ?>" class="ts-btn ts-btn-1 ts-btn-large form-btn">
				<?= \Voxel\get_icon_markup( $this->get_settings_for_display('ts_role_ico') ) ?: \Voxel\svg( 'user.svg' ) ?>
				<?= _x( 'View your current plan', 'create post', 'voxel' ) ?>
			</a>
		</div>
	</div>
</div>
<?php else: ?>
	<script type="text/json" class="vxconfig"><?= wp_specialchars_decode( wp_json_encode( $config ) ) ?></script>
	<div
		class="ts-form ts-create-post create-post-form"
	>
		<transition name="fade">
			<template v-if="submission.done">
				<div class="ts-edit-success flexify">
					<?= \Voxel\get_icon_markup( $this->get_settings_for_display('success_icon') ) ?: \Voxel\svg( 'checkmark-circle.svg' ) ?>
					<h4>{{ submission.message }}</h4>
					<!-- <p>{{ submission.message }}</p> -->
					<div class="es-buttons flexify">
						<a v-if="submission.status === 'publish'" :href="submission.viewLink" class="ts-btn ts-btn-2 ts-btn-large form-btn">
							<?= \Voxel\get_icon_markup( $this->get_settings_for_display('view_icon') ) ?: \Voxel\svg( 'eye.svg' ) ?>
							<template v-if="post_type.key === 'profile'">
								<?= _x( 'View your profile', 'create post', 'voxel' ) ?>
							</template>
							<template v-else>
								<?= _x( 'View', 'create post', 'voxel' ) ?>
							</template>
						</a>
						<!-- <a v-if="!post" href="#" class="ts-btn ts-btn-1 ts-btn-large">
							<i aria-hidden="true" class="las la-share"></i>
							Share to timeline
						</a> -->
						<a :href="submission.editLink" class="ts-btn ts-btn-1 ts-btn-large form-btn">
							<?= \Voxel\get_icon_markup( $this->get_settings_for_display('prev_icon') ) ?: \Voxel\svg( 'chevron-left.svg' ) ?>
							<?= _x( 'Back to editing', 'create post', 'voxel' ) ?>
						</a>
					</div>
				</div>
			</template>
		</transition>
		<template v-if="!submission.done">
			<div class="ts-form-progres">
				<ul class="step-percentage simplify-ul flexify">
					<template v-for="step_key, index in activeSteps">
						<li :class="{'step-done': step_index >= index}"></li>
					</template>
				</ul>
				<div class="ts-active-step flexify">
					<div class="active-step-details">
						<p>{{ currentStep.label }}</p>
					</div>
					<div class="step-nav flexify">

						<template v-if="activeSteps.length > 1">
							<a v-if="config.can_save_draft && ! config.is_admin_mode" @click.prevent="saveDraft" href="#" class="ts-icon-btn has-tooltip ts-save-draft" :class="{'vx-pending': submission.processing}" data-tooltip="<?= _x( 'Save as draft', 'create post', 'voxel' ) ?>">
								<?= \Voxel\get_icon_markup( $this->get_settings_for_display('draft_icon') ) ?: \Voxel\svg( 'save.svg' ) ?>
							</a>
							<a href="#" @click.prevent="prevStep" class="ts-icon-btn has-tooltip" :class="{'disabled': step_index === 0}" data-tooltip="<?= _x( 'Previous step', 'create post', 'voxel' ) ?>">
								<?= \Voxel\get_icon_markup( $this->get_settings_for_display('prev_icon') ) ?: \Voxel\svg( 'chevron-left.svg' ) ?>
							</a>
							<a href="#" @click.prevent="nextStep($event.shiftKey ? false : true)" class="ts-icon-btn has-tooltip" :class="{'disabled': step_index === (activeSteps.length - 1)}" data-tooltip="<?= _x( 'Next step', 'create post', 'voxel' ) ?>">
								<?= \Voxel\get_icon_markup( $this->get_settings_for_display('next_icon') ) ?: \Voxel\svg( 'chevron-right.svg' ) ?>
							</a>
						</template>
					</div>
				</div>
			</div>

			<div class="create-form-step form-field-grid">
				<?php
				$hidden_steps = [];
				foreach ( $post_type->get_fields() as $field ):
					try {
						$field->check_dependencies();
					} catch ( \Exception $e ) {
						continue;
					}

					if ( isset( $hidden_steps[ $field->get_step() ] ) || ! $field->passes_visibility_rules() ) {
						if ( $field->get_type() === 'ui-step' ) {
							$hidden_steps[ $field->get_key() ] = true;
						}

						continue;
					}

					if ( $field->get_type() === 'ui-step' ) {
						continue;
					}

					if ( $field_template = locate_template( sprintf( 'templates/widgets/create-post/%s-field.php', $field->get_type() ) ) ) {
						$deferred_templates[] = $field_template;
					}

					if ( $field->get_type() === 'repeater' ) {
						$deferred_templates = array_merge( $deferred_templates, $field->get_field_templates() );
					}

					$field_object = sprintf( '$root.fields[%s]', esc_attr( wp_json_encode( $field->get_key() ) ) );
					?>

					<field-<?= $field->get_type() ?>
						:field="<?= $field_object ?>"
						v-if="conditionsPass( <?= $field_object ?> )"
						:style="<?= $field_object ?>.step === currentStep.key ? '' : 'display: none;'"
						ref="field:<?= esc_attr( $field->get_key() ) ?>"
						:class="['field-key-'+<?= $field_object ?>.key, <?= $field_object ?>.validation.errors.length >= 1 ? 'ts-has-errors' : '']"
					>
						<template #errors>
							<template v-if="<?= $field_object ?>.validation.errors.length >= 1">
								<span class="is-required">{{ <?= $field_object ?>.validation.errors[0] }}</span>
							</template>
							<template v-else>
								<span v-if="!<?= $field_object ?>.required" class="is-required"><?= _x( 'Optional', 'create post', 'voxel' ) ?></span>
							</template>
						</template>
					</field-<?= $field->get_type() ?>>

					<?php if ( \Voxel\is_dev_mode() ): ?>
						<!-- <p style="text-align: right;" v-if="conditionsPass( <?= $field_object ?> )"
						:style="<?= $field_object ?>.step === currentStep.key ? '' : 'display: none;'">
							<a href="#" @click.prevent="validate_field(<?= esc_attr( wp_json_encode( $field->get_key() ) ) ?>)">Check validity</a>
						</p> -->
					<?php endif ?>
					<?php
				endforeach; ?>

			</div>

			<div class="ts-form-footer flexify">
				<ul v-if="activeSteps.length > 1" class="ts-nextprev simplify-ul flexify">
					<li>
						<a :class="{'disabled': step_index === 0}" href="#" @click.prevent="prevStep" class="ts-prev ts-btn ts-btn-1 ts-btn-large form-btn">
							<?= \Voxel\get_icon_markup( $this->get_settings_for_display('prev_icon') ) ?: \Voxel\svg( 'chevron-left.svg' ) ?>
							<?= _x( 'Previous step', 'create post', 'voxel' ) ?>
						</a>
					</li>
					<li>
						<a :class="{'disabled': step_index === (activeSteps.length - 1)}" href="#" @click.prevent="$event.shiftKey ? submit() : nextStep($event.shiftKey ? false : true)" class="ts-next ts-btn ts-btn-1 ts-btn-large form-btn">
							<?= _x( 'Next step', 'create post', 'voxel' ) ?>
							<?= \Voxel\get_icon_markup( $this->get_settings_for_display('next_icon') ) ?: \Voxel\svg( 'chevron-right.svg' ) ?>
						</a>
					</li>
				</ul>

				<!-- only when submitting  -->
				<a
					v-if="!post && step_index === (activeSteps.length - 1)"
					href="#"
					@click.prevent="submit"
					class="ts-btn ts-btn-2 form-btn ts-btn-large ts-save-changes"
					:class="{'vx-pending': submission.processing}"
				>
					<template v-if="submission.processing">
						<span class="ts-loader"></span>
						<?= _x( 'Please wait', 'create post', 'voxel' ) ?>
					</template>
					<template v-else>
						<?= _x( 'Publish', 'create post', 'voxel' ) ?>
						<?= \Voxel\get_icon_markup( $this->get_settings_for_display('publish_icon') ) ?: \Voxel\svg( 'right-arrow.svg' ) ?>
					</template>
				</a>

				<!-- only when editing -->
				<a v-if="post" href="#" @click.prevent="submit" class="ts-btn ts-btn-2 form-btn ts-btn-large ts-save-changes" :class="{'vx-pending': submission.processing}">
					<template v-if="submission.processing">
						<span class="ts-loader"></span>
						<?= _x( 'Please wait', 'create post', 'voxel' ) ?>
					</template>
					<template v-else>
						<?= \Voxel\get_icon_markup( $this->get_settings_for_display('save_icon') ) ?: \Voxel\svg( 'save.svg' ) ?>
						<?= _x( 'Save changes', 'create post', 'voxel' ) ?>
					</template>
				</a>

			</div>
		</template>
	</div>

	<?php foreach ( $deferred_templates as $template_path ): ?>
		<?php require_once $template_path ?>
	<?php endforeach ?>
<?php endif ?>
