<script type="text/html" id="product-form-date-range-picker">
	<div class="ts-popup-head flexify">
		<div class="ts-popup-name flexify">
			<?= \Voxel\get_icon_markup( $this->get_settings_for_display('ts_calendar_icon') ) ?: \Voxel\svg( 'calendar.svg' ) ?>
			<span>
				<span :class="{chosen: activePicker === 'start'}" @click.prevent="activePicker = 'start'">
					{{ startLabel }}
				</span>
				<span v-if="startDate"> &mdash; </span>
				<span v-if="startDate" :class="{chosen: activePicker === 'end'}" @click.prevent="activePicker = 'end'">
					{{ endLabel }}
				</span>
			</span>
		</div>
	</div>
	<div class="ts-booking-date ts-booking-date-range ts-form-group" ref="calendar">
		<input type="hidden" ref="input">
	</div>
</script>
