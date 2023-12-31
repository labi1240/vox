<?php
/**
 * Edit product type additions in WP Admin.
 *
 * @since 1.0
 */
if ( ! defined('ABSPATH') ) {
	exit;
} ?>
<script type="text/html" id="product-type-additions-template">




		<div class="x-col-12 ts-content-head">
			<h1>Additions</h1>
			<p>Create pre-defined product additions that can affect the price of the product.
			</p>
		</div>



		<div class="used-fields x-col-6">
			<div class="sub-heading">
				<p>Used additions</p>
			</div>
			<div class="field-container" ref="fields-container">
				<draggable
					v-model="$root.config.additions"
					group="additions"
					handle=".field-head"
					item-key="key"
					@start="dragStart"
					@end="dragEnd"
				>
					<template #item="{element: addition}">
						<div class="single-field wide">
							<div class="field-head" @click="toggleActive(addition)">
								<p class="field-name">{{ addition.label }}</p>
								<span class="field-type">{{ addition.type }}</span>
								<div class="field-actions">
									<span class="field-action all-center">
										<a href="#" @click.stop.prevent="deleteAddition(addition)">
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
			<div class="sub-heading">
				<p>Create addition</p>
			</div>
			<div class="add-field">

					<template v-for="addition_type in $root.options.addition_types">
						<div class="">
							<div @click.prevent="insertAddition(addition_type)" class="ts-button ts-outline">
								<p class="field-name">{{ addition_type.type }}</p>

							</div>
						</div>
					</template>

			</div>
		</div>






	<addition-modal v-if="active" :addition="active"></addition-modal>
</script>

<script type="text/html" id="product-type-addition-modal-template">
	<teleport to="body">
		<div class="ts-field-modal ts-theme-options">

			<div class="modal-backdrop" @click="save"></div>
			<div class="modal-content min-scroll">
				<div class="x-container">
					<div class="field-modal-head">
						<h2>Addition options</h2>
						<a href="#" @click.prevent="save" class="ts-button btn-shadow"><i class="las la-check icon-sm"></i>Save</a>
					</div>

					<div class="field-modal-body">
						<div class="x-row">
							<?= $addition_options_markup ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</teleport>
</script>
