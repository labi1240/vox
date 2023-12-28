<script type="text/html" id="dtags-content-editor">
	<div class="dtags-container">



			<div class="dtags-content min-scroll">
				<div
					ref="editor"
					v-if="mode === 'visual'"
					v-html="$root.formatAsHTML($root.escapeContent($root.content))"
					class="dynamic-editor"
					:class="previewClass"
					@copy="onCopy($event)"
					@paste="onPaste($event)"
					@blur="save"
					contenteditable="true"
				></div>

				<p
					v-if="mode === 'visual'"
					@click.prevent="$root.showAvailableFields"
					class="editor-placeholder"
				>
					Add dynamic content here
				</p>

				<template v-if="mode === 'plain'">
					<textarea style="resize: none;"
						v-model="$root.content"
						rows="4"
						class="min-scroll"
						placeholder="Type content here..."
					></textarea>
				</template>
			</div>

			<div class="dtags-container-head">
				<p class="help-tip">
					Tip: You can click on an added tag to view its options
				</p>
				<a href="#" @click.prevent="mode = (mode==='plain'?'visual':'plain')">
					{{ mode === 'plain' ? 'Voxelscript' : 'Visual' }}
				</a>
			</div>


	</div>
</script>