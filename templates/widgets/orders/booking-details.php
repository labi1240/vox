<script type="text/html" id="orders-booking-details">
	<template v-if="booking.type === 'date_range'">
		<div class="ts-order-card">
			<ul class="flexify simplify-ul">
				<li class="ts-card-icon">
					<?= \Voxel\get_icon_markup( $this->get_settings_for_display('ts_calendar_icon') ) ?: \Voxel\svg( 'calendar.svg' ) ?>
				</li>
				<li>
					<small><?= _x( 'Check-in', 'single order', 'voxel' ) ?></small>
					<span>{{ booking.from }}</span>
				</li>
				
			</ul>
		</div>
		<div class="ts-order-card">
			<ul class="flexify simplify-ul">
				<li class="ts-card-icon">
					<?= \Voxel\get_icon_markup( $this->get_settings_for_display('ts_calendar_icon') ) ?: \Voxel\svg( 'calendar.svg' ) ?>
				</li>
				<li>
					<small><?= _x( 'Check-out', 'single order', 'voxel' ) ?></small>
					<span>{{ booking.to }}</span>
				</li>
			</ul>
		</div>
	</template>
	<template v-else-if="booking.type === 'timeslot'">
		<div class="ts-order-card">
			<ul class="flexify simplify-ul">
				<li class="ts-card-icon">
					<?= \Voxel\get_icon_markup( $this->get_settings_for_display('ts_calendar_icon') ) ?: \Voxel\svg( 'calendar.svg' ) ?>
				</li>
				<li>
					<small><?= _x( 'Date', 'single order', 'voxel' ) ?></small>
					<span>{{ booking.date }}</span>
				</li>
				
			</ul>
		</div>
		<div class="ts-order-card">
			<ul class="flexify simplify-ul">
				<li class="ts-card-icon">
					<?= \Voxel\get_icon_markup( $this->get_settings_for_display('ts_clock_icon') ) ?: \Voxel\svg( 'clock.svg' ) ?>
				</li>
				<li>
					<small><?= _x( 'Timeslot', 'single order', 'voxel' ) ?></small>
					<span>{{ booking.from }} to {{ booking.to }}</span>
				</li>
				
			</ul>
		</div>
	</template>
	<template v-else>
		<div class="ts-order-card">
			<ul class="flexify simplify-ul">
				<li class="ts-card-icon">
					<?= \Voxel\get_icon_markup( $this->get_settings_for_display('ts_calendar_icon') ) ?: \Voxel\svg( 'calendar.svg' ) ?>
				</li>
				<li>
					<small><?= _x( 'Date', 'single order', 'voxel' ) ?></small>
					<span>{{ booking.date }}</span>
				</li>
			</ul>
		</div>
	</template>
</script>
