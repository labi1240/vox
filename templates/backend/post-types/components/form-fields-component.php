<?php
/**
 * Post fields - component template.
 *
 * @since 1.0
 */
if ( ! defined('ABSPATH') ) {
	exit;
} ?>
<script type="text/html" id="post-type-fields-template">
	<div class="ts-tab-content">
		<div class="x-row">
			<div class="x-col-12 ts-content-head">
				<h1>Fields</h1>
				<p>Create and manage fields for this post type</p>
			</div>
		</div>
		<div class="x-row">
			<div class="used-fields x-col-6">
				<div class="sub-heading">
					<p>Used fields</p>
				</div>
				<div class="field-container" ref="fields-container">
					<field-list-item
						:field="$root.config.fields[0]"
						:show-delete="false"
						@click:edit="toggleActive( $root.config.fields[0] )"
						@click:delete="deleteField( $root.config.fields[0] )"
					></field-list-item>

					<draggable
						v-model="$root.config.fields"
						group="fields"
						handle=".field-head"
						item-key="key"
						@start="dragStart"
						@end="dragEnd"
					>
						<template #item="{element: field, index: index}">
							<field-list-item
								v-if="index !== 0"
								:field="field"
								:show-delete="true"
								@click:edit="toggleActive(field)"
								@click:delete="deleteField(field)"
							></field-list-item>
						</template>
					</draggable>
				</div>
			</div>
			<div class="x-col-1"></div>
			<div class="x-col-5">
				<div class="sub-heading">
					<p>Available fields</p>
				</div>

				<div class="ts-form-group mb20">
					<input v-model="search" type="text" placeholder="Search fields">
				</div>

				<ul v-if="!search.trim().length" class="inner-tabs">
					<li :class="{'current-item': active_set === 'presets'}">
						<a @click.prevent="active_set = 'presets'" href="#">Presets</a>
					</li>
					<li :class="{'current-item': active_set === 'custom'}">
						<a @click.prevent="active_set = 'custom'" href="#">Custom fields</a>
					</li>
					<li :class="{'current-item': active_set === 'ui'}">
						<a @click.prevent="active_set = 'ui'" href="#">Layout</a>
					</li>
				</ul>

				<div class="available-fields-container min-scroll">
					<template v-if="search.trim().length">
						<template v-if="search_results.presets.length || search_results.field_types.length">
							<div class="add-field">
								<template v-for="preset in search_results.presets">
									<div :class="{'vx-disabled': !canAddPreset(preset)}">
										<div @click.prevent="addField(preset)" class="ts-button ts-outline">
											{{ preset.label }} (Preset)
										</div>
									</div>
								</template>
								<template v-for="field_type in search_results.field_types">
									<div v-if="!field_type.singular">
										<div @click.prevent="addField(field_type)" class="ts-button ts-outline">
											{{ field_type.label }}
										</div>
									</div>
								</template>
							</div>
						</template>
					</template>
					<template v-else-if="active_set === 'presets'">
						<div class="add-field">
							<template v-for="preset in field_presets">
								<div :class="{'vx-disabled': !canAddPreset(preset)}">
									<div @click.prevent="addField(preset)" class="ts-button ts-outline">
										{{ preset.label }}
									</div>
								</div>
							</template>
						</div>
					</template>
					<template v-else-if="active_set === 'custom'">
						<div class="add-field">
							<template v-for="field_type in field_types">
								<div v-if="!field_type.singular && !$root.options.is_ui[field_type.type]">
									<div @click.prevent="addField(field_type)" class="ts-button ts-outline">
										{{ field_type.label }}
									</div>
								</div>
							</template>
						</div>
					</template>
					<template v-else-if="active_set === 'ui'">
						<div class="add-field">
							<template v-for="field_type in field_types">
								<div v-if="!field_type.singular && $root.options.is_ui[field_type.type]">
									<div @click.prevent="addField(field_type)" class="ts-button ts-outline">
										{{ field_type.label }}
									</div>
								</div>
							</template>
						</div>
					</template>
				</div>
			</div>
		</div>
	</div>




	<field-modal v-if="active" :field="active"></field-modal>
</script>

<script type="text/html" id="post-type-field-list-item">
	<div class="single-field wide" :class="{'ts-form-step': field.type === 'ui-step'}">
		<div class="field-head" @click="$emit('click:edit')">

			<p class="field-name">{{ field.label }}</p>
			<span class="field-type">{{ field.type }}</span>
			<div class="field-actions">
				<span class="type-2 field-action all-center" v-if="field['enable-conditions']">
					<a href="#" title="Conditional logic is enabled for this field">
						<i class="las la-code-branch icon-sm"></i>
					</a>
				</span>
			<span class="type-2 field-action all-center" v-if="field.visibility_rules.length">
					<a href="#" title="This field has visibility rules">
						<i class="las la-user-lock"></i>
					</a>
				</span>
				<span class="field-action all-center" v-if="showDelete" @click.stop.prevent="$emit('click:delete')">

						<i class="lar la-trash-alt icon-sm"></i>

				</span>
			</div>
		</div>
	</div>
</script>
