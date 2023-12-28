<?php
if ( ! defined('ABSPATH') ) {
	exit;
} ?>
<template v-for="addition in custom_additions">
	<template v-if="addition.mode === 'single'">
		<div class="ts-form-group ts-custom-additions">
			<label>{{ addition.label }}</label>
			<ul class="simplify-ul ts-addition-list flexify">
				<template v-for="item in addition.items">
					<li class="flexify" >

						<div class="addition-body" @click.prevent="pickSingleItem(addition, item)">
							<label class="container-radio">
								<input
									:checked="!!item.value" type="checkbox" class="onoffswitch-checkbox"
								>
								<span class="checkmark"></span>
							</label>
							<span>{{ item.label }}</span>
						</div>

						<div class="ts-stepper-input flexify custom-addon-stepper"  v-if="item.has_quantity && item.value">
							<button class="ts-stepper-left ts-icon-btn" @click.prevent="decrement(item)">
								<?= \Voxel\get_icon_markup( $this->get_settings_for_display('ts_minus_icon') ) ?: \Voxel\svg( 'minus.svg' ) ?>
							</button>
							<input
								v-model="item.value"
								type="number"
								class="ts-input-box"
								@change="validateValueInBounds(item)"
							>
							<button class="ts-stepper-right ts-icon-btn" @click.prevent="increment(item)">
								<?= \Voxel\get_icon_markup( $this->get_settings_for_display('ts_plus_icon') ) ?: \Voxel\svg( 'plus.svg' ) ?>
							</button>
						</div>
					</li>
				</template>
			</ul>
		</div>
	</template>
	<template v-else>
		<div class="ts-form-group ts-custom-additions">
			<label>{{ addition.label }}</label>
			<ul class="simplify-ul ts-addition-list flexify">
				<template v-for="item in addition.items">
					<li class="flexify">
						<div class="addition-body" @click.prevent="pickMultipleItem(addition, item)">
							<label class="container-checkbox">
								<input
									:checked="!!item.value" type="checkbox" class="onoffswitch-checkbox"
								>
								<span class="checkmark"></span>
							</label>
							<span>{{ item.label }}</span>
						</div>

						<div v-if="item.has_quantity && item.value" class="ts-stepper-input flexify custom-addon-stepper">
							<button class="ts-stepper-left ts-icon-btn" @click.prevent="decrement(item)">
								<?= \Voxel\get_icon_markup( $this->get_settings_for_display('ts_minus_icon') ) ?: \Voxel\svg( 'minus.svg' ) ?>
							</button>
							<input
								v-model="item.value"
								type="number"
								class="ts-input-box"
								@change="validateValueInBounds(item)"
							>
							<button class="ts-stepper-right ts-icon-btn" @click.prevent="increment(item)">
								<?= \Voxel\get_icon_markup( $this->get_settings_for_display('ts_plus_icon') ) ?: \Voxel\svg( 'plus.svg' ) ?>
							</button>
						</div>
					</li>
				</template>
			</ul>
		</div>
	</template>
</template>
