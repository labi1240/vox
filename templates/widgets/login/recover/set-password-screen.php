<?php
if ( ! defined('ABSPATH') ) {
	exit;
} ?>

<form @submit.prevent="submitNewPassword">
	<div class="ts-login-head">
		<p><?php echo $this->get_settings_for_display( 'new_password' ); ?></p>
	</div>
	<div class="login-section">
		
		<div class="ts-form-group">
			<label><?= _x( 'Choose your new password', 'auth', 'voxel' ) ?>	<small><?= _x( 'Password must contain at least 8 characters and one number.', 'auth', 'voxel' ) ?></small></label>

			<div class="ts-input-icon flexify">
				<?= \Voxel\get_icon_markup( $this->get_settings_for_display('auth_pass_ico') ) ?: \Voxel\svg( 'lock-alt.svg' ) ?>
				<input class="ts-filter" type="password" v-model="recovery.password" placeholder="<?= esc_attr( _x( 'Your new password', 'auth', 'voxel' ) ) ?>" class="autofocus">
			</div>
		</div>
		<div class="ts-form-group">
			<div class="ts-input-icon flexify">
				<?= \Voxel\get_icon_markup( $this->get_settings_for_display('auth_pass_ico') ) ?: \Voxel\svg( 'lock-alt.svg' ) ?>
				<input class="ts-filter" type="password" v-model="recovery.confirm_password" placeholder="<?= esc_attr( _x( 'Confirm password', 'auth', 'voxel' ) ) ?>" class="autofocus">
			</div>
		</div>

		<div class="ts-form-group">
			<button type="submit" class="ts-btn ts-btn-2 ts-btn-large" :class="{'vx-pending': pending}">
				<?= _x( 'Save changes', 'auth', 'voxel' ) ?>
			</button>
		</div>
	</div>
</form>
