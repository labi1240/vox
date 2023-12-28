<?php
/**
 * General settings - component template.
 *
 * @since 1.0
 */
if ( ! defined('ABSPATH') ) {
	exit;
} ?>
<script type="text/html" id="post-type-settings-template">
	<div class="ts-tab-content">
		<div class="x-row">
			<div class="x-col-12 ts-content-head">
				<h1>General</h1>
				<p>General settings related to this post type</p>
			</div>
		</div>

		<div class="x-row h-center">
				<div class="x-col-4">
					<ul class="inner-tabs vertical-tabs">
						<li :class="{'current-item': $root.subtab === 'base'}">
							<a href="#" @click.prevent="$root.setTab('general', 'base')">Basic</a>
						</li>
						<li :class="{'current-item': $root.subtab === 'submissions'}">
							<a href="#" @click.prevent="$root.setTab('general', 'submissions')">Post submission</a>
						</li>

						<li :class="{'current-item': $root.subtab === 'timeline'}">
							<a href="#" @click.prevent="$root.setTab('general', 'timeline')">Timeline</a>
						</li>
						<li :class="{'current-item': $root.subtab === 'reviews'}">
							<a href="#" @click.prevent="$root.setTab('general', 'reviews')">Reviews</a>
						</li>
						<li :class="{'current-item': $root.subtab === 'messages'}">
							<a href="#" @click.prevent="$root.setTab('general', 'messages')">Direct Messages</a>
						</li>
						<li :class="{'current-item': $root.subtab === 'map'}">
							<a href="#" @click.prevent="$root.setTab('general', 'map')">Map</a>
						</li>
						<li :class="{'current-item': $root.subtab === 'permalinks'}">
							<a href="#" @click.prevent="$root.setTab('general', 'permalinks')">Permalinks</a>
						</li>
						<li :class="{'current-item': $root.subtab === 'expiration'}">
							<a href="#" @click.prevent="$root.setTab('general', 'expiration')">Expiration rules</a>
						</li>
						<li :class="{'current-item': $root.subtab === 'revisions'}">
							<a href="#" @click.prevent="$root.setTab('general', 'revisions')">Revisions</a>
						</li>
						<li :class="{'current-item': $root.subtab === 'other'}">
							<a href="#" @click.prevent="$root.setTab('general', 'other')">Other</a>
						</li>
					</ul>
				</div>

				<div class="inner-tab x-col-8">
					<div v-if="$root.subtab === 'base'" class="">
						<div class="ts-group">
							<div class="ts-group-head">
								<h3>Basic</h3>
							</div>

							<div class="x-row">
								<div class="ts-form-group x-col-4">
									<label>Singular name</label>
								 	<input type="text" v-model="$root.config.settings.singular">
								</div>
								<div class="ts-form-group  x-col-4">
									<label>Plural name</label>
								 	<input type="text" v-model="$root.config.settings.plural">
								</div>
								<div class="ts-form-group  x-col-4">
									<label>Post type key</label>
								 	<input type="text" v-model="$root.config.settings.key" maxlength="20" required disabled>
								</div>
							</div>

						</div>
						<div class="ts-group">
							<div class="ts-group-head">
								<h3>Icon</h3>
							</div>
							<div class="x-row">
								<?php \Voxel\Form_Models\Icon_Model::render( [
									'v-model' => '$root.config.settings.icon',
									'classes' => 'x-col-12',

								] ) ?>
							</div>
						</div>
						<div class="ts-group">
							<div class="ts-group-head">
								<h3>Configuration</h3>
							</div>

							<div class="x-row">

								<div class="ts-form-group x-col-12">
									<ul class="basic-ul">
										<li>
											<a :href="exportRevision('current')" class="ts-button ts-outline">
											<i class="las la-download icon-sm"></i>Export config
										</a>
										</li>
										<li>
											<a href="#" @click.prevent="$root.$w.confirm('This will replace your existing post type configuration. Do you want to proceed?') ? $refs.importConfig.click() : ''" class="ts-button ts-outline">
												<i class="las la-cloud-upload-alt icon-sm"></i>Import config
											</a>
											<input type="file" ref="importConfig" @change="importConfig" class="hidden">
										</li>
										<li>
											<a href="#" @click.prevent="$root.setTab('general', 'revisions')" class="ts-button ts-outline">
											<i class="las la-history icon-sm"></i>Revisions
										</a>
										</li>
									</ul>
								</div>
								<div class="ts-form-group x-col-12">
									<p>The previous 15 revisions of the post type settings are stored automatically.</p>
								</div>
							</div>
						</div>
					</div>

					<div v-else-if="$root.subtab === 'expiration'" class="">
						<div class="ts-group">
							<div class="ts-group-head">
								<h3>Expiration rules</h3>
							</div>

							<template v-if="$root.config.settings.expiration.rules.length">
								<template v-for="rule in $root.config.settings.expiration.rules">
									<div v-if="isExpirationRuleValid(rule)" class="single-field wide" :class="{open: activeExpirationRule === rule}">
										<div class="field-head" @click.prevent="activeExpirationRule = ( activeExpirationRule === rule ) ? null : rule">
											<p class="field-name">{{ getExpirationRuleLabel(rule) }}</p>
											<div class="field-actions">
												<a href="#" @click.prevent.stop="deleteExpirationRule(rule)" class="field-action all-center">
													<i class="lar la-trash-alt icon-sm"></i>
												</a>
											</div>
										</div>
										<div v-if="activeExpirationRule === rule" class="field-body">
											<div class="x-row">
												<template v-if="rule.type === 'fixed'">
													<div class="ts-form-group x-col-12">
														<label>Expire posts after (days)</label>
														<input type="number" v-model="rule.amount">
													</div>
												</template>
												<template v-else>
													<div class="ts-form-group x-col-12">
														<p :title="rule.field">No additional settings available for this rule.</p>
													</div>
												</template>
											</div>
										</div>
									</div>
								</template>
							</template>
							<template v-else>
								<div class="ts-form-group">
									<p>No expiration rules have been configured for this post type</p>
								</div>
							</template>

							<template v-if="expirationRules.length">
								<div class="ts-spacer"></div>
								<div class="ts-group-head">
									<h3>Available rules</h3>
								</div>
								<div class="x-row x-col-12">
									<div class="add-field">
										<template v-for="rule in expirationRules">
											<a href="#" @click.prevent="addExpirationRule(rule)" class="ts-button ts-outline">{{ getExpirationRuleLabel( rule ) }}</a>
										</template>
									</div>
								</div>
							</template>
							<!-- <div class="x-row">
								<div class="x-col-12">
									<pre debug>{{ $root.config.settings.expiration }}</pre>
									<pre debug>{{ expirationRules }}</pre>
								</div>
							</div> -->
						</div>
					</div>
					<div v-else-if="$root.subtab === 'submissions'" class="">
						<div class="ts-group">
							<div class="ts-group-head">
								<h3>Submission settings</h3>
							</div>
							<div class="x-row">
								<?php \Voxel\Form_Models\Switcher_Model::render( [
									'v-model' => '$root.config.settings.submissions.enabled',
									'label' => 'Enable post submissions',
									'classes' => 'x-col-12',
									'description' => 'Allows users to submit posts of this post type through the frontend form',
								] ) ?>

								<?php \Voxel\Form_Models\Select_Model::render( [
									'v-model' => '$root.config.settings.submissions.status',
									'classes' => 'x-col-12',
									'label' => 'When a new post is submitted, set its status to',
									'choices' => [
										'publish' => 'Published: Post is published and publicly available immediately',
										'pending' => 'Pending Review: Admin review and approval is required before it\'s published',
									],
								] ) ?>

								<?php \Voxel\Form_Models\Select_Model::render( [
									'v-model' => '$root.config.settings.submissions.update_status',
									'label' => 'When an existing post is edited',
									'classes' => 'x-col-12',
									'choices' => [
										'publish' => 'Publish: Apply edits immediately and keep the post published',
										'pending' => 'Pending Review: Apply edits immediately and set the post status to pending',
										// 'pending_merge' => 'Pending Merge: Post remains published, but edits are not applied until the admin has reviewed and approved them.',
										'disabled' => 'Disabled: Posts cannot be edited',
									],
								] ) ?>

								<?php \Voxel\Form_Models\Switcher_Model::render( [
									'v-model' => '$root.config.settings.submissions.update_slug',
									'label' => 'Always update post slug when the post is updated',
									'classes' => 'x-col-12',
								] ) ?>

								<?php \Voxel\Form_Models\Switcher_Model::render( [
									'v-model' => '$root.config.settings.submissions.deletable',
									'classes' => 'x-col-12',
									'label' => 'Authors are allowed to delete their posts',
								] ) ?>
							</div>
						</div>
					</div>
					<div v-else-if="$root.subtab === 'timeline'" class="">


						<div class="ts-group">
							<div class="ts-group-head">
								<h3>Post timeline</h3>
							</div>
							<div class="x-row">

								<?php \Voxel\Form_Models\Switcher_Model::render( [
									'v-model' => '$root.config.settings.timeline.enabled',
									'label' => 'Enable post timeline',
									'classes' => 'x-col-12',
								] ) ?>

								<?php \Voxel\Form_Models\Select_Model::render( [
									'v-model' => '$root.config.settings.timeline.visibility',
									'label' => 'Visibility of timeline posts',
									'classes' => 'x-col-12',
									'choices' => [
										'public' => 'Public: Visible to everyone',
										'logged_in' => 'Logged-in: Visible to all logged in users',
										'followers_only' => 'Followers: Visible to post followers only',
										'private' => 'Private: Visible to post author only',
									],
								] ) ?>


							</div>

						</div>

						<div class="ts-group">
							<div class="ts-group-head">
								<h3>Wall posts</h3>
							</div>
							<div class="x-row">


								<?php \Voxel\Form_Models\Select_Model::render( [
									'v-model' => '$root.config.settings.timeline.wall',
									'label' => 'Allow wall posts',
									'classes' => 'x-col-12',
									'choices' => [
										'public' => 'From all logged-in users',
										'followers_only' => 'From followers only',
										'disabled' => 'Disabled',
									],
								] ) ?>

								<?php \Voxel\Form_Models\Select_Model::render( [
									'v-model' => '$root.config.settings.timeline.wall_visibility',
									'label' => 'Visibility of wall posts',
									'classes' => 'x-col-12',
									'choices' => [
										'public' => 'Public: Visible to everyone',
										'logged_in' => 'Logged-in: Visible to all logged in users',
										'followers_only' => 'Followers: Visible to post followers only',
										'private' => 'Private: Visible to post author only',
									],
								] ) ?>
							</div>
						</div>
					</div>
					<div v-else-if="$root.subtab === 'reviews'" class="">
						<div class="ts-group">
							<div class="ts-group-head">
								<h3>Post reviews</h3>
							</div>
							<div class="x-row">
								<?php \Voxel\Form_Models\Select_Model::render( [
									'v-model' => '$root.config.settings.timeline.reviews',
									'label' => 'Allow post reviews',
									'classes' => 'x-col-12',
									'choices' => [
										'public' => 'From all logged-in users',
										'followers_only' => 'From followers only',
										'disabled' => 'Disabled',
									],
								] ) ?>

								<?php \Voxel\Form_Models\Select_Model::render( [
									'v-model' => '$root.config.settings.timeline.review_visibility',
									'label' => 'Visibility of post reviews',
									'classes' => 'x-col-12',
									'choices' => [
										'public' => 'Public: Visible to everyone',
										'logged_in' => 'Logged-in: Visible to all logged in users',
										'followers_only' => 'Followers: Visible to post followers only',
										'private' => 'Private: Visible to post author only',
									],
								] ) ?>
							</div>
						</div>

						<div class="ts-group">
							<div class="ts-group-head">
								<h3>Review categories</h3>
							</div>

							<draggable
								v-model="$root.config.settings.reviews.categories"
								group="review_categories"
								handle=".field-head"
								item-key="key"
								@start=""
								@end=""
							>
								<template #item="{element: category, index: index}">
									<div class="single-field wide" :class="{open: activeReviewTab === category.key}">
										<div class="field-head" @click.prevent="activeReviewTab = ( activeReviewTab === category.key ) ? null : category.key">
											<p class="field-name">{{ category.label }}</p>
											<div v-if="category.key !== 'score'" class="field-actions" @click.prevent.stop="deleteReviewCategory( category.key )">
												<a href="#" class="field-action all-center">
													<i class="lar la-trash-alt icon-sm"></i>
												</a>
											</div>
										</div>
										<div v-if="activeReviewTab === category.key" class="field-body">
											<div class="x-row">
												<div class="ts-form-group x-col-12">
													<label>Label</label>
													<input type="text" v-model="category.label">
												</div>

												<?php \Voxel\Form_Models\Key_Model::render( [
													'editable' => 'category.key !== \'score\'',
													'v-model' => 'category.key',
													'classes' => 'x-col-12',
													'label' => 'Unique key',
												] ) ?>

												<?php \Voxel\Form_Models\Icon_Model::render( [
													'v-model' => 'category.icon',
													'classes' => 'x-col-12',
													'label' => 'Icon',
												] ) ?>

												<?php \Voxel\Form_Models\Switcher_Model::render( [
													'label' => 'Is required?',
													'classes' => 'x-col-12',
													'v-model' => 'category.required',
												] ); ?>
											</div>
										</div>
									</div>
								</template>
							</draggable>

							<div class="x-row x-col-12">
								<div class="add-field">
									<a href="#" class="ts-button ts-outline" @click.prevent="createReviewCategory">Add Category</a>
								</div>
							</div>
						</div>

						<div class="ts-group">
							<div class="ts-group-head">
								<h3>Rating levels</h3>
							</div>
							<div class="x-row">
								<?php foreach ( $post_type->reviews->get_default_rating_levels() as $key => $level ): ?>
									<div class="ts-form-group x-col-12">
										<label><strong><?= $level['label'] ?></strong></label>
										<div class="x-row">
											<?php \Voxel\Form_Models\Text_Model::render( [
												'v-model' => sprintf( '$root.config.settings.reviews.rating_levels.%s.label', $key ),
												'label' => 'Label',
												'classes' => 'x-col-6',
												'placeholder' => $level['label'],
											] ) ?>

											<?php \Voxel\Form_Models\Color_Model::render( [
												'v-model' => sprintf( '$root.config.settings.reviews.rating_levels.%s.color', $key ),
												'label' => 'Color',
												'classes' => 'x-col-6',
											] ) ?>
										</div>
									</div>
								<?php endforeach ?>
							</div>
						</div>

						<div class="ts-group">
							<div class="ts-group-head">
								<h3>Review settings</h3>
							</div>
							<div class="x-row">
								<?php \Voxel\Form_Models\Select_Model::render( [
									'v-model' => '$root.config.settings.reviews.input_mode',
									'label' => 'Review input mode',
									'classes' => 'x-col-12',
									'choices' => [
										'numeric' => 'Numeric',
										'stars' => 'Stars',
									],
								] ) ?>

								<template v-if="$root.config.settings.reviews.input_mode === 'stars'">
									<?php \Voxel\Form_Models\Icon_Model::render( [
										'v-model' => '$root.config.settings.reviews.icons.active',
										'classes' => 'x-col-12',
										'label' => 'Active icon',
										':allow-fonticons' => 'false',
									] ) ?>

									<?php \Voxel\Form_Models\Icon_Model::render( [
										'v-model' => '$root.config.settings.reviews.icons.inactive',
										'classes' => 'x-col-12',
										'label' => 'Inactive icon',
										':allow-fonticons' => 'false',
									] ) ?>
								</template>
							</div>
						</div>
					</div>

					<div v-else-if="$root.subtab === 'messages'" class="">
						<div class="ts-group">
							<div class="ts-group-head">
								<h3>Direct Messages</h3>
							</div>
							<div class="x-row">
								<?php \Voxel\Form_Models\Switcher_Model::render( [
									'v-model' => '$root.config.settings.messages.enabled',
									'label' => 'Enable messages',
									'classes' => 'x-col-12',
								] ) ?>
							</div>
						</div>


					</div>
					<div v-else-if="$root.subtab === 'map'" class="">
						<div class="ts-group">
							<div class="ts-group-head">
								<h3>Map marker</h3>
							</div>
							<div class="x-row">
								<?php \Voxel\Form_Models\Select_Model::render( [
									'v-model' => '$root.config.settings.map.marker_type',
									'label' => 'Marker type',
									'classes' => 'x-col-12',
									'choices' => [
										'icon' => 'Icon',
										'image' => 'Image',
										'text' => 'Text',
									],
								] ) ?>

								<?php \Voxel\Form_Models\Icon_Model::render( [
									'v-model' => '$root.config.settings.map.marker_icon',
									'v-if' => '$root.config.settings.map.marker_type === \'icon\'',
									'classes' => 'x-col-12',
									'label' => 'Marker icon',
								] ) ?>

								<div v-if="$root.config.settings.map.marker_type === 'image'" class="ts-form-group x-col-12">
									<label>Get image from field:</label>
									<select v-model="$root.config.settings.map.marker_image">
										<option v-for="field in $root.getFieldsByType('image')" :value="field.key">
											{{ field.label }}
										</option>
									</select>
								</div>

								<?php \Voxel\Form_Models\DTag_Model::render( [
									'v-model' => '$root.config.settings.map.marker_text',
									'v-if' => '$root.config.settings.map.marker_type === \'text\'',
									'classes' => 'x-col-12',
									'label' => 'Marker text',
								] ) ?>
							</div>
						</div>


					</div>
					<div v-else-if="$root.subtab === 'permalinks'" class="">

						<div class="ts-group">
							<div class="ts-group-head">
								<h3>Permalinks</h3>
							</div>
							<div class="x-row">
								<?php \Voxel\Form_Models\Switcher_Model::render( [
									'v-model' => '$root.config.settings.permalinks.custom',
									'label' => 'Custom permalink base',
									'classes' => 'x-col-12',
								] ) ?>

								<div v-if="$root.config.settings.permalinks.custom" class="ts-form-group x-col-12">
									<label>Permalink base</label>
									<input type="text" v-model="$root.config.settings.permalinks.slug">
								</div>
								<div class="ts-form-group x-col-12">
									<p><?= home_url('/') ?>{{ $root.config.settings.permalinks.slug }}/sample-post</p>
								</div>
							</div>
						</div>



					</div>
					<div v-else-if="$root.subtab === 'other'" class="">

						<div class="ts-group">
							<div class="ts-group-head">
								<h3>Gutenberg</h3>
							</div>
							<div class="x-row">
								<?php \Voxel\Form_Models\Select_Model::render( [
									'v-model' => '$root.config.settings.options.gutenberg',
									'label' => 'Gutenberg',
									'classes' => 'x-col-12',
									'choices' => [
										'auto' => 'Auto',
										'enabled' => 'Enabled',
									],
								] ) ?>
							</div>
						</div>

						<div class="ts-group">
							<div class="ts-group-head">
								<h3>Post excerpt</h3>
							</div>
							<div class="x-row">
								<?php \Voxel\Form_Models\Select_Model::render( [
									'v-model' => '$root.config.settings.options.excerpt',
									'label' => 'Post excerpt',
									'classes' => 'x-col-12',
									'choices' => [
										'auto' => 'Auto',
										'enabled' => 'Enabled',
									],
								] ) ?>
							</div>
						</div>

						<div class="ts-group">
							<div class="ts-group-head">
								<h3>Personal data export</h3>
							</div>
							<div class="x-row">
								<?php \Voxel\Form_Models\Switcher_Model::render( [
									'v-model' => '$root.config.settings.options.export_to_personal_data',
									'label' => 'Export to personal data',
									'classes' => 'x-col-12',
								] ) ?>
							</div>
						</div>

						<div class="ts-group">
							<div class="ts-group-head">
								<h3>Account deletion</h3>
							</div>
							<div class="x-row">
								<?php \Voxel\Form_Models\Select_Model::render( [
									'v-model' => '$root.config.settings.options.delete_with_user',
									'label' => 'Delete posts with user',
									'classes' => 'x-col-12',
									'choices' => [
										'auto' => 'Auto',
										'enabled' => 'Enabled',
										'disabled' => 'Disabled',
									],
								] ) ?>
							</div>
						</div>

						<div class="ts-group">
							<div class="ts-group-head">
								<h3>Archive</h3>
							</div>
							<div class="x-row">
								<?php \Voxel\Form_Models\Select_Model::render( [
									'v-model' => '$root.config.settings.options.default_archive_query',
									'label' => 'Native archive query',
									'description' => <<<TEXT
										If enabled, the native WordPress query will run in the post type archive page.

										This query is only necessary if you intend to display posts using the "WP default archive" mode of the Post feed (VX) widget.

										If you're instead using one of the "Search form", "Filters", or "Manual" modes, this query should be disabled to avoid any performance impact.
										TEXT,
									'classes' => 'x-col-12',
									'choices' => [
										'disabled' => 'Disabled (recommended)',
										'enabled' => 'Enabled',
									],
								] ) ?>
							</div>
						</div>
					</div>
					<div v-else-if="$root.subtab === 'revisions'" class="">
						<template v-if="$root.options.revisions.length">
							<div v-for="revision in $root.options.revisions" class="ts-group">
								<div class="x-row">
									<div class="ts-form-group x-col-12">
										<p style="margin-bottom: 15px;">Revision by {{ revision.author }} on {{ revision.date }}</p>
										<ul class="basic-ul">
											<li>
												<a :href="rollbackRevision(revision.timestamp)" onclick="return confirm('This will replace your existing post type configuration. Do you want to proceed?')" class="ts-button ts-outline">
													<i class="las la-cloud-upload-alt icon-sm"></i>Rollback
												</a>
											</li>
											<li>
												<a :href="exportRevision(revision.timestamp)" class="ts-button ts-outline">
													<i class="las la-download icon-sm"></i>Export
												</a>
											</li>
											<li>
												<a href="#" @click.prevent="removeRevision(revision)" class="ts-button ts-outline">
													<i class="las la-trash icon-sm"></i>Remove
												</a>
											</li>
										</ul>
									</div>

								</div>

							</div>
						</template>
						<template v-else>
							<div class="single-revision ts-group">
								<div class="x-row">
									<div class="ts-form-group x-col-12">
										<p>No revisions made to this post type yet.</p>
									</div>
								</div>
							</div>
						</template>


					</div>
				</div>

		</div>
	</div>
</script>
