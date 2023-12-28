<?php
if ( ! defined('ABSPATH') ) {
	exit;
} ?>
<div class="ts-group">

	<div class="ts-group-head">
		<h3>Statuses</h3>
	</div>

	<div class="x-row">
		<?php \Voxel\Form_Models\Switcher_Model::render( [
			'v-model' => 'config.timeline.posts.editable',
			'label' => 'Allow editing',
			'classes' => 'x-col-12',
		] ) ?>

		<?php \Voxel\Form_Models\Number_Model::render( [
			'v-model' => 'config.timeline.posts.maxlength',
			'label' => 'Max length (in characters)',
			'classes' => 'x-col-12',
		] ) ?>

		<?php \Voxel\Form_Models\Switcher_Model::render( [
			'v-model' => 'config.timeline.posts.images.enabled',
			'label' => 'Allow image attachments',
			'classes' => 'x-col-12',
		] ) ?>

		<?php \Voxel\Form_Models\Number_Model::render( [
			'v-if' => 'config.timeline.posts.images.enabled',
			'v-model' => 'config.timeline.posts.images.max_count',
			'label' => 'Max image count',
			'classes' => 'x-col-6',
		] ) ?>

		<?php \Voxel\Form_Models\Number_Model::render( [
			'v-if' => 'config.timeline.posts.images.enabled',
			'v-model' => 'config.timeline.posts.images.max_size',
			'label' => 'Max image size (in kB)',
			'classes' => 'x-col-6',
		] ) ?>
	</div>

</div>
<div class="ts-group">

	<div class="ts-group-head">
		<h3>Replies</h3>
	</div>

	<div class="x-row">
		<?php \Voxel\Form_Models\Switcher_Model::render( [
			'v-model' => 'config.timeline.replies.editable',
			'label' => 'Allow editing',
			'classes' => 'x-col-12',
		] ) ?>

		<?php \Voxel\Form_Models\Number_Model::render( [
			'v-model' => 'config.timeline.replies.maxlength',
			'label' => 'Max length (in characters)',
			'classes' => 'x-col-6',
		] ) ?>

		<?php \Voxel\Form_Models\Number_Model::render( [
			'v-model' => 'config.timeline.replies.max_nest_level',
			'label' => 'Max reply depth',
			'classes' => 'x-col-6',
			'placeholder' => 2,
		] ) ?>
	</div>
</div>
<div class="ts-group">

	<div class="ts-group-head">
		<h3>Post rate limiting</h3>
	</div>


	<div class="x-row">
		<?php \Voxel\Form_Models\Number_Model::render( [
			'v-model' => 'config.timeline.posts.rate_limit.time_between',
			'label' => 'Minimum time between posts (in seconds)',
			'classes' => 'x-col-6',
		] ) ?>

		<?php \Voxel\Form_Models\Number_Model::render( [
			'v-model' => 'config.timeline.posts.rate_limit.hourly_limit',
			'label' => 'Maximum number of posts allowed in an hour',
			'classes' => 'x-col-6',
		] ) ?>

		<?php \Voxel\Form_Models\Number_Model::render( [
			'v-model' => 'config.timeline.posts.rate_limit.daily_limit',
			'label' => 'Maximum number of posts allowed in a day',
			'classes' => 'x-col-6',
		] ) ?>
	</div>

</div>
<div class="ts-group">
	<div class="ts-group-head">
		<h3>Reply rate limiting</h3>
	</div>
	<div class="x-row">
		<?php \Voxel\Form_Models\Number_Model::render( [
			'v-model' => 'config.timeline.replies.rate_limit.time_between',
			'label' => 'Minimum time between replies (in seconds)',
			'classes' => 'x-col-6',
		] ) ?>

		<?php \Voxel\Form_Models\Number_Model::render( [
			'v-model' => 'config.timeline.replies.rate_limit.hourly_limit',
			'label' => 'Maximum number of replies allowed in an hour',
			'classes' => 'x-col-6',
		] ) ?>

		<?php \Voxel\Form_Models\Number_Model::render( [
			'v-model' => 'config.timeline.replies.rate_limit.daily_limit',
			'label' => 'Maximum number of replies allowed in a day',
			'classes' => 'x-col-6',
		] ) ?>
	</div>
</div>
