<script type="text/html" id="create-post-repeater-field">
	<div class="ts-form-group ts-repeater" ref="container">
		<label>
			{{ field.label }}
			<slot name="errors"></slot>
			<small>{{ field.description }}</small>
		</label>
		<div class="ts-repeater-container" ref="list">
			<div v-for="row, row_index in rows" class="ts-field-repeater" :class="{collapsed: row['meta:state'].collapsed}" :data-index="row_index" :key="row['meta:state'].id">
				<div class="ts-repeater-head">
					<label>
						<?= \Voxel\get_icon_markup( $this->get_settings_for_display('ts_list_icon') ) ?: \Voxel\svg( 'menu.svg' ) ?>
						{{ row['meta:state'].label }}
						<span class="ts-row-error" style="display: none;"></span>
					</label>
					<div class="ts-repeater-controller">
						<a href="#" @click.prevent="deleteRow(row)" class="ts-icon-btn ts-smaller">
							<?= \Voxel\get_icon_markup( $this->get_settings_for_display('trash_icon') ) ?: \Voxel\svg( 'trash-can.svg' ) ?>
						</a>
						<a href="#" class="ts-icon-btn ts-smaller" @click.prevent="row['meta:state'].collapsed = !row['meta:state'].collapsed">
							<?= \Voxel\get_icon_markup( $this->get_settings_for_display('down_icon') ) ?: \Voxel\svg( 'chevron-down.svg' ) ?>
						</a>
					</div>
				</div>
				<div class="elementor-row medium form-field-grid">
					<template v-if="field.props.additions.enabled">
						<div class="ts-double-input flexify force-equal">
							<div class="ts-form-group">
								<label><?= _x( 'Label', 'repeater field', 'voxel' ) ?></label>
								<div class="input-container">
									<input type="text" placeholder="<?= esc_attr( _x( 'Item label', 'repeater field', 'voxel' ) ) ?>" class="ts-filter" v-model="row['meta:additions'].label">
								</div>
							</div>
							<div class="ts-form-group">
								<label><?= _x( 'Price', 'repeater field', 'voxel' ) ?></label>
								<div class="input-container">
									<input type="number" placeholder="<?= esc_attr( _x( 'Item price', 'repeater field', 'voxel' ) ) ?>" class="ts-filter" v-model="row['meta:additions'].price" min="0">
									<span class="input-suffix"><?= \Voxel\get('settings.stripe.currency') ?></span>
								</div>
							</div>
						</div>
						<template v-if="field.props.additions.allow_quantity">
							<div class="ts-form-group">
								<label>
									<?= _x( 'Enable quantity', 'repeater field', 'voxel' ) ?>
									<small><?= _x( 'Allows customer to purchase this item multiple times with a single order', 'repeater field', 'voxel' ) ?></small>
								</label>
								<div class="switch-slider">
									<div class="onoffswitch">
										<input type="checkbox" class="onoffswitch-checkbox" v-model="row['meta:additions'].has_quantity">
										<label class="onoffswitch-label" @click.prevent="row['meta:additions'].has_quantity = !row['meta:additions'].has_quantity"></label>
									</div>
								</div>
							</div>
							<div v-if="row['meta:additions'].has_quantity" class="ts-double-input flexify product-units force-equal">
								<div class="ts-form-group">
									<div class="input-container">
										<input
											type="number"
											v-model="row['meta:additions'].min"
											class="ts-filter"
											placeholder="<?= esc_attr( _x( 'Minimum', 'repeater field', 'voxel' ) ) ?>"
											min="0"
										>
										<span class="input-suffix"><?= _x( 'Min units', 'repeater field', 'voxel' ) ?></span>
									</div>
								</div>
								<div class="ts-form-group">
									<div class="input-container">
										<input
											type="number"
											v-model="row['meta:additions'].max"
											class="ts-filter"
											placeholder="<?= esc_attr( _x( 'Maximum', 'repeater field', 'voxel' ) ) ?>"
											min="0"
										>
										<span class="input-suffix"><?= _x( 'Max units', 'repeater field', 'voxel' ) ?></span>
									</div>
								</div>
							</div>
						</template>
						<template v-if="field.props.additions.mode === 'multiple' && field.props.additions.repeatable">
							<div class="ts-form-group">
								<label>
									<?= _x( 'Apply pricing to each day in booked day range', 'repeater field', 'voxel' ) ?>
								</label>
								<div class="switch-slider">
									<div class="onoffswitch">
										<input type="checkbox" class="onoffswitch-checkbox" v-model="row['meta:additions'].repeat">
										<label class="onoffswitch-label" @click.prevent="row['meta:additions'].repeat = !row['meta:additions'].repeat"></label>
									</div>
								</div>
							</div>
						</template>
						<template v-if="field.props.additions.mode === 'multiple'">
							<div class="ts-form-group">
								<label>
									<?= _x( 'Is required?', 'repeater field', 'voxel' ) ?>
								</label>
								<div class="switch-slider">
									<div class="onoffswitch">
										<input type="checkbox" class="onoffswitch-checkbox" v-model="row['meta:additions'].required">
										<label class="onoffswitch-label" @click.prevent="row['meta:additions'].required = !row['meta:additions'].required"></label>
									</div>
								</div>
							</div>
						</template>
					</template>
					<template v-for="subfield in row">
						<template v-if="subfield.key !== 'meta:additions' && subfield.key !== 'meta:state'">
							<component
								:field="subfield"
								:is="'field-'+subfield.type"
								:ref="'row#'+row['meta:state'].id+':'+subfield.key"
								:index="row['meta:state'].id"
								:key="row['meta:state'].id"
								v-if="$root.conditionsPass(subfield)"
								:class="[subfield.validation.errors.length >= 1 ? 'ts-has-errors' : '']"
							>
								<template #errors>
									<template v-if="subfield.validation.errors.length >= 1">
										<span class="is-required">{{ subfield.validation.errors[0] }}</span>
									</template>
									<template v-else>
										<span v-if="!subfield.required" class="is-required"><?= _x( 'Optional', 'create post', 'voxel' ) ?></span>
									</template>
								</template>
							</component>

							<?php if ( \Voxel\is_dev_mode() ): ?>
								<!-- <p style="text-align: right;" v-if="$root.conditionsPass(subfield)">
									<a href="#" @click.prevent="validate_subfield(subfield.key, row['meta:state'].id)">Check validity</a>
								</p> -->
							<?php endif ?>
						</template>
					</template>
				</div>
			</div>
		</div>

		<a
			v-if="!field.props.max_rows || rows.length < field.props.max_rows"
			href="#"
			class="ts-repeater-add ts-btn ts-btn-3"
			@click.prevent="addRow"
		>
			<?= \Voxel\get_icon_markup( $this->get_settings_for_display('ts_add_icon') ) ?: \Voxel\svg( 'plus.svg' ) ?>
			{{ field.props.l10n.add_row }}
		</a>
	</div>
</script>
