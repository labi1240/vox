<!-- Advanced list widget -->
<ul class="flexify simplify-ul ts-advanced-list">
	<?php foreach ($this->get_settings_for_display('ts_actions') as $i => $action):
		ob_start(); ?>
		<li class="elementor-repeater-item-<?= $action['_id'] ?> flexify ts-action elementor-column <?= $this->get_settings_for_display('ts_al_columns_no') ?>"
			<?php if ($action['ts_enable_tooltip'] === 'yes'): ?>
				data-tooltip="<?= esc_attr( $action['ts_tooltip_text'] ) ?>"
			<?php endif ?>
		><?php
		$start_action = ob_get_clean();
		$end_action = '</li>';
		?>

		<?php if ($action['ts_action_type'] === 'none'): ?>
			<?= $start_action ?>
			<div class="ts-action-con">
				<div class="ts-action-icon"><?php \Voxel\render_icon( $action['ts_acw_initial_icon'] ) ?></div><?= $action['ts_acw_initial_text'] ?>
			</div>
			<?= $end_action ?>
		<?php elseif ($action['ts_action_type'] === 'action_link'): ?>
			<?= $start_action ?>
			<?php $this->add_link_attributes( 'ts_action_link_'.$i, $action['ts_action_link'] ) ?>
			<a <?= $this->get_render_attribute_string( 'ts_action_link_'.$i ) ?> class="ts-action-con">
				<div class="ts-action-icon"><?php \Voxel\render_icon( $action['ts_acw_initial_icon'] ) ?></div>
				<?= $action['ts_acw_initial_text'] ?>
			</a>
			<?= $end_action ?>
		<?php elseif ($action['ts_action_type'] === 'back_to_top'): ?>
			<?= $start_action ?>
			<a href="#" onclick="window.scrollTo({top:0,behavior:'smooth'}); return false;" class="ts-action-con">
				<div class="ts-action-icon"><?php \Voxel\render_icon( $action['ts_acw_initial_icon'] ) ?></div>
				<?= $action['ts_acw_initial_text'] ?>
			</a>
			<?= $end_action ?>
		<?php elseif ($action['ts_action_type'] === 'go_back'): ?>
			<?= $start_action ?>
			<a href="javascript:history.back();" class="ts-action-con">
				<div class="ts-action-icon"><?php \Voxel\render_icon( $action['ts_acw_initial_icon'] ) ?></div>
				<?= $action['ts_acw_initial_text'] ?>
			</a>
			<?= $end_action ?>
		<?php elseif ($action['ts_action_type'] === 'scroll_to_section'): ?>
			<?= $start_action ?>
			<a href="#" onclick="Voxel.scrollTo(document.getElementById(<?= esc_attr( wp_json_encode( $action['ts_scroll_to'] ) ) ?>)); return false;" class="ts-action-con">
				<div class="ts-action-icon"><?php \Voxel\render_icon( $action['ts_acw_initial_icon'] ) ?></div>
				<?= $action['ts_acw_initial_text'] ?>
			</a>
			<?= $end_action ?>
		<?php elseif ($action['ts_action_type'] === 'direct_message'): ?>
			<?php require locate_template( 'templates/widgets/advanced-list/direct-message-action.php' ) ?>
		<?php elseif ($action['ts_action_type'] === 'direct_message_user'): ?>
			<?php require locate_template( 'templates/widgets/advanced-list/direct-message-user-action.php' ) ?>
		<?php elseif ($action['ts_action_type'] === 'action_save'): ?>
			<?php require locate_template( 'templates/widgets/advanced-list/save-post-action.php' ) ?>
		<?php elseif ($action['ts_action_type'] === 'edit_post'): ?>
			<?php require locate_template( 'templates/widgets/advanced-list/edit-post-action.php' ) ?>
		<?php elseif ($action['ts_action_type'] === 'view_post_stats'): ?>
			<?php require locate_template( 'templates/widgets/advanced-list/view-post-stats-action.php' ) ?>
		<?php elseif ($action['ts_action_type'] === 'delete_post'): ?>
			<?php require locate_template( 'templates/widgets/advanced-list/delete-post-action.php' ) ?>
		<?php elseif ($action['ts_action_type'] === 'publish_post'): ?>
			<?php require locate_template( 'templates/widgets/advanced-list/publish-post-action.php' ) ?>
		<?php elseif ($action['ts_action_type'] === 'unpublish_post'): ?>
			<?php require locate_template( 'templates/widgets/advanced-list/unpublish-post-action.php' ) ?>
		<?php elseif ($action['ts_action_type'] === 'relist_post'): ?>
			<?php require locate_template( 'templates/widgets/advanced-list/relist-post-action.php' ) ?>
		<?php elseif ($action['ts_action_type'] === 'share_post'): ?>
			<?php require locate_template( 'templates/widgets/advanced-list/share-post-action.php' ) ?>
		<?php elseif ($action['ts_action_type'] === 'action_follow'): ?>
			<?php require locate_template( 'templates/widgets/advanced-list/follow-user-action.php' ) ?>
		<?php elseif ($action['ts_action_type'] === 'action_follow_post'): ?>
			<?php require locate_template( 'templates/widgets/advanced-list/follow-post-action.php' ) ?>
		<?php elseif ($action['ts_action_type'] === 'action_gcal'): ?>
			<?php require locate_template( 'templates/widgets/advanced-list/add-to-gcal-action.php' ) ?>
		<?php elseif ($action['ts_action_type'] === 'action_ical'): ?>
			<?php require locate_template( 'templates/widgets/advanced-list/add-to-ical-action.php' ) ?>
		<?php elseif ($action['ts_action_type'] === 'select_addition'): ?>
			<?= $start_action ?>
			<a role="button" href="#" class="ts-action-con ts-use-addition" data-id="<?= esc_attr( $action['ts_addition_id'] ) ?>">
				<span class="ts-initial">
					<div class="ts-action-icon"><?php \Voxel\render_icon( $action['ts_acw_initial_icon'] ) ?></div><?= $action['ts_acw_initial_text'] ?>
				</span>
				<span class="ts-reveal">
					<div class="ts-action-icon"><?php \Voxel\render_icon( $action['ts_acw_reveal_icon'] ) ?></div><?= $action['ts_acw_reveal_text'] ?>
				</span>
			</a>
			<?= $end_action ?>
		<?php endif ?>
	<?php endforeach ?>
</ul>
