!function(e){"function"==typeof define&&define.amd?define("generalSettings",e):e()}(function(){"use strict";var i={template:"#product-type-rate-list-template",props:["modelValue","mode","source"],data(){return{loading:!1,open:!1,rates:null,first_item:null,is_last_page:!1}},methods:{show(){this.open=!0,this.loading=!0,null===this.rates&&jQuery.get(Voxel_Config.ajax_url,{action:this.source,mode:this.mode},e=>{this.loading=!1,this.is_last_page=!e.has_more,this.rates=e.rates,this.first_item=this.rates?.[0]?.id})},toggle(e){var t=this.modelValue.indexOf(e.id);-1<t?this.modelValue.splice(t,1):this.modelValue.push(e.id)},isSelected(e){return-1<this.modelValue.indexOf(e.id)},remove(e){e=this.modelValue.indexOf(e);-1<e&&this.modelValue.splice(e,1)},prev(){this.loading=!0;var e=this.rates[0].id;jQuery.get(Voxel_Config.ajax_url,{action:this.source,mode:this.mode,ending_before:e},e=>{this.loading=!1,this.has_more=e.has_more,e.rates.length&&(this.rates=e.rates,this.is_last_page=!1)})},next(){this.loading=!0;var e=this.rates[this.rates.length-1].id;jQuery.get(Voxel_Config.ajax_url,{action:this.source,mode:this.mode,starting_after:e},e=>{this.loading=!1,this.has_more=e.has_more,e.rates.length&&(this.rates=e.rates,this.is_last_page=!e.has_more)})}}},s={template:"#vx-settings-share-menu",data(){return{active:null,presets:this.$root.config.editor.share.presets}},methods:{toggleActive(e){return this.active=e===this.active?null:e},usePreset(e){var t=this.presets[e];t&&this.$root.config.share.networks.push({type:e,key:e,label:t.label,icon:""})},deleteItem(t){this.$root.config.share.networks=this.$root.config.share.networks.filter(e=>e!==t)},isUsed(t){return!!this.$root.config.share.networks.find(e=>e.key===t)},addHeading(){this.$root.config.share.networks.push({type:"ui-heading",key:"ui-"+Math.random().toString(10).substr(2,5),label:"Heading"})},dragStart(){this.$refs["fields-container"].classList.add("drag-active")},dragEnd(){this.$refs["fields-container"].classList.remove("drag-active")}}},a={template:`
		<div class="ts-icon-picker ts-icon-picker-vue">
			<div class="icon-preview" v-html="previewMarkup" @click.prevent="openLibrary" :title="modelValue"></div>

				<a href="#" @click.prevent="uploadSVG" class="ts-button ts-outline">Upload SVG</a>
				<a v-if="allowFonticons !== false" href="#" @click.prevent="openLibrary" class="ts-button ts-outline">Choose Icon</a>
				<a v-if="modelValue" href="#" @click.prevent="clear" class="ts-button ts-outline icon-only"><i class="lar la-trash-alt icon-sm"></i></a>

		</div>
	`,props:["modelValue","allowFonticons"],data(){return{previewMarkup:""}},created(){this.preview(this.modelValue)},methods:{preview(e){Voxel_Icon_Picker.getIconPreview(e,e=>this.previewMarkup=e)},openLibrary(){Voxel_Icon_Picker.edit(this.modelValue,e=>{this.setValue(e.library+":"+e.value)})},uploadSVG(){Voxel_Icon_Picker.getSVG(e=>{this.setValue("svg:"+e.id)})},clear(){this.setValue("")},setValue(e){this.preview(e),this.$emit("update:modelValue",e)}}},o={template:`
		<input type="text" readonly :value="modelValue" @click="edit">
	`,props:["modelValue","tagGroups"],data(){return{previewMarkup:""}},methods:{edit(){var t={};Array.isArray(this.tagGroups)?this.tagGroups.forEach(e=>{DTags.groups[e]&&(t[e]=DTags.groups[e])}):t=this.tagGroups||null,DTags.edit(this.modelValue,e=>{this.$emit("update:modelValue",e)},t)}}};document.addEventListener("DOMContentLoaded",()=>{var e,t=document.getElementById("vx-general-settings");t&&((e=Vue.createApp({el:t,data(){return{config:null,state:{},tab:null,webhooks:{tab:"live",liveDetails:!1,testDetails:!1,editLiveDetails:!1,editTestDetails:!1},portal:{editIds:!1},db:{showAdvanced:!1},ipgeo:{activeProvider:null}}},created(){this.config=jQuery.extend(!0,this.config,JSON.parse(this.$options.el.dataset.config)),this.tab=this.config.tab},methods:{editFooterText(e){let t=e.target.placeholder;DTags.edit(this.config.emails.footer_text||t,e=>{this.config.emails.footer_text=e===t?"":e},{site:Dynamic_Tag_Groups.site})},removeMenuLocation(e){confirm(Voxel_Config.l10n.confirmAction)&&this.config.nav_menus.custom_locations.splice(e,1)},checkEndpointStatus(t,i=!1){let s=this.$refs[t+"EndpointStatus"];s?.classList.add("vx-disabled"),jQuery.get(Voxel_Config.ajax_url,{action:i?"general.stripe.connect_endpoint_status":"general.stripe.endpoint_status",mode:t}).always(e=>{s?.classList.remove("vx-disabled"),e.success?(e.id&&(this.config.stripe.webhooks[t+(i?"_connect":"")].id=e.id),e.secret&&(this.config.stripe.webhooks[t+(i?"_connect":"")].secret=e.secret),Voxel_Backend.alert(e.message)):Voxel_Backend.alert(e.message||Voxel_Config.l10n.ajaxError,"error")})},tagGroup(e){return window.DTags?.groups[e]},addIpGeoProvider(e){this.config.ipgeo.providers.push({key:e.key})},getIpGeoProvider(t){return this.config.editor.ipgeo.providers.find(e=>e.key===t)},deleteIpGeoProvider(t){this.config.ipgeo.providers=this.config.ipgeo.providers.filter(e=>e.key!==t)},purgeStatsCache(t){t.target?.classList.add("vx-disabled"),jQuery.post(Voxel_Config.ajax_url+"&action=backend.statistics.purge_cache").always(e=>{t.target?.classList.remove("vx-disabled"),e.success?Voxel_Backend.alert(e.message):Voxel_Backend.alert(e.message||Voxel_Config.l10n.ajaxError,"error")})}},computed:{remainingIpGeoProviders(){return this.config.editor.ipgeo.providers.filter(t=>!this.config.ipgeo.providers.find(e=>e.key===t.key))}},watch:{tab(){this.config.tab=this.tab;var e=new URL(window.location);e.searchParams.set("tab",this.tab),window.history.replaceState(null,null,e)}}})).component("rate-list",i),e.component("share-menu",s),e.component("draggable",vuedraggable),e.component("icon-picker",a),e.component("field-key",Voxel_Backend.components.Field_Key),e.component("dtag-input",o),e.mount(t))})});
