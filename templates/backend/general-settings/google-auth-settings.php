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
			<p>Configure project and retrieve client id & secret in the <a href="https://console.cloud.google.com/home" target="_blank">Google API Console</a></p>
		</div>
		<?php \Voxel\Form_Models\Switcher_Model::render( [
			'v-model' => 'config.auth.google.enabled',
			'label' => 'Enable Login with Google',
			'classes' => 'x-col-12',
		] ) ?>

		<?php \Voxel\Form_Models\Text_Model::render( [
			'v-model' => 'config.auth.google.client_id',
			'label' => 'Client ID',
			'classes' => 'x-col-12',
		] ) ?>

		<?php \Voxel\Form_Models\Password_Model::render( [
			'v-model' => 'config.auth.google.client_secret',
			'label' => 'Client secret',
			'classes' => 'x-col-12',
			'autocomplete' => 'new-password',
		] ) ?>
	</div>
</div>
