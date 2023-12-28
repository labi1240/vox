<script type="text/html" id="dtags-use-loop-item">
	<div class="x-row all-center">
		<div class="x-col-7">
			<div class="pick-tag min-scroll">
				<div class="x-row">
					<div class="x-col-12">
						<ul class="inner-tabs">
							<template v-for="group in $root.groups">
								<li :class="{'current-item': $root.activeGroup === group}">
									<a href="#" @click.prevent="$root.activeGroup = group">{{ group.title }}</a>
								</li>
							</template>
						</ul>
					</div>
					<div v-if="$root.activeGroup" class="x-col-12">
						<div class="x-row">
							<div class="x-col-12">
								<template v-if="$root.activeGroup._has_loopables">
									<loopable-list
										:properties="$root.activeGroup.properties"
										:path="['@'+$root.activeGroup.key]"
										@select="useItem($event)"
										:container="this"
									></loopable-list>
								</template>
								<template v-else>
									<div class="ts-spacer"></div>
									<div class="text-center">
										<p>No loopable properties found</p>
									</div>
								</template>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</script>

<script type="text/html" id="dtags-loopable-list">
	<template v-for="property, key in properties">
		<div v-if="key !== ':default' && (property.loopable || property._has_loopables)"  class="single-field" :class="{
            stack: property.type === 'object',
            'active-item': isActive(property, key),
        }">
			<div class="field-head x-grow" @click.prevent="propertyClick( property, key )">
				<p class="field-name">{{ property.label }}</p>
				<span class="field-type">{{ key }}</span>
				<div class="field-actions">
					<a href="#" v-if="property._has_loopables" class="field-action all-center">
						<i class="las la-arrow-down"></i>
					</a>
					<a href="#" v-if="property.loopable" @click.stop.prevent="selectProperty(property, key)" class="field-action all-center field-action-button">
						Use loop
					</a>
				</div>
			</div>
			<div v-if="property.type === 'object' && property._has_loopables && container.activeStack[depth] === property" class="field-body">
				<div class="">
					<loopable-list
						:properties="property.properties"
						:path="path.concat([key])"
						@select="$emit('select', $event)"
						:container="container"
					></loopable-list>
				</div>
			</div>
		</div>
	</template>
</script>
