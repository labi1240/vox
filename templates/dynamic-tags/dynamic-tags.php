<?php

if ( ! defined('ABSPATH') ) {
	exit;
}

wp_enqueue_script( 'sortable' );
wp_enqueue_script( 'vue-draggable' );
wp_enqueue_script( 'vx:dynamic-tags.js' );

$groups = array_map( function( $group_class ) {
	$group = new $group_class;

	if ( \Voxel\is_dev_mode() && isset( $_GET['post_type'] ) ) {
		$group->set_post_type( \Voxel\Post_Type::get( $_GET['post_type'] ) );
	}

	return $group;
}, \Voxel\config('dynamic_tags.groups') );

$config = \Voxel\Dynamic_Tags\Dynamic_Tags::get_frontend_config();
$modifiers = \Voxel\Dynamic_Tags\Dynamic_Tags::get_modifier_instances();
$visibility_rules = \Voxel\Dynamic_Tags\Dynamic_Tags::get_visibility_rule_instances();
$rules_config = [];
foreach ( $visibility_rules as $rule ) {
	$rules_config[ $rule->get_type() ] = $rule->get_editor_config();
}
?>

<script type="text/javascript">
	window.Dynamic_Tag_Groups = <?= wp_json_encode( $config ) ?>;
	window.Dynamic_Tag_Modifiers = <?= wp_json_encode( array_map( function( $modifier ) {
		return $modifier->get_editor_config();
	}, $modifiers ) ) ?>;
	window.Dynamic_Tag_Rules = <?= wp_json_encode( $rules_config ) ?>;
</script>

<?php require locate_template( 'templates/dynamic-tags/content-editor.php' ) ?>
<?php require locate_template( 'templates/dynamic-tags/visibility-editor.php' ) ?>
<?php require locate_template( 'templates/dynamic-tags/edit-tag.php' ) ?>
<?php require locate_template( 'templates/dynamic-tags/modifier.php' ) ?>
<?php require locate_template( 'templates/dynamic-tags/property-list.php' ) ?>
<?php require locate_template( 'templates/dynamic-tags/data-sources.php' ) ?>
<?php require locate_template( 'templates/dynamic-tags/use-loop-item.php' ) ?>

<script type="text/html" id="dtags-template">
	<div v-if="visible" id="dynamic-tags-modal" class="ts-theme-options ts-field-modal">
		<div class="modal-backdrop"></div> <!-- @click="discard" -->
		<div class="modal-content min-scroll">
			<div class="x-container">
				<template v-if="mode === 'use-loop-item'">
					<div class="x-row">
						<div class="x-col-12">
							<div class="field-modal-head">
								<h2>Select loop source</h2>
								<div>
									<a href="#" class="ts-button ts-transparent" @click.prevent="discard">
										Discard
									</a>
								</div>
							</div>
						</div>
					</div>
				</template>
				<template v-else-if="mode === 'visibility'">
					<div class="x-row">
						<div class="x-col-12">
							<div class="field-modal-head">
								<h2>Conditions</h2>
								<div>
									<a href="#" class="ts-button ts-transparent" @click.prevent="discard">
										Discard
									</a>
									<a href="#" class="ts-button btn-shadow ts-save-settings" @click.prevent="save">
										<i class="las la-save icon-sm"></i>
										Save changes
									</a>
								</div>
							</div>
						</div>
					</div>
				</template>
				<template v-else>
					<div class="x-row">
						<div class="x-col-12">
							<div class="field-modal-head">
								<h2>Dynamic content</h2>
								<div>
									<a href="#" class="ts-button ts-transparent" @click.prevent="discard">
										Discard
									</a>
									<a href="#" class="ts-button btn-shadow ts-save-settings" @click.prevent="save">
										<i class="las la-save icon-sm"></i>
										Save changes
									</a>
								</div>
							</div>
						</div>
					</div>
				</template>
				<div class="x-row">
					<div v-if="mode === 'visibility'" class="x-col-12 ts-dynamic-visibility">
						<visibility-editor ref="visibilityEditor"></visibility-editor>
					</div>
					<div v-else-if="mode === 'use-loop-item'" class="x-col-12 ts-dynamic-loopables">
						<use-loop-item ref="useLoopItem"></use-loop-item>
					</div>
					<div v-else class="engine-modal-tab x-col-12">
						<div class="x-row">
							<div class="x-col-6">
								<content-editor ref="contentEditor"></content-editor>
							</div>

							<div class="x-col-6">
								<div class="pick-tag min-scroll">
									<data-sources
										v-if="!activeTag"
										@select="$refs.contentEditor.insertContent($event+'&nbsp;')"
									></data-sources>
									<div v-if="activeTag" class="edit-tag">
										<edit-tag :tag="activeTag"></edit-tag>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</script>

<div id="dtags-container"></div>
