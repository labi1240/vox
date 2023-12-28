<?php
/**
 * Search filters - component template.
 *
 * @since 1.0
 */
if ( ! defined('ABSPATH') ) {
	exit;
} ?>
<script type="text/html" id="post-type-search-order-template">
    
    <div class="x-row">
    	    <div class="used-fields x-col-6">
    	        <div class="sub-heading">
    	            <p>Search orders</p>
    	        </div>
    	        <div class="field-container" ref="fields-container">
    	            <draggable v-model="$root.config.search.order" group="order" handle=".field-head" item-key="key" @start="dragStart" @end="dragEnd">
    	                <template #item="{element: order}">
    	                    <div :class="{open: isActive(order)}" class="single-field wide">
    	                        <div class="field-head" @click="toggleActive(order)">

    	                            <p class="field-name">{{ order.label }}</p>
    	                            <span class="field-type">{{ order.key }}</span>
    	                            <div class="field-actions">
    		                            <span class="field-action all-center">
    		                                <a href="#" @click.prevent="deleteOrderingOption(order)">
    		                                   <i class="lar la-trash-alt icon-sm"></i>
    		                                </a>
    		                            </span>
    		                        </div>
    	                        </div>
    	                        <div v-if="isActive(order)" class="field-body">
    	                            <div class="x-row">
    									<?php \Voxel\Form_Models\Text_Model::render( [
    										'v-model' => 'order.label',
    										'label' => 'Label',
    										'classes' => 'x-col-12',
    									] ) ?>

    									<?php \Voxel\Form_Models\Text_Model::render( [
    										'v-model' => 'order.placeholder',
    										'label' => 'Placeholder',
    										'classes' => 'x-col-6',
    									] ) ?>

    									<?php \Voxel\Form_Models\Key_Model::render( [
    										'v-model' => 'order.key',
    										'label' => 'Form Key',
    										'description' => 'Enter a unique form key',
    										'classes' => 'x-col-6',
    									] ) ?>



    						            <draggable v-if="order.clauses.length" v-model="order.clauses" group="clauses" handle=".field-head" item-key="key" @start="dragStart" @end="dragEnd" class="x-col-12">
    						                <template #item="{element: clause}">
    						                    <div :class="{open: activeClause === clause}" class="single-field wide">
    						                        <div class="field-head" @click="activeClause = (activeClause === clause) ? null : clause">

    						                            <p class="field-name">{{ clause.type }}</p>
    						                            <span class="field-type">{{ clause.type }}</span>
    		                            				<div class="field-actions">
    							                            <span class="field-action all-center">
    							                                <a href="#" @click.prevent="deleteClause(clause, order)">
    							                                  <i class="lar la-trash-alt icon-sm"></i>
    							                                </a>
    							                            </span>
    							                        </div>
    						                        </div>
    						                        <div v-if="activeClause === clause" class="field-body">
    						                            <div class="x-row">
    														<?= $orderby_options_markup ?>
    													</div>
    												</div>
    											</div>
    										</template>
    									</draggable>

    						            <div class="ts-form-group x-col-12">
    						            	<label v-if="order.clauses.length === 0">Order by:</label>
    						            	<label v-if="order.clauses.length === 1">Add secondary clause:</label>
    						            	<label v-if="order.clauses.length >= 2">
    						            		Add another clause
    						            	</label>
    						            	<div class="add-field">
    						            		<a
    						            			v-for="clause in $root.options.orderby_types"
    						            			@click.prevent="addClause(clause, order)"
    						            			href="#"
    						            			class="ts-button ts-outline"

    						            		>
    						            		    {{ getClauseLabel( clause ) }}
    						            		</a>
    						            	</div>


    						            </div>
    						            <?php \Voxel\Form_Models\Icon_Model::render( [
    						            	'v-model' => 'order.icon',
    						            	'label' => 'Icon',
    						            	'classes' => 'x-col-12',
    						            ] ) ?>
    	                            </div>
    	                        </div>
    	                    </div>
    	                </template>
    	            </draggable>
    	        </div>
    	    </div>
    	    <div class="x-col-1"></div>
    	    <div class="x-col-5">
    	        <div class="available-fields-container">
    	            <div class="sub-heading">
    	                <p>Add search order</p>
    	            </div>
    	            <div class="add-field">
    	                <div v-for="preset in $root.options.orderby_presets" class="">
    	                    <div @click.prevent="addPresetOption(preset)" class="ts-button ts-outline">
    	                        {{ preset.label }}
    	                    </div>
    	                </div>

    	                <div class="">
    	                	<a href="#" @click.prevent="addOrderingOption" class="ts-button ts-outline">Custom order</a>
    	                </div>
    	            </div>
    	        </div>
    	    </div>
    </div>
</script>