<script type="text/html" id="dtags-data-sources">


	<div class="x-row">
		<div class="x-col-12">
			<ul class="inner-tabs">
				<li v-for="group in $root.groups" :class="{'current-item': $root.activeGroup === group}">
					<a href="#" @click.prevent="$root.activeGroup = group">{{ group.title }}</a>
				</li>
			</ul>
		</div>

		<div v-if="$root.activeGroup" class="x-col-12">
			<div class="x-row">
				<div class="ts-form-group x-col-12">
					<input type="text" v-model="search" placeholder="Search by name">
				</div>
				<div v-if="search.trim().length" class="x-col-12">
					<div class="ts-form-group">
						<label class="d-search-title">Searching for "{{search}}"</label>
					</div>
					<div class="ts-form-group" v-for="properties, group_key in searchProperties()">
						<label class="d-search-title">{{ $root.groups[ group_key ].title }}</label>
						<property-list
							:properties="properties"
							:path="['@'+group_key]"
							@select="$emit('select', $event)"
						></property-list>
					</div>
				</div>
				<div v-else class="x-col-12">
					<property-list
						:properties="$root.activeGroup.properties"
						:path="['@'+$root.activeGroup.key]"
						@select="$emit('select', $event)"
					></property-list>

					<div class="method-list">
						<div v-for="method in $root.activeGroup.methods" class="single-field">
							<div class="field-head" @click.prevent="useMethod(method)">
								<p class="field-name">{{ method.label }}</p>
								<span class="field-type">{{ method.key }}()</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</script>
