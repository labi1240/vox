<?php
if ( ! defined('ABSPATH') ) {
	exit;
}

require_once locate_template( 'templates/backend/templates/_base-template-options.php' );
?>
<div id="vx-template-manager" data-config="<?= esc_attr( wp_json_encode( $config ) ) ?>" v-cloak>

	<div class="sticky-top">
		<div class="vx-head x-container">
			<h2>General templates</h2>
		</div>
	</div>

	<div class="ts-spacer"></div>

	<div class="x-container">
		<div class="x-row">
			<div class="x-col-12">
				<ul class="inner-tabs inner-tabs">

					<li :class="{'current-item': tab === 'membership'}">
						<a href="#" @click.prevent="setTab('membership')">Membership</a>
					</li>
					<li :class="{'current-item': tab === 'orders'}">
						<a href="#" @click.prevent="setTab('orders')">Orders</a>
					</li>
					<li :class="{'current-item': tab === 'social'}">
						<a href="#" @click.prevent="setTab('social')">Social</a>
					</li>
					<li :class="{'current-item': tab === 'general'}">
						<a href="#" @click.prevent="setTab('general')">Other</a>
					</li>
					<li :class="{'current-item': tab === 'style_kits'}">
						<a href="#" @click.prevent="setTab('style_kits')">Style kits</a>
					</li>
				</ul>
			</div>
			<div class="x-col-12 x-templates">

				<template v-for="template in config.templates">
					<div v-if="tab === template.category" class="x-template">

						<template v-if="template.id">
							<div class="xt-info">
								<h3>{{ template.label }}</h3>
							</div>
							<div class="xt-actions">
								<a :href="previewLink(template.id)" target="_blank" class="ts-button ts-outline icon-only">
									<i class="las la-eye "></i>
								</a>
								<a href="#" @click.prevent="template.editSettings = true" class="ts-button ts-outline icon-only">
									<i class="las la-ellipsis-h "></i>
								</a>
								<a class="ts-button ts-outline icon-only" @click.prevent="deleteTemplate(template)"><i class="las la-trash"></i></a>
								<a :href="editLink(template.id)" target="_blank" class="ts-button ts-outline">Edit template</a>
							</div>
						</template>
						<template v-else class="x-template">
							<div class="xt-info">
								<h3>{{ template.label }}</h3>
							</div>
							<div class="xt-actions">
								<a class="ts-button ts-outline" @click.prevent="createTemplate(template)">Create</a>
							</div>
						</template>

						<base-template-options v-if="template.editSettings" :template="template"></base-template-options>
					</div>
					
				</template>

			</div>
		</div>
		<div class="x-row" v-cloak>

		</div>
	</div>
</div>

<script type="text/html" id="template-manager-popup">
	<teleport to="body">
		<div class="ts-field-modal ts-theme-options">
			<div class="modal-backdrop" @click="template.editSettings = false"></div>
			<div class="modal-content min-scroll">
				<div class="x-container">
					<div class="field-modal-head">
						<h2>Template options</h2>
						<a href="#" @click.prevent="template.editSettings = false" class="ts-button btn-shadow">
							<i class="las la-check icon-sm"></i>Done
						</a>
					</div>
					<div class="ts-field-props">
						<div class="field-modal-body">
							<div class="x-row">
								<div v-if="modifyId" class="ts-form-group x-col-12" :class="{'vx-disabled': updating}">
									<label>{{ template.type === 'page' ? 'Enter new page template id' : 'Enter new template id' }}</label>
									<input type="number" v-model="newId">

									<br><br>
									<div class="x-row">
										<div class="x-col-12">
											<a href="#" @click.prevent="modifyId = false" class="ts-button ts-outline ">Cancel</a>
											&nbsp;
											<a href="#" @click.prevent="saveId" class="ts-button ts-save-settings ">Submit</a>
										</div>
									</div>

								</div>
								<div v-else class="ts-form-group x-col-12">
									<label>Template ID</label>
									<input type="number" disabled v-model="template.id">

									<br><br>
									<div class="x-row">
										<div class="x-col-12">
											<a href="#" @click.prevent="modifyId = true" class="ts-button ts-outline">Switch template</a>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</teleport>
</script>
