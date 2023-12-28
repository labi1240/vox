<?php
/**
 * App events config screen.
 *
 * @since 1.0
 */

if ( ! defined('ABSPATH') ) {
	exit;
} ?>

<script type="text/javascript">
	var VX_APP_EVENT_TAG_GROUPS = <?= wp_json_encode( $tag_groups ) ?>;
</script>

<div id="vx-app-events" v-cloak data-config="<?= esc_attr( wp_json_encode( $config ) ) ?>">
	<div class="sticky-top">
		
		<div class="vx-head x-container">
			<h2>App events & Notifications</h2>
			<div class="">
				<input type="hidden" name="config" :value="state.submit_config">

				<input type="hidden" name="action" value="voxel_save_general_settings">
				<?php wp_nonce_field( 'voxel_save_general_settings' ) ?>

				<button @click.prevent="saveChanges" class="ts-button ts-save-settings btn-shadow" :class="{'vx-disabled': state.loading}">
					<i class="las la-save icon-sm"></i>
					Save changes
				</button>

			</div>
		</div>
			
		
	</div>
	<div class="ts-spacer"></div>
	<div class="x-container">
		<div class="x-row">
			<div class="x-col-4">
				<ul class="inner-tabs vertical-tabs">
					<template v-for="category in config.categories">
						<template v-if="category.children">
						<!-- 	<li :class="{'current-item': category.expanded}">
								<a href="#" @click.prevent="toggleCategory( category )">{{ category.label }}</a>
							</li> -->
							<template v-for="child in category.children">
								<li class="inner-child" :class="{'current-item': state.activeCategory === child.key}">
									<a href="#" @click.prevent="toggleCategory(child, category)">Orders: {{ child.label }}</a>
								</li>
							</template>
						</template>
						<template v-else>
							<li :class="{'current-item': state.activeCategory === category.key}">
								<a href="#" @click.prevent="toggleCategory( category )">{{ category.label }}</a>
							</li>
						</template>
					</template>
				</ul>
			</div>

			<div class="x-col-8">
				<template v-for="event in config.events">
					<div v-if="event.category === state.activeCategory" class="single-field wide" :class="{open: state.activeEvent === event}">
						<div class="field-head" @click.prevent="toggleEvent(event)">
							<p class="field-name">{{ event.label }}</p>
							<span class="field-type">{{ event.key }}</span>
							<div class="field-actions">
								<span class="field-action all-center">
									<a href="#" >
										<i class="las la-angle-down icon-sm"></i>
									</a>
								</span>
							</div>
						</div>
						<div v-if="state.activeEvent === event" class="field-body">
							<div v-if="event.showAdvanced" class="x-row">
								<div class="x-col-12">
									<div class="x-row">
										<div class="x-col-12">
											<a class="ts-button ts-outline" href="#" @click.prevent="event.showAdvanced = false"><i class="las la-backspace icon-sm"></i>Go back</a>
										</div>
										<div class="x-col-12 ts-form-group">
											<h3>Add a custom PHP handler for this event</h3>
											<p>Paste the following code in your plugin or child theme to get started.</p>
										</div>
									</div>

									
									<pre class="ts-snippet">
<span class="ts-gray ts-italic">// custom handler for event "{{ event.label }}"</span>
<span class="ts-blue">add_action</span>( <span class="ts-green">'voxel/app-events/{{ event.key }}'</span>, <span class="ts-purple">function</span>( <span class="ts-red">$event</span> ) {
	<span class="ts-gray ts-italic">// your custom code...</span>
} );</pre>
								</div>
							</div>
							<div v-else class="x-row">
								<div class="x-col-12">
									<ul class="inner-tabs" style="padding-bottom:0;">
										<li v-for="notification in event.notifications" :class="{'current-item': event.activeNotification === notification}">
											<a href="#" @click.prevent="event.activeNotification = notification">{{ notification.label }}</a>
										</li>
										<li>
											<a href="#" @click.prevent="event.showAdvanced = true">Advanced</a>
										</li>
									</ul>
								</div>

								<template v-for="notification in event.notifications">
									<template v-if="event.activeNotification === notification">
										<?php \Voxel\Form_Models\Switcher_Model::render( [
											'v-model' => 'notification.inapp.enabled',
											'label' => 'Send in-app notification',
											'classes' => 'x-col-12',
										] ) ?>

										<div v-if="notification.inapp.enabled" class="ts-form-group x-col-12">
											<label>In-app notification message</label>
											<textarea class="min-scroll" style="height: auto; padding: 15px;" 
												v-model="notification.inapp.subject"
												readonly
												:placeholder="notification.inapp.default_subject"
												@click.prevent="editTags(event, notification, 'inapp.subject', notification.inapp.default_subject)"
											></textarea>
										</div>

										<?php \Voxel\Form_Models\Switcher_Model::render( [
											'v-model' => 'notification.email.enabled',
											'label' => 'Send email notification',
											'classes' => 'x-col-12',
										] ) ?>

										<div v-if="notification.email.enabled" class="ts-form-group x-col-12">
											<label>Email notification subject</label>
											<textarea class="min-scroll" style="height: auto; padding: 15px;" 
												v-model="notification.email.subject"
												readonly
												:placeholder="notification.email.default_subject"
												@click.prevent="editTags(event, notification, 'email.subject', notification.email.default_subject)"
											></textarea>
										</div>

										<div v-if="notification.email.enabled" class="ts-form-group x-col-12">
											<label>Email notification message</label>
											<textarea class="min-scroll" style="height: 150px; padding: 15px;" 
												v-model="notification.email.message"
												readonly
												:placeholder="notification.email.default_message"
												@click.prevent="editTags(event, notification, 'email.message', notification.email.default_message)"
												style="height: 180px;"
											></textarea>
										</div>
									</template>
								</template>
							</div>
						</div>
					</div>
				</template>
			</div>
		</div>
	</div>
</div>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:ital@0;1&display=swap" rel="stylesheet">
