<script type="text/html" id="search-form-terms-filter">
	<template v-if="filter.props.display_as === 'inline'">
		<div class="ts-form-group inline-terms-wrapper ts-inline-filter min-scroll">
			<label v-if="$root.config.showLabels" class="">{{ filter.label }}</label>
			<!-- <div class="flexify ts-input-icon" v-if="terms.length >= 15">
				<input v-model="search" ref="searchInput" type="text" placeholder="<?= esc_attr( _x( 'Search categories', 'terms filter', 'voxel' ) ) ?>" class="inline-input">
			</div> -->
			<div v-if="searchResults" class="ts-term-dropdown ts-multilevel-dropdown inline-multilevel">
				<ul class="simplify-ul ts-term-dropdown-list">
					<li v-for="term in searchResults" :class="{'ts-selected': !!value[term.slug]}">
						<a href="#" class="flexify" @click.prevent="selectTerm( term )">
							<div class="ts-checkbox-container">
								<label :class="filter.props.multiple ? 'container-checkbox' : 'container-radio'">
									<input
										:type="filter.props.multiple ? 'checkbox' : 'radio'"
										:value="term.slug"
										:checked="value[ term.slug ]"
										disabled
										hidden
									>
									<span class="checkmark"></span>
								</label>
							</div>
							<span>{{ term.label }}</span>
							<div class="ts-term-icon">
								<span v-html="term.icon"></span>
							</div>
						</a>
					</li>

				</ul>
				<div v-if="!searchResults.length" class="ts-empty-user-tab">
					<span v-html="filter.icon"></span>
					<p><?= _x( 'No results found', 'terms filter', 'voxel' ) ?></p>
				</div>
			</div>
			<div v-else class="ts-term-dropdown ts-multilevel-dropdown inline-multilevel">
				<term-list :terms="terms" list-key="toplevel" key="toplevel"></term-list>
			</div>
		</div>
	</template>
	<form-group v-else :popup-key="filter.id" ref="formGroup" @save="onSave" @blur="saveValue" @clear="onClear" :wrapper-class="repeaterId" v-bind="{ 'controller-class': filter.props.multiple ? null : 'hide-d' }">
		<template #trigger>
			<label v-if="$root.config.showLabels" class="">{{ filter.label }}</label>
	 		<div class="ts-filter ts-popup-target" @mousedown="$root.activePopup = filter.id" :class="{'ts-filled': filter.value !== null}">
				<span v-html="filter.icon"></span>
	 			<div class="ts-filter-text">
	 				<template v-if="filter.value">
	 					{{ firstLabel }}
	 					<span v-if="remainingCount > 0" class="term-count">
	 						+{{ remainingCount.toLocaleString() }}
	 					</span>
	 				</template>
	 				<template v-else>{{ filter.props.placeholder }}</template>
	 			</div>
	 			<div class="ts-down-icon"></div>
	 		</div>
	 	</template>
		<template #popup>
			<div class="ts-sticky-top uib b-bottom" v-if="terms.length >= 15">
				<div class="ts-input-icon flexify">
					<?= \Voxel\get_icon_markup( $this->get_settings_for_display('ts_sf_form_btn_icon_in') ) ?: \Voxel\svg( 'search.svg' ) ?>
					<input v-model="search" ref="searchInput" type="text" placeholder="<?= esc_attr( _x( 'Search categories', 'terms filter', 'voxel' ) ) ?>" class="autofocus">
				</div>
			</div>
			<div v-if="searchResults" class="ts-term-dropdown ts-multilevel-dropdown ts-md-group">
				<ul class="simplify-ul ts-term-dropdown-list">
					<li v-for="term in searchResults" :class="{'ts-selected': !!value[term.slug]}">
						<a href="#" class="flexify" @click.prevent="selectTerm( term )">
							<div class="ts-checkbox-container">
								<label :class="filter.props.multiple ? 'container-checkbox' : 'container-radio'">
									<input
										:type="filter.props.multiple ? 'checkbox' : 'radio'"
										:value="term.slug"
										:checked="value[ term.slug ]"
										disabled
										hidden
									>
									<span class="checkmark"></span>
								</label>
							</div>
							<span>{{ term.label }}</span>
							<div class="ts-term-icon">
								<span v-html="term.icon"></span>
							</div>
						</a>
					</li>
				</ul>
				<div v-if="!searchResults.length" class="ts-empty-user-tab">
					<span v-html="filter.icon"></span>
					<p><?= _x( 'No results found', 'terms filter', 'voxel' ) ?></p>
				</div>
			</div>
			<div v-else class="ts-term-dropdown ts-multilevel-dropdown ts-md-group">
				<term-list :terms="terms" list-key="toplevel" key="toplevel"></term-list>
			</div>
		</template>
	</form-group>
