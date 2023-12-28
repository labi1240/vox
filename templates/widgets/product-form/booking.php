<?php
if ( ! defined('ABSPATH') ) {
	exit;
} ?>
<?php if ( $product_type->get_product_mode() === 'booking' ): ?>
	<?php if ( $product_type->config( 'calendar.type' ) === 'booking' ): ?>
		<?php if ( $product_type->config( 'calendar.format' ) === 'days' && $product_type->config( 'calendar.allow_range' ) ): ?>
			<form-group popup-key="datePicker" ref="datePicker" @save="onSaveCalendar" @blur="saveCalendar" @clear="resetPicker" wrapper-class="ts-booking-range-wrapper">
				<template #trigger>
					<label><?= _x( 'Pick day', 'product form', 'voxel' ) ?></label>
					<div class="ts-double-input flexify force-equal">
						<div class="ts-filter ts-popup-target" :class="{'ts-filled':booking.checkIn}" @mousedown="$root.activePopup = 'datePicker'">
							<?= \Voxel\get_icon_markup( $this->get_settings_for_display('ts_calendar_icon') ) ?: \Voxel\svg( 'calendar.svg' ) ?>
							<div class="ts-filter-text">{{ checkInLabel }}</div>
							<div class="ts-down-icon"></div>
						</div>

						<div class="ts-filter ts-popup-target" :class="{'ts-filled':booking.checkOut}" @mousedown="$root.activePopup = 'datePicker'">
							<?= \Voxel\get_icon_markup( $this->get_settings_for_display('ts_calendar_icon') ) ?: \Voxel\svg( 'calendar.svg' ) ?>
							<div class="ts-filter-text">{{ checkOutLabel }}</div>
							<div class="ts-down-icon"></div>
						</div>
					</div>
				</template>
				<template #popup>
					<date-range-picker ref="picker" :parent="this"></date-range-picker>
				</template>
			</form-group>
		<?php else: ?>
			<form-group popup-key="datePicker" ref="datePicker" @save="onSaveCalendar" @blur="saveCalendar" @clear="resetPicker" wrapper-class="ts-booking-date-wrapper">
				<template #trigger>
					<label><?= _x( 'Pick day', 'product form', 'voxel' ) ?></label>
					<div class="ts-filter ts-popup-target" :class="{'ts-filled':booking.checkIn}" @mousedown="$root.activePopup = 'datePicker'">
						<?= \Voxel\get_icon_markup( $this->get_settings_for_display('ts_calendar_icon') ) ?: \Voxel\svg( 'calendar.svg' ) ?>
						<div class="ts-filter-text">{{ pickDateLabel }}</div>
					</div>
				</template>
				<template #popup>
					<date-picker ref="picker" :parent="this"></date-picker>
				</template>
			</form-group>
		<?php endif ?>

		<?php if ( $product_type->config( 'calendar.format' ) === 'slots' ): ?>
			<div v-if="timeslots" class="ts-form-group">
				<label><?= _x( 'Pick slot', 'product form', 'voxel' ) ?></label>
				<ul class="ts-pick-slot simplify-ul">
					<li v-for="slot in timeslots" :class="{'slot-picked': slot === booking.timeslot, 'vx-disabled': config.calendar.excluded_slots[getSlotKey( slot )]}">
						<a href="#" @click.prevent="booking.timeslot = slot">
							<span>{{ getSlotLabel(slot) }}</span>
						</a>
					</li>
				</ul>
			</div>
		<?php endif ?>
	<?php elseif ( $product_type->config( 'calendar.type' ) === 'recurring-date' ): ?>
		<div class="ts-form-group">
			<label><?= _x( 'Upcoming dates', 'product form', 'voxel' ) ?></label>
			<ul v-if="config.recurring_date.bookable.length" class="ts-pick-slot simplify-ul">
				<li
					v-for="date in config.recurring_date.bookable"
					:class="{'slot-picked': booking.checkIn === date.start && booking.checkOut === date.end}"
					@click.prevent="booking.checkIn = date.start; booking.checkOut = date.end"
				>
					<a href="#">
						<?= \Voxel\get_icon_markup( $this->get_settings_for_display('ts_select_icon') ) ?: \Voxel\svg( 'circle-plus.svg' ) ?>
						<span>{{ date.formatted }}</span>
					</a>
				</li>
			</ul>
			<small v-else><?= _x( 'No bookable dates', 'product form', 'voxel' ) ?></small>
		</div>
	<?php endif ?>
<?php endif ?>