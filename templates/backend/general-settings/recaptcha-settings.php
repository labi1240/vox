<?php
if ( ! defined('ABSPATH') ) {
	exit;
} ?>
<div class="ts-group">
	<div class="ts-group-head">
		<h3>Configuration</h3>
	</div>
	<div class="x-row">
		<div class="ts-form-group x-col-12">
			<p>Configure Google reCAPTCHA in the <a href="https://www.google.com/recaptcha/admin" target="_blank">v3 Admin Console</a></p>
		</div>
		<?php \Voxel\Form_Models\Switcher_Model::render( [
			'v-model' => 'config.recaptcha.enabled',
			'label' => 'Enable reCAPTCHA',
			'classes' => 'x-col-12',
		] ) ?>

		<?php \Voxel\Form_Models\Text_Model::render( [
			'v-model' => 'config.recaptcha.key',
			'label' => 'Site key',
			'classes' => 'x-col-12',
		] ) ?>

		<?php \Voxel\Form_Models\Password_Model::render( [
			'v-model' => 'config.recaptcha.secret',
			'label' => 'Secret key',
			'classes' => 'x-col-12',
			'autocomplete' => 'new-password',
		] ) ?>
	</div>
</div>
