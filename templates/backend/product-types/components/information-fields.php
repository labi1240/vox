<script type="text/html" id="product-type-fields-template">



				<div class="x-col-12 ts-content-head">
					<h1>Checkout fields</h1>
					<p>Checkout fields are used to gather information from the client. They don't affect the price</p>
				</div>


				<div class="used-fields x-col-6">
					<div class="sub-heading">
						<p>Used fields</p>
					</div>
					<div class="field-container" ref="fields-container">
						<draggable
							v-model="$root.config.fields"
							group="fields"
							handle=".field-head"
							item-key="key"
							@start="dragStart"
							@end="dragEnd"
						>
							<template #item="{element: field}">
								<div class="single-field wide">
									<div class="field-head" @click="active = field">
										<p class="field-name">{{ field.label }}</p>
										<span class="field-type">{{ field.type }}</span>
										<div class="field-actions">
											<span class="field-action all-center">
												<a href="#" @click.stop.prevent="deleteField(field)">
													<i class="lar la-trash-alt icon-sm"></i>
												</a>
											</span>
										</div>
									</div>
								</div>
							</template>
						</draggable>
					</div>
				</div>
				<div class="x-col-1"></div>
				<div class="x-col-5">
					<div class="available-fields-container">
						<div class="sub-heading">
							<p>Available fields</p>
						</div>

						<div class="add-field">
							<template v-for="field_type in field_types">

									<div @click.prevent="addField(field_type)" class="ts-button ts-outline">
										<p class="field-name">{{ field_type.type }}</p>

									</div>

							</template>
						</div>
					</div>
				</div>




		
		


	<field-modal v-if="active" :field="active"></field-modal>
</script>

<script type="text/html" id="product-type-field-modal-template">
	<teleport to="body">
		<div class="ts-field-modal ts-theme-options">
			<div class="modal-backdrop" @click="save"></div>
			<div class="modal-content min-scroll">
				<div class="x-container">
					<div class="field-modal-head">
						<h2>Field options</h2>
						<a href="#" @click.prevent="save" class="ts-button btn-shadow">
							<i class="las la-check icon-sm"></i>Save
						</a>
					</div>

					<div class="field-modal-body">
						<div class="x-row">
							<?= $field_options_markup ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</teleport>
</script>