</script>

<script type="text/html" id="search-form-terms-filter-list">
	<transition :name="'slide-from-'+termsFilter.slide_from" @beforeEnter="beforeEnter($event, listKey)" @beforeLeave="beforeLeave($event, listKey)">
		<ul
			v-if="termsFilter.active_list === listKey"
			:key="listKey"
			class="simplify-ul ts-term-dropdown-list"
		>
			<li v-if="termsFilter.active_list !== 'toplevel'" class="ts-term-centered">
				<a href="#" class="flexify" @click.prevent="goBack">
      	            <div class="ts-left-icon"></div>
      	            <span><?= __( 'Go back', 'voxel' ) ?></span>
	  	        </a>
			</li>

			<li v-if="parentTerm" class="ts-parent-item">
				<a href="#" class="flexify" @click.prevent="termsFilter.selectTerm( parentTerm )">
					<div class="ts-checkbox-container">
						<label :class="termsFilter.filter.props.multiple ? 'container-checkbox' : 'container-radio'">
							<input
								:type="termsFilter.filter.props.multiple ? 'checkbox' : 'radio'"
								:value="parentTerm.slug"
								:checked="termsFilter.value[ parentTerm.slug ]"
								disabled
								hidden
							>
							<span class="checkmark"></span>
						</label>
					</div>

					<span><?= _x( 'All in', 'terms filter', 'voxel' ) ?> {{ parentTerm.label }}</span>
					<div class="ts-term-icon">
						<span v-html="parentTerm.icon"></span>
					</div>
				</a>
			</li>
			<template v-for="term, index in terms">
				<li v-if="index < (page*perPage)" :class="{'ts-selected': !!termsFilter.value[term.slug] || term.hasSelection}">
					<a href="#" class="flexify" @click.prevent="selectTerm( term )">
						<div class="ts-checkbox-container">
							<label :class="termsFilter.filter.props.multiple ? 'container-checkbox' : 'container-radio'">
								<input
									:type="termsFilter.filter.props.multiple ? 'checkbox' : 'radio'"
									:value="term.slug"
									:checked="termsFilter.value[ term.slug ] || term.hasSelection"
									disabled
									hidden
								>
								<span class="checkmark"></span>
							</label>
						</div>
						<span>{{ term.label }}</span>
						<div class="ts-right-icon" v-if="term.children && term.children.length"></div>
						<div class="ts-term-icon">
							<span v-html="term.icon"></span>
						</div>
					</a>
				</li>
			</template>
			<li v-if="(page*perPage) < terms.length">
				<a href="#" @click.prevent="page++" class="ts-btn ts-btn-4">
					<span><?= \Voxel\get_icon_markup( $this->get_settings_for_display('ts_timeline_load_icon') ) ?: \Voxel\svg( 'reload.svg' ) ?></span>
					<?= __( 'Load more', 'voxel' ) ?>
				</a>
			</li>
		</ul>
	</transition>
	<term-list
		v-for="term in termsWithChildren"
		:terms="term.children"
		:parent-term="term"
		:previous-list="listKey"
		:list-key="'terms_'+term.id"
		:key="'terms_'+term.id"
	></term-list>
</script>
