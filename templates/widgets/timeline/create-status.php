<script type="text/html" id="timeline-create-status">
	<form-group
		:popup-key="popupKey"
		ref="popup"
		:save-label="status ? <?= esc_attr( wp_json_encode( _x( 'Update', 'timeline', 'voxel' ) ) ) ?> : <?= esc_attr( wp_json_encode( _x( 'Publish', 'timeline', 'voxel' ) ) ) ?>"
		clear-label="<?= esc_attr( _x( 'Cancel', 'timeline', 'voxel' ) ) ?>"
		prevent-blur=".ts-media-library"
		@save="publish"
		@clear="cancel"
		:show-clear-mobile="false"
		:wrapper-class="[pending ? 'status-pending popup-pending' : '', 'prmr-popup'].join(' ')"
	>
		<template #trigger>
			<div v-if="showTrigger" class="ts-filter ts-popup-target" @mousedown="$root.activePopup = popupKey" ref="submitInput">
				<slot></slot>
			</div>
		</template>
		<template #popup>
			<div class="ts-popup-head flexify ts-sticky-top">
				<div class="ts-popup-name flexify">
					<div v-html="$root.config.user.avatar"></div>
					<span>{{ $root.config.user.name }}</span>
				</div>
			</div>
			<div class="ts-compose-textarea">
				<textarea
					ref="composer"
					:value="message"
					@input="message = $event.target.value; resizeComposer();"
					placeholder="<?= esc_attr( _x( "What's on your mind?", 'timeline', 'voxel' ) ) ?>"
					class="autofocus"
					:maxlength="$root.config.postSubmission.maxlength"
				></textarea>
			</div>
			<template v-if="$root.mode === 'post_reviews' || ( status && status.is_review )">
				<template v-if="$root.getReviewConfig(status)?.input_mode === 'stars' || ( status && status.reviews.mode === 'stars' )">
					<div v-for="category in $root.getReviewConfig(status)?.categories" class="ts-form-group review-categories">
						<label>{{ category.label }} <span v-if="ratings[category.key]">{{ ratings[category.key].label }}</span></label>
						<ul class="rs-stars simplify-ul flexify">
							<li class="flexify"
								v-for="level in $root.getReviewConfig(status)?.rating_levels"
								@click.prevent="ratings[category.key] = ( ratings[category.key] === level ) ? null : level"
								:class="{'active': isRatingActive(level, category), 'selected': isRatingSelected(level, category)}"
								:style="{'--active-accent': isRatingActive(level, category) ? ratings[category.key].color : null}"
							>
								<template v-if="isRatingActive(level, category)">
									<div class="ts-star-icon" v-html="$root.getReviewConfig(status)?.active_icon || $root.getReviewConfig(status)?.default_icon"></div>
								</template>
								<template v-else>
									<div  class="ts-star-icon" v-html="$root.getReviewConfig(status)?.inactive_icon || $root.getReviewConfig(status)?.default_icon"></div>
								</template>
								<div class="ray-holder">
									<div class="ray"></div>
									<div class="ray"></div>
									<div class="ray"></div>
									<div class="ray"></div>
									<div class="ray"></div>
									<div class="ray"></div>
									<div class="ray"></div>
									<div class="ray"></div>
								</div>
							</li>
						</ul>
					</div>
				</template>
				<template v-else>
					<div v-for="category in $root.getReviewConfig(status)?.categories" class="ts-form-group review-categories">
						<label>{{ category.label }}</label>
						<ul class="rs-num simplify-ul flexify">
							<li
								v-for="level in $root.getReviewConfig(status)?.rating_levels"
								@click.prevent="ratings[category.key] = ( ratings[category.key] === level ) ? null : level"
								:class="{'active': isRatingSelected(level, category)}"
								:style="{'--active-accent': isRatingSelected(level, category) ? level.color : null}"
							>
								{{ level.score + 3 }}
								<span>{{ level.label }}</span>
							</li>
						</ul>
					</div>
				</template>
			</template>
			<div class="ts-form-group" v-if="$root.config.postSubmission.gallery">
				<a @click.prevent="showFiles = !showFiles" href="#" class="ts-btn ts-btn-4 create-btn">
					<?= \Voxel\get_icon_markup( $this->get_settings_for_display('ts_media_ico') ) ?: \Voxel\svg( 'gallery.svg' ) ?>
					<span><?= _x( 'Attach images', 'media library', 'voxel' ) ?></span>
				</a>
			</div>
			<div v-if="$root.config.postSubmission.gallery" class="ts-form-group">

				<field-file
					v-show="showFiles"
					:field="files"
					:sortable="false"
					ref="files"
					class="ts-status-files"
					:media-target="$refs.submitInput"
				></field-file>
			</div>
		</template>
	</form-group>
</script>
