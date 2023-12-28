<script type="text/html" id="dtags-edit-tag">
	<div class="x-row">

		<div class="field-options-control x-col-12">
			<!-- <div class="sub-heading"><h3>Field settings</h3></div> -->

			<a href="#" class="ts-button ts-faded icon-only" @click.prevent="deleteTag">
				<i class="las la-trash-alt icon-sm"></i>

			</a>

			<a href="#" class="ts-button btn-shadow ts-save-settings icon-only" @click.prevent="saveTag">
				<i class="las la-save icon-sm"></i>

			</a>
		</div>
		<div class="x-col-12">
			<div class="field-option-head">
				<h3>{{tag.property.label}}</h3>
				<p>{{ pathText }}</p>
			</div>
		</div>
		<div class="x-col-12" ref="mods-container" v-if="tag.modifiers.length">
			<draggable v-model="tag.modifiers" group="modifiers" handle=".field-head" item-key="id" @start="onDragStart" @end="onDragEnd">
				<template #item="{element: mod, index: index}">
					<modifier :modifier="mod" :index="index" :editor="this" :tag="tag"></modifier>
				</template>
			</draggable>
		</div>
		<div class="x-col-12 add-field">
			<div class="ts-button ts-dashed full-width" @click.prevent="showMods = !showMods">
				Add mod
			</div>
		</div>
		<div v-if="showMods" class="add-field x-col-12">
			<template v-for="group in modGroups">
				<p style="width: 100%; opacity: .5; margin: 0; margin-top: 5px;">{{ group.label }}</p>
				<div
					v-for="modifier in group.modifiers"
					@click.prevent="useModifier( modifier )"
					class="ts-button ts-outline"
				>
						<p>{{ modifier.label }}</p>
						<!-- <p class="field-type">{{ modifier.description }}</p> -->
				</div>
			</template>

			<p style="width: 100%; opacity: .5; margin: 0; margin-top: 5px;">Conditionals</p>
			<template v-for="modifier in $root.modifiers">
				<div
					v-if="modifier.type === 'control-structure' && ['else','then'].indexOf(modifier.key) === -1"
					@click.prevent="useCondition( modifier )"
					class="ts-button ts-outline"
				>

						<p>{{ modifier.label }}</p>
						<!-- <p class="field-type">{{ modifier.description }}</p> -->

				</div>
			</template>
		</div>
	</div>








	<!-- <pre>{{ tag }}</pre> -->
</script>