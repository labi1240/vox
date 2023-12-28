<script type="text/html" id="create-post-select-field">
	<template v-if="field.props.display_as === 'inline'">
		<div class="ts-form-group inline-terms-wrapper ts-inline-filter">
			<label>
				{{ field.label }}
				<slot name="errors"></slot>
				<small>{{ field.description }}</small>
			</label>
			<div class="ts-term-dropdown ts-md-group ts-multilevel-dropdown inline-multilevel min-scroll">
				<ul class="simplify-ul ts-term-dropdown-list">
					<li v-for="choice in field.props.choices" :class="{'ts-selected': choice.value === value}">
						<a href="#" class="flexify" @click.prevent="value = ( choice.value === value ? null : choice.value ); onSave();">
							<div class="ts-radio-container">
								<label class="container-radio">
									<input
										type="radio"
										:value="choice.value"
										:checked="value === choice.value"
										disabled
										hidden
									>
									<span class="checkmark"></span>
								</label>
							</div>
							<span>{{ choice.label }}</span>
							<div class="ts-term-icon">
								<span v-html="choice.icon"></span>
							</div>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</template>
	<form-group v-else wrapper-class="prmr-popup" :popup-key="field.id+':'+index" ref="formGroup" @save="onSave" @blur="saveValue" @clear="onClear">
		<template #trigger>
			<label>
				{{ field.label }}
				<slot name="errors"></slot>
				<small>{{ field.description }}</small>
			</label>
			<div class="ts-filter ts-popup-target" :class="{'ts-filled': field.value !== null}" @mousedown="$root.activePopup = field.id+':'+index">
				<?= \Voxel\get_icon_markup( $this->get_settings_for_display('ts_list_icon') ) ?: \Voxel\svg( 'menu.svg' ) ?>
				<div class="ts-filter-text">
					<span>{{ field.props.choices[ field.value ] ? field.props.choices[ field.value ].label : field.props.placeholder }}</span>
				</div>
			</div>
		</template>
		<template #popup>
			<div class="ts-term-dropdown ts-md-group ts-multilevel-dropdown">
				<ul class="simplify-ul ts-term-dropdown-list min-scroll">
					<li v-for="choice in field.props.choices" :class="{'ts-selected': choice.value === value}">
						<a href="#" class="flexify" @click.prevent="value = choice.value; onSave();">
							<div class="ts-radio-container">
								<label class="container-radio">
									<input
										type="radio"
										:value="choice.value"
										:checked="value === choice.value"
										disabled
										hidden
									>
									<span class="checkmark"></span>
								</label>
							</div>
							<span>{{ choice.label }}</span>
							<div class="ts-term-icon">
								<span v-html="choice.icon"></span>
							</div>
						</a>
					</li>
				</ul>
			</div>
		</template>
	</form-group>
</script>
