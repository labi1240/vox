!function(t){"function"==typeof define&&define.amd?define("visitsChart",t):t()}(function(){"use strict";window.render_visits_chart=()=>{Array.from(document.querySelectorAll(".ts-visits-chart")).forEach(t=>{t.__vue_app__||(t=>{let r=JSON.parse(t.closest(".elementor-widget-container").querySelector(".vxconfig").innerHTML);return Vue.createApp({el:t,mixins:[Voxel.mixins.base],data(){return{loading:!1,charts:r.charts,view_type:r.view_type,active_chart:r.charts[r.active_chart]?r.active_chart:"7d",activeItem:null,scrollArea:{isDown:!1,scrollLeft:null,startX:null}}},mounted(){this.$nextTick(()=>this.dragScroll())},methods:{loadChart(e){this.loading=!0,jQuery.get(Voxel_Config.ajax_url+"&action=tracking.get_chart_data",{source:r.source,post_id:r.post_id,timeframe:e,view_type:r.view_type,_wpnonce:r.nonce}).always(t=>{this.loading=!1,t.success?this.charts[e]=t.data:(this.charts[e].error=!0,Voxel.alert(t.message||Voxel_Config.l10n.ajaxError,"error"))})},showPopup(t,e){this.activeItem=e;e=t.target.getBoundingClientRect();this.$refs.popup.style.left=e.left+e.width+10+"px",this.$refs.popup.style.top=e.top+"px"},hidePopup(){this.activeItem=null},dragScroll(){let e=this.$refs.scrollArea;e&&(e.addEventListener("mouseup",()=>this.scrollArea.isDown=!1),e.addEventListener("mouseleave",()=>this.scrollArea.isDown=!1),e.addEventListener("mousedown",t=>{this.scrollArea.isDown=!0,this.scrollArea.startX=t.pageX-e.offsetLeft,this.scrollArea.scrollLeft=e.scrollLeft}),e.addEventListener("mousemove",t=>{this.scrollArea.isDown&&(t.preventDefault(),t=t.pageX-e.offsetLeft-this.scrollArea.startX,e.scrollLeft=this.scrollArea.scrollLeft-t)}),requestAnimationFrame(()=>e.scrollLeft=e.scrollWidth))}},computed:{currentChart(){return!1===this.charts[this.active_chart].loaded&&this.loadChart(this.active_chart),this.charts[this.active_chart]}},watch:{currentChart(){this.$nextTick(()=>this.dragScroll())}}})})(t).mount(t)})},window.render_visits_chart(),jQuery(document).on("voxel:markup-update",window.render_visits_chart)});