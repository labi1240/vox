<?php
if ( ! defined('ABSPATH') ) {
	exit;
} ?>
<div class="ts-form-group tcc-container">
	<ul class="ts-cost-calculator simplify-ul flexify">
		<li v-if="pricing.additions.length && pricing.base_price">
			<div class="ts-item-name">
				<p>
					<?= _x( 'Base price', 'product form', 'voxel' ) ?>
					<span v-if="repeatDayCount > 1">({{ repeatDayCount }} {{ config.calendar.range_mode === 'nights'
						? <?= wp_json_encode( _x( 'nights', 'product form', 'voxel' ) ) ?>
						: <?= wp_json_encode( _x( 'days', 'product form', 'voxel' ) ) ?>
					}})</span>
				</p>
			</div>
			<div class="ts-item-price">
				<p>{{ priceFormat( pricing.base_price ) }}</p>
			</div>
		</li>
		<template v-for="addition in pricing.additions">
			<li v-if="addition.price">
				<template v-if="addition.repeat && repeatDayCount > 1">
					<div class="ts-item-name">
						<p>{{ addition.label }} ({{ repeatDayCount }} {{ config.calendar.range_mode === 'nights'
							? <?= wp_json_encode( _x( 'nights', 'product form', 'voxel' ) ) ?>
							: <?= wp_json_encode( _x( 'days', 'product form', 'voxel' ) ) ?>
						}})</p>
					</div>
					<div class="ts-item-price">
						<p>{{ priceFormat( addition.price ) }}</p>
					</div>
				</template>
				<template v-else>
					<div class="ts-item-name">
						<p>{{ addition.label }}</p>
					</div>
					<div class="ts-item-price">
						<p>{{ priceFormat( addition.price ) }}</p>
					</div>
				</template>
			</li>
		</template>
		<!-- <li v-if="pricing.total > pricing.platform_fee" class="platform-fee">
			<div class="ts-item-name">
				<p>Platform fee</p>
			</div>
			<div class="ts-item-price">
				<p>{{ priceFormat( pricing.platform_fee ) }}</p>
			</div>
		</li> -->
		<li class="ts-total">
			<div class="item-name">
				<p><?= _x( 'Total', 'product form', 'voxel' ) ?></p>
			</div>
			<div class="item-price">
				<p>{{ priceFormat( pricing.total ) }}</p>
			</div>
		</li>
	</ul>
</div>
