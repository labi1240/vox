<?php
if ( ! defined('ABSPATH') ) {
	exit;
} ?>
<script type="text/html" id="auth-file-field">
	<div class="ts-form-group ts-file-upload inline-file-field" @dragenter="dragActive = true">
		<label>
			{{ field.label }}
			<span v-if="!field.required" class="is-required"><?= _x( 'Optional', 'auth', 'voxel' ) ?></span>
			<small>{{ field.description }}</small>
		</label>
		<div class="drop-mask" v-show="dragActive" @dragleave.prevent="dragActive = false" @drop.prevent="onDrop" @dragenter.prevent @dragover.prevent></div>
		<div class="ts-file-list" ref="fileList" v-pre>
			<div class="pick-file-input">
				<a href="#">
					<?= \Voxel\get_icon_markup( $this->get_settings_for_display('ts_upload_ico') ) ?: \Voxel\svg( 'upload.svg' ) ?>
					<?= _x( 'Upload', 'file field', 'voxel' ) ?>
				</a>
			</div>
		</div>
		<input ref="input" type="file" class="hidden" :multiple="field.props.maxCount > 1" :accept="accepts">
	</div>
</script>
