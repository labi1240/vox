<?php
require_once locate_template( 'templates/widgets/create-post/_media-popup.php' );
require_once locate_template( 'templates/widgets/timeline/create-status.php' );
require_once locate_template( 'templates/widgets/timeline/create-reply.php' );
require_once locate_template( 'templates/widgets/timeline/status-replies.php' );
require_once locate_template( 'templates/widgets/timeline/file-field.php' );
require_once locate_template( 'templates/widgets/timeline/single-status.php' );
?>

<div class="ts-social-feed" data-config="<?= esc_attr( wp_json_encode( $config ) ) ?>" id="tl:<?= esc_attr( $this->get_id() ) ?>">
	<template v-if="!isSingle">
		<?php if ( is_user_logged_in() ): ?>
			<div v-if="config.user.can_post" class="ts-form ts-add-status">
				<template v-if="existingReview">
					<create-status ref="existingReview" class="ts-form-group ts-no-padding" :status="existingReview.status" :index="existingReview.index" custom-popup-key="edit-existing-review">
						<?= \Voxel\get_icon_markup( $this->get_settings_for_display('ts_create_icon') ) ?: \Voxel\svg( 'newspaper.svg' ) ?>
						<div class="ts-filter-text"><?= $this->get_settings_for_display('add_status_text') ?></div>
					</create-status>
				</template>
				<template v-else>
					<create-status class="ts-form-group ts-no-padding" custom-popup-key="create-status-new">
						<?= \Voxel\get_icon_markup( $this->get_settings_for_display('ts_create_icon') ) ?: \Voxel\svg( 'newspaper.svg' ) ?>
						<div class="ts-filter-text"><?= $this->get_settings_for_display('add_status_text') ?></div>
					</create-status>
				</template>
			</div>
		<?php else: ?>
			<div class="ts-form ts-add-status ts-join-discussion">
				<div class="ts-form-group ts-form-group ts-no-padding">
					<a class="ts-filter" href="#" @click.prevent="joinDiscussion">
						<?= \Voxel\get_icon_markup( $this->get_settings_for_display('ts_create_icon') ) ?: \Voxel\svg( 'newspaper.svg' ) ?>
						<div class="ts-filter-text">
							<?= $this->get_settings_for_display('ts_join_discussion_text') ?>
						</div>
					</a>
				</div>
			</div>
		<?php endif ?>

		<div v-if="orderingOptions.length >= 2" class="ts-timeline-tabs">
			<ul class="flexify simplify-ul ts-generic-tabs" :class="{'vx-inert': statuses.loading}">
				<li v-for="order in orderingOptions" :class="{'ts-tab-active': activeOrder === order}">
					<a @click.prevent="setActiveOrder(order)" href="#">{{ order.label }}</a>
				</li>
			</ul>
		</div>
	</template>
	<div class="ts-status-list">
		<template v-if="!statuses.list.length">
			<div class="ts-no-posts">
				<template v-if="statuses.loading">
					<span class="ts-loader"></span>
				</template>
				<template v-else>
					<?= \Voxel\get_icon_markup( $this->get_settings_for_display('ts_create_icon') ) ?: \Voxel\svg( 'newspaper.svg' ) ?>
					<p><?= $this->get_settings_for_display('no_status_text') ?></p>
				</template>
			</div>
		</template>
		<template v-else>
			<single-status v-for="status, index in statuses.list" :status="status" :index="index"></single-status>
			<a
				href="#"
				v-if="statuses.hasMore"
				@click.prevent="statuses.page++; getStatuses();"
				class="ts-load-more ts-btn ts-btn-1"
				:class="{'vx-pending': statuses.loading}"
			>
				<?= \Voxel\get_icon_markup( $this->get_settings_for_display('ts_timeline_load_icon') ) ?: \Voxel\svg( 'reload.svg' ) ?>
				<?= __( 'Load more', 'voxel' ) ?>
			</a>
		</template>
	</div>
</div>
