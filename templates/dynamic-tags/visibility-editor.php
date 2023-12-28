<script type="text/html" id="dtags-visibility-editor">
	<div class="x-row">
		<div class="x-col-7">
			<div class="condition-col">
				<div v-for="group, group_key in conditions" class="condition-group">
					<div class="ts-group-head">
						<h3>Rule group</h3>

					</div>

					<div v-for="condition, condition_key in group" class="single-condition">
						<div class="x-row">
							<div class="ts-form-group x-col-3 x-grow">
								<label>Condition</label>
								<a
									href="#"
									@click.prevent="activePopup = ( activePopup === condition ? null : condition )"
									class="ts-button ts-outline"
									:class="{'con-active': activePopup === condition}"
								>
									<span v-if="$root.rules[ condition.type ]">
										{{ $root.rules[ condition.type ].label }}
									</span>
									<span v-else>Choose condition</span>
								</a>
								<div v-if="activePopup === condition">
									<teleport to="#visibility-sidebar">
										<div class="ts-visibility-source x-row">
											<div class="field-options-control x-col-12">
												<a href="#" class="ts-button ts-faded ts-btn-small icon-only" @click.prevent="condition.type = null; activePopup = null;">
													<i class="las la-trash-alt icon-sm"></i>
												</a>
												<a href="#" class="ts-button btn-shadow ts-save-settings ts-btn-small icon-only" @click.prevent="activePopup = null;">
													<i class="las la-save icon-sm"></i>
												</a>
											</div>
											<div class="x-col-12 add-field">
												<template v-for="rule in $root.rules">
													<a
														href="#"
														@click.prevent="condition.type = rule.type; setProps(condition); activePopup = null;"
														class="ts-button ts-outline"
													>{{ rule.label }}</a>
												</template>
											</div>
											<!-- <div>
												<a href="#" @click.prevent="activePopup = null;" class="ts-button">Save</a>
												<a href="#" @click.prevent="condition.type = null; activePopup = null;" class="ts-button ts-transparent">Clear</a>
											</div> -->
										</div>
									</teleport>
								</div>
							</div>

							<?php foreach ( $visibility_rules as $rule ): ?>
								<template v-if="condition.type === <?= esc_attr( wp_json_encode( $rule->get_type() ) ) ?>">
									<?php $rule->render_settings() ?>
								</template>
							<?php endforeach ?>

							<div class="ts-form-group x-col-3 x-grow-0 delete-condition">
								<label>&nbsp;</label>
								<a
								href="#"
								@click.prevent="removeCondition( condition_key, group, group_key )"
								class="ts-button ts-outline icon-only"
								>
									<i class="lar la-trash-alt"></i>

								</a>

							</div>
						</div>

					</div>
					<div class="x-row">
						<div class="x-col-12">
							<a
								href="#"
								@click.prevent="group.push( { type: '' } )"
								class="add-condition ts-button ts-dashed "
							>
								<i class="las la-code-branch icon-sm"></i>
								Add condition
							</a>
						</div>
					</div>
				</div>

				<div class="x-row">
					<div class="x-col-12">
						<a href="#" @click.prevent="addRuleGroup" class="ts-button ts-dashed ">
							<i class="las la-layer-group icon-sm"></i> Add rule group
						</a>
					</div>
				</div>

				<!-- <div class="ts-form-group x-col-12">
					<pre debug>{{ conditions }}</pre>
				</div> -->
			</div>
		</div>

		<div class="x-col-5">
			<div class="pick-tag min-scroll">

				<div id="visibility-sidebar"></div>
				<div class="nothing-to-show">
					<i class="las la-cog"></i>
					<p>No settings to show</p>
				</div>
			</div>
		</div>
	</div>
</script>
