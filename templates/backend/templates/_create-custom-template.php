<?php
if ( ! defined('ABSPATH') ) {
	exit;
} ?>
<script type="text/html" id="ts-create-custom-template">
	<teleport to="body">
		<div class="ts-field-modal ts-theme-options">
			<div class="modal-backdrop" @click="$root.config.editTemplate = false"></div>
			<div class="modal-content min-scroll">
				<div class="x-container">
					<div class="field-modal-head">
						<h3>Create component</h3>
						<div>
							<a class="ts-button ts-outline" href="#" @click.prevent="$root.config.editTemplate = false; $root.config.editTemplateType = ''">Discard</a>
							&nbsp;
							<a href="#" @click.prevent="saveId" class="ts-button btn-shadow ts-save-settings" :class="{'ts-saving': updating}">
								<i class="las la-check icon-sm"></i>Done
							</a>
						</div>
					</div>
					<div class="ts-field-props">
						<div class="field-modal-body">
							<div class="x-row">
								<div class="ts-form-group x-col-12">
									<label>Label</label>
									<input type="text" placeholder="Label" v-model="label">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</teleport>
</script>
