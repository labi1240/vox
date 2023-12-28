<?php
if ( ! defined('ABSPATH') ) {
	exit;
} ?>
<template v-for="addition in additions">
	<div v-if="addition.type === 'numeric'" class="ts-form-group">
		<label>{{ addition.label }}</label>
		<div class="ts-stepper-input flexify">
			<button class="ts-stepper-left ts-icon-btn" @click.prevent="decrement(addition)">
				<?= \Voxel\get_icon_markup( $this->get_settings_for_display('ts_minus_icon') ) ?: \Voxel\svg( 'minus.svg' ) ?>
			</button>
			<input
				v-model="addition.value"
				type="number"
				class="ts-input-box"
				@change="validateValueInBounds(addition)"
			>
			<button class="ts-stepper-right ts-icon-btn" @click.prevent="increment(addition)">
				<?= \Voxel\get_icon_markup( $this->get_settings_for_display('ts_plus_icon') ) ?: \Voxel\svg( 'plus.svg' ) ?>
			</button>
		</div>
	</div>
	<div v-if="addition.type === 'checkbox'" class="ts-form-group switcher-addition">
		<label>{{ addition.label }}</label>
		<div class="switch-slider">
			<div class="onoffswitch">
				<input v-model="addition.value" type="checkbox" class="onoffswitch-checkbox">
				<label class="onoffswitch-label" @click.prevent="addition.value = !addition.value"></label>
			</div>
		</div>

	</div>
	<template v-if="addition.type === 'select'">
		<form-group
			v-if="Object.keys(addition.choices).length"
			:popup-key="addition.key"
			:ref="'select-'+addition.key"
			@save="$refs['select-'+addition.key].blur()"
			@clear="addition.value = null"
			:show-clear="!addition.required"
		>
			<template #trigger>
				<label>{{ addition.label }}</label>
				<div class="ts-filter ts-popup-target" :class="{'ts-filled': addition.value !== null}" @mousedown="$root.activePopup = addition.key">
					<span><?= \Voxel\get_icon_markup( $this->get_settings_for_display('ts_addition_ico') ) ?: \Voxel\svg( 'menu.svg' ) ?></span>
					<div class="ts-filter-text">
						<span>{{ addition.choices[addition.value] ? addition.choices[addition.value].label : addition.placeholder }}</span>
					</div>
					<div class="ts-down-icon"></div>
				</div>
			</template>
			<template #popup>
				<div class="ts-term-dropdown ts-md-group ts-multilevel-dropdown">
					<ul class="simplify-ul ts-term-dropdown-list min-scroll">
						<template v-for="choice, choice_value in addition.choices">
							<li>
								<a href="#" class="flexify" @click.prevent="addition.value = choice_value; $refs['select-'+addition.key].blur();">

									<div class="ts-radio-container">
										<label class="container-radio">
											<input
												type="radio"
												:value="choice_value"
												:checked="addition.value === choice_value"
												disabled
												hidden
											>
											<span class="checkmark"></span>
										</label>
									</div>
									<span>{{ choice.label }}</span>
									<div class="ts-term-icon">
										<span v-if="choice.icon" v-html="choice.icon"></span>
									</div>
								</a>
							</li>
						</template>
					</ul>
				</div>
			</template>
		</form-group>
	</template>
</template>
