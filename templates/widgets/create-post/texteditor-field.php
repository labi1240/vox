<script type="text/html" id="create-post-texteditor-field">
	<div v-if="field.props.editorType === 'plain-text'" class="ts-form-group">
		<label>
			{{ field.label }}
			<template v-if="field.validation.errors.length >= 1">
				<span class="is-required">{{ field.validation.errors[0] }}</span>
			</template>
			<template v-else>
				<span v-if="!field.required && content_length === 0" class="is-required"><?= _x( 'Optional', 'create post', 'voxel' ) ?></span>
				<span v-if="field.props.maxlength && content_length > 0" class="is-required ts-char-counter">{{ content_length }}/{{ field.props.maxlength }}</span>
			</template>
			<small>{{ field.description }}</small>
		</label>
		<textarea
			ref="composer"
			:value="field.value"
			@input="field.value = $event.target.value; resizeComposer();"
			:placeholder="field.props.placeholder"
			class="ts-filter"
		></textarea>
	</div>
	<div v-else class="ts-form-group">
		<label>
			{{ field.label }}
			<template v-if="field.validation.errors.length >= 1">
				<span class="is-required">{{ field.validation.errors[0] }}</span>
			</template>
			<template v-else>
				<span v-if="!field.required && content_length === 0" class="is-required"><?= _x( 'Optional', 'create post', 'voxel' ) ?></span>
				<span v-if="field.props.maxlength && content_length > 0" class="is-required ts-char-counter">{{ content_length }}/{{ field.props.maxlength }}</span>
			</template>
			<small>{{ field.description }}</small>
		</label>
		<div ref="toolbar" class="toolbar-container" :id="field.props.toolbarId"></div>
		<div ref="editor" class="editor-container mce-content-body" :id="field.props.editorId"></div>
	</div>
</script>
