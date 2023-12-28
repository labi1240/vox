<script type="text/html" id="dtags-property-list">
	<template v-for="property, key in properties">
		<div v-if="key !== ':default'"  class="single-field" :class="{
            stack: property.type === 'object',
            open: ( activeStack === property ) || ( property.description && property._show_description ),
            'x-inner-tag': depth > 0,
            'list-all': property.list,
        }">
			<div class="field-head x-grow" @click.prevent="propertyClick( property, key )">
				<p class="field-name">{{ property.label }}</p>
				<span class="field-type">{{ key }}</span>
				<div class="field-actions">
					<a href="#" v-if="property.description" @click.stop.prevent="property._show_description = !property._show_description" class="field-action all-center">
						<i class="las la-question-circle"></i>
					</a>

					<span v-if="property.type === 'object' && property.loopable" class="" title="Loopable" style="opacity: .5; ">
						Loopable
					</span>
					<span v-if="property.type === 'object'" class="">
						<i class="las la-arrow-down"></i>
					</span>
				</div>
			</div>
			<div class="field-head" v-if="property.list" @click.stop.prevent="propertyClick( property, key, true )">
				<p class="field-name">List all</p>
			</div>

			<div v-if="property.description && property._show_description" class="field-body">
				<p>{{ property.description }}</p>
			</div>
			<div v-if="property.type === 'object' && activeStack === property" class="field-body">
				<div class="">
					<property-list
						:properties="property.properties"
						:path="path.concat([key])"
						@select="$emit('select', $event)"
					></property-list>
				</div>
			</div>
		</div>
	</template>
</script>
