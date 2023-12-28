<?php
/**
 * Admin membership settings.
 *
 * @since 1.0
 */

if ( ! defined('ABSPATH') ) {
	exit;
} ?>
<div class="sticky-top">
	<div class="vx-head x-container">
		<h2>Create user role</h2>
	</div>
</div>
<div class="ts-spacer"></div>
<div class="x-container">
	<div class="x-row">
		<div class="x-col-4">
			<form method="POST" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ) ?>">
				<div class="x-row">
					<div class="ts-form-group x-col-12">
						<label>Label</label>
						<input name="role[label]" type="text" autocomplete="off" required>
					</div>
					<div class="ts-form-group x-col-12">
						<label>Key</label>
						<input name="role[key]" type="text" autocomplete="off" required><br>
					</div>
					<div class="ts-form-group x-col-12">
						<input type="hidden" name="action" value="voxel_create_membership_role">
						<?php wp_nonce_field( 'voxel_manage_membership_roles' ) ?>
						<button type="submit" class="ts-button ts-create-settings full-width">Create role</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>